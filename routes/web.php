<?php

// Use System Library
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Config;

// Use Controller file
    use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Profile_config\config_background;
use App\Http\Controllers\Profile_config\config_language;
use App\Http\Controllers\Profile_info\set_address;
use App\Models\config_profile;
use App\Models\location;
use App\Models\User;
use Illuminate\Support\Facades\DB;

// Use Model file


// root route
Route::get('/', function () {

    return view('home');
})->name('MainPage');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Language route
Route::get('change/{locale}', function ($locale) {
    session()->put('locale', $locale);
    return redirect()->back();
});

// Frontend route
Route::post('/register', [RegisterController::class , 'req_Register'])->name('submit-register');

// Authen route
Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

    /* call file in storage or call API */
    Route::get('get-image/{id}', function ($id) {
        $tmp_image = public_path("img/Profile/$id");
        $ImageName = $id;

        $headers = [
            "file_type" => 'png'
        ];
        return response()->download($tmp_image, $ImageName, $headers);
    })->name('GetImage');

// Backend route
Route::middleware(['auth'])->group(function () {
    Route::get('Profile/{type}', function ($type) {

    // set data
        $tmp_config = config_profile::all()
                            ->where('profile_id' , Auth::user()->profile_id)
                            ->where('config_type' , 'BC')
                            ->whereNull('exp_date')
                            ->toArray();
        foreach ($tmp_config as $config) {
            $tmp = decrypt($config["config_desc"]);
            $ConfigProfile = json_decode($tmp);
        }

        $master = User::all()->where('profile_id' , Auth::user()->profile_id)->toArray();

        foreach ($master as $pf) {
            $profile_id = $pf["profile_id"];
            $profile_location = $pf["location_id"];
        }

        if ($type == "about") {

            $addr_province = DB::table('profile_t_location')
                ->select('province_code', 'province_th' , 'province_en')
                ->distinct()
                ->get();
            $addr_amphoe = DB::table('profile_t_location')
                ->select('district_code', 'district_th', 'district_en' , 'province_code')
                ->distinct()
                ->get();
            $addr_district = DB::table('profile_t_location')
                ->select('sub_district_code', 'sub_district_th', 'sub_district_en', 'district_code' , 'province_code')
                ->distinct()
                ->get();
            $addr_post_code = DB::table('profile_t_location')
                ->select('zip_code', 'sub_district_code')
                ->distinct()
                ->get();
            $location_det = location::all()->where('location_id' , $profile_location)->toArray();

            return view('Profile.template.1.about' , compact(
                'ConfigProfile' ,
                'master' ,
                'addr_province' ,
                'addr_amphoe' ,
                'addr_district' ,
                'addr_post_code' ,
                'location_det'
            ));
        } else if ($type == "awards") {
            return view('Profile.template.1.awards' , config(
                'ConfigProfile'
            ));
        } else if ($type == "education") {
            return view('Profile.template.1.education' , compact(
                'ConfigProfile'
            ));
        } else if ($type == "experience") {
            return view('Profile.template.1.experience' , compact(
                'ConfigProfile'
            ));
        } else if ($type == "portfolio") {
            return view('Profile.template.1.portfolio' , compact(
                'ConfigProfile'
            ));
        } else if ($type == "skills") {
            return view('Profile.template.1.skills' , compact(
                'ConfigProfile'
            ));
        } else {
            return redirect()->route('MainPage')->with('error' , trans('route_error.create_profile_error'));
        }
    })->name('MyProfile');

// Set Profile Lang
    Route::post('SetLanguageProfile', [config_language::class , 'SetLang'])->name('ctl.set.lang');

// Set profile color
    Route::post('SetColorProfile', [config_background::class , 'SetBackgroundColor'])->name('ctl.set.background');

// Set profile address
    Route::post('SetProfileAddress', [set_address::class , 'SetAddress'])->name('ctl.set.profileAddress');

});


