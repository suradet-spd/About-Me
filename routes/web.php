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
    use App\Http\Controllers\Profile_info\set_about;
    use App\Http\Controllers\Profile_info\set_address;
    use App\Http\Controllers\Profile_info\set_certificate;
    use App\Http\Controllers\Profile_info\set_education;
    use App\Http\Controllers\Profile_info\set_portfolio;
    use App\Http\Controllers\Profile_info\set_social;
    use App\Http\Controllers\Profile_info\set_work_experience;
    use Illuminate\Support\Facades\DB;

// Use Model file
    use App\Models\config_profile;
    use App\Models\education;
    use App\Models\learning_list;
    use App\Models\location;
    use App\Models\portfolio;
    use App\Models\social_list;
    use App\Models\User;
    use App\Models\work;
    use App\Models\certificate;

// root route
Route::get('/', function () {

    return view('home');
})->name('MainPage');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test', function () {
    return view('Profile.template.1.profile_type1');
});

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

    Route::get('get-port-image/{id}/{file_name}/{img_type}', function ($id , $file_name , $img_type) {

        $tmp_port_image = public_path("img/user-data/$id/$img_type/$file_name");
        $PortImageName = $file_name;

        $headers = [
            "file_type" => 'png'
        ];
        return response()->download($tmp_port_image, $PortImageName, $headers);
    })->name('GetDataImage');

// Backend route
Route::middleware(['auth'])->group(function () {
    Route::get('Profile/{type}', function ($type) {

        $master = User::all()->where('profile_id' , Auth::user()->profile_id)->toArray();
        $modifyFlag = true;

        foreach ($master as $pf) {
            $profile_id = $pf["profile_id"];
            $profile_location = $pf["location_id"];
        }

    // set data
        $tmp_config = config_profile::all()
                            ->where('profile_id' , $profile_id)
                            ->where('config_type' , 'BC')
                            ->whereNull('exp_date')
                            ->toArray();

        if ($tmp_config != null) {
            foreach ($tmp_config as $config) {
                $tmp = decrypt($config["config_desc"]);
                $ConfigProfile = json_decode($tmp);
            }
        } else {
            $ConfigProfile = json_decode("");
        }

        if ($type == "about") {

        // Declare Variable
            $addr_province = DB::table('profile_t_location')->select('province_code', 'province_th' , 'province_en')->distinct()->get();
            $addr_amphoe = DB::table('profile_t_location')->select('district_code', 'district_th', 'district_en' , 'province_code')->distinct()->get();
            $addr_district = DB::table('profile_t_location')->select('sub_district_code', 'sub_district_th', 'sub_district_en', 'district_code' , 'province_code')->distinct()->get();
            $addr_post_code = DB::table('profile_t_location')->select('zip_code', 'sub_district_code')->distinct()->get();
            $location_det = location::all()->where('location_id' , $profile_location)->toArray();
            $tmp_social = DB::table('profile_t_social')->where('profile_id' , $profile_id)->distinct()->get()->toArray();
            $social_list = social_list::all()->where('active_flag' , 'Y')->toArray();

        // Return to view
            return view('Profile.template.1.about' , compact(
                'ConfigProfile' ,
                'master' ,
                'modifyFlag' ,
                'addr_province' ,
                'addr_amphoe' ,
                'addr_district' ,
                'addr_post_code' ,
                'location_det' ,
                'social_list' ,
                'tmp_social'
            ));
        } else if ($type == "certificate") {

        // Declare Variable
            $certificate = certificate::all()->where('profile_id' , Auth::user()->profile_id)->toArray();
            $files_name[] = null;
            foreach ($certificate as $cc) {
                array_push($files_name , (json_decode(decrypt($cc["cert_images"]))));
            }
        // Return to view

            return view('Profile.template.1.certificate' , compact(
                'ConfigProfile' ,
                'master' ,
                'modifyFlag' ,
                'certificate' ,
                'files_name'
            ));
        } else if ($type == "education") {
            $learning_list = learning_list::all()->where('active_flag' , 'Y')->toArray();
            $education = education::all()->where('profile_id' , Auth::user()->profile_id)->toArray();

            return view('Profile.template.1.education' , compact(
                'ConfigProfile' ,
                'master' ,
                'modifyFlag' ,
                'learning_list' ,
                'education'
            ));
        } else if ($type == "experience") {
            $work = work::all()->where('profile_id' , $profile_id)->toArray();

            return view('Profile.template.1.experience' , compact(
                'ConfigProfile' ,
                'master' ,
                'modifyFlag' ,
                'work'
            ));
        } else if ($type == "portfolio") {
            $portfolio = portfolio::all()->where('profile_id' , Auth::user()->profile_id)->toArray();
            $files_name[] = null;
            foreach ($portfolio as $pf) {
                array_push($files_name , (json_decode(decrypt($pf["portfolio_images"]))));
            }

            return view('Profile.template.1.portfolio' , compact(
                'ConfigProfile' ,
                'master' ,
                'modifyFlag' ,
                'portfolio' ,
                'files_name'
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

// Set profile about
    Route::post('SetProfileAbout', [set_about::class , 'SetAbout'])->name('ctl.set.profileAbout');

// set profile social account
    Route::post('SetProfileSocialAccount', [set_social::class , 'SetSocialAccount'])->name('ctl.set.SocialAccount');

// set profile work experience
    Route::post('SetProfileWork', [set_work_experience::class , 'SetWork'])->name('ctl.set.work');

// set profile education
    Route::post('SetEducation', [set_education::class , 'SetEducation'])->name('ctl.set.education');

// set profile portfolio
    Route::post('SetPortfolio', [set_portfolio::class , 'SetPortfolio'])->name('ctl.set.portfolio');

// set profile certificate
    Route::post('SetCertificate', [set_certificate::class , 'SetCertificate'])->name('ctl.set.cert');
// set public profile
    Route::get('public-profile/{id}', function ($id) {

        if (str_pad($id,5,"0",STR_PAD_LEFT) == str_pad(Auth::user()->profile_id,5,"0",STR_PAD_LEFT)) {
            $profile = User::where('profile_id' , $id)
                        ->update([
                            "gen_profile_flag" => 'Y' ,
                            "last_upd_date" => DB::raw('CURRENT_TIMESTAMP()'),
                            "upd_user_id" => DB::raw("LPAD('" . Auth::user()->profile_id . "' , 5 , 0)")
                        ]);
            if ($profile == 0) {
                return redirect()->back()->with('error' , trans('profile.ValidatepublicMSGFail'));
            } else {
                return redirect()->back()->with('success' , trans('profile.VliadatepublicMSGSuccess'));
            }

        }
    })->name('public.profile');
});


