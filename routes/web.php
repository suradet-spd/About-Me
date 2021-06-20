<?php

// Use System Library
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Config;
    use Illuminate\Support\Facades\File;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\DB;

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
    use App\Models\social;
use GuzzleHttp\RetryMiddleware;

// root route
Route::get('/', function () {

    return view('home');
})->name('MainPage');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test', function () {
    return view('Profile.template.1.profile_type1');
});

Route::post('/', function (Request $req) {

    if (!$req->exists('_token')) {
        return redirect()->route('MainPage')->with('error' , trans('profile.LosingToken'));
    } else {
        if (!$req->exists('SearchTXT')) {
            return redirect()->route('MainPage')->with('error' , trans('home.ctl_return_req-name-profile'));
        } else if(strlen($req->get('SearchTXT')) < 5) {
            return redirect()->route('MainPage')->with('error' , trans('home.ctl_return_valid-minimum'));
        } else {
            $list_profile = DB::table('profile_t_master')
                            ->select('profile_id' , 'name_th' , 'name_en' , 'nickname')
                            ->where('gen_profile_flag' , 'Y')
                            ->where('name_en' , 'like' , '%' . $req->get('SearchTXT') . '%')
                            ->orWhere('name_th' , 'like' , '%' . $req->get('SearchTXT') . '%')
                            ->get()->toArray();

            if (!isset($list_profile)) {
                return redirect()->route('MainPage')->with('error' , trans('profile.ErrJsOther'));
            } else{
                if ($list_profile == null or $list_profile == "") {
                    return redirect()->route('MainPage')->with('error' , trans('home.ctl_profile_not_found'));
                } else {
                    return view('home' , compact('list_profile'));
                }

            }
        }
    }

})->name('search.profile');

// Frontend route
Route::post('/register', [RegisterController::class , 'req_Register'])->name('submit-register');

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

// Language route
Route::get('change/{locale}', function ($locale) {
    session()->put('locale', $locale);
    return redirect()->back();
});

// Authen route
Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

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
            $certificate = DB::table('profile_t_certificate')->where('profile_id' , Auth::user()->profile_id)->orderByDesc('cert_get_date')->get()->toArray();
        // Return to view

            return view('Profile.template.1.certificate' , compact(
                'ConfigProfile' ,
                'master' ,
                'modifyFlag' ,
                'certificate'
            ));
        } else if ($type == "education") {
            $learning_list = learning_list::all()->where('active_flag' , 'Y')->toArray();
            $education = DB::table('profile_t_education')->where('profile_id' , Auth::user()->profile_id)->orderByDesc('efft_date')->get()->toArray();

            return view('Profile.template.1.education' , compact(
                'ConfigProfile' ,
                'master' ,
                'modifyFlag' ,
                'learning_list' ,
                'education'
            ));
        } else if ($type == "experience") {
            $work = DB::table('profile_t_work')->where('profile_id' , $profile_id)->orderByDesc('work_start_date')->get()->toArray();

            return view('Profile.template.1.experience' , compact(
                'ConfigProfile' ,
                'master' ,
                'modifyFlag' ,
                'work'
            ));
        } else if ($type == "portfolio") {
            $portfolio = portfolio::all()->where('profile_id' , Auth::user()->profile_id)->toArray();

            return view('Profile.template.1.portfolio' , compact(
                'ConfigProfile' ,
                'master' ,
                'modifyFlag' ,
                'portfolio'
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

// delete data
    Route::get('delete/{type}/{id}/{seq}', function ($type , $id , $seq) {

        // validate id
        if ($id != str_pad(Auth::user()->profile_id , 5 , "0" , STR_PAD_LEFT)) {
            return redirect()->back()->with('error' , 'your id is invalid pls try again later!');
        } else {

        // Assign value [set table name]
            $table_name = ($type != null or $type != "") ? (($type == "work") ? "profile_t_work" : (($type == "education") ? "profile_t_education" : (($type == "portfolio") ? "profile_t_portfolio" : (($type == "certificate") ? "profile_t_certificate" : false)))) : false;

            if($table_name){

            // Assign tmp data
                $field_name = ($type == "work") ? "work_seq" : (($type == "education") ? "learning_list_id" : (($type == "portfolio") ? "portfolio_seq" : (($type == "certificate") ? "cert_seq" : false)));
                $tmp_file_name = ($type == "portfolio" or $type == "certificate") ? DB::table($table_name)->where('profile_id' , strval($id))->where($field_name , $seq)->select(($type == "portfolio") ? 'portfolio_images' : 'cert_images')->get()->toArray() : false;

                $delete_data = array(
                    "clear_data" => (DB::table($table_name)->where('profile_id' , $id)->where($field_name , $seq)->delete()) ? true : ((DB::table($table_name)->where('profile_id' , $id)->where($field_name , $seq)->count() == 0) ? true : false),
                    "clear_file" => false,
                );

                if ($tmp_file_name) {

                    foreach ($tmp_file_name as $tfn) {
                        $get_file_name = ($type == "portfolio") ? json_decode(decrypt($tfn->portfolio_images)) : json_decode(decrypt($tfn->cert_images));
                    }

                    foreach ($get_file_name as $gn) {
                        $delete_res = (File::delete(public_path('img/user-data/' . strval($id) . (($type == "portfolio") ? "/Portfolio/" : "/Certificate/") . $gn))) ? true : (!File::exists(public_path('img/user-data/' . strval($id) . (($type == "portfolio") ? "/Portfolio/" : "/Certificate/") . $gn)));

                        if (!$delete_res) {
                            $delete_data["clear_file"] = false;
                            break;
                        } else {
                            $delete_data["clear_file"] = true;
                        }
                    }
                } else {
                    $delete_data["clear_file"] = true;
                }

                if ($delete_data["clear_data"] == true and $delete_data["clear_file"] == true) {
                    return redirect()->back()->with('success' , 'Delete data complete');
                } else {
                    return redirect()->back()->with('error' , 'Can not delete data pls try again');
                }
            } else {
                return redirect()->back()->with('error' , 'some thing went wrong pls contact admin!');
            }
        }

    })->name('ctl.delete.data');

// reset profile
    Route::get('reset-profile', function () {

        $acc_id = str_pad(Auth::user()->profile_id,5,"0",STR_PAD_LEFT);
        $clear_data = array(
            "certificate" => (certificate::where('profile_id' , strval($acc_id))->delete()) ? true : ((certificate::all()->where('profile_id' , strval($acc_id))->count() == 0) ? true : false) ,
            "config" => (config_profile::where('profile_id' , strval($acc_id))->delete()) ? true : ((config_profile::all()->where('profile_id' , strval($acc_id))->count() == 0) ? true : false) ,
            "education" => (education::where('profile_id' , strval($acc_id))->delete()) ? true : ((education::all()->where('profile_id' , strval($acc_id))->count() == 0) ? true : false) ,
            "portfolio" => (portfolio::where('profile_id' , strval($acc_id))->delete()) ? true : ((portfolio::all()->where('profile_id' , strval($acc_id))->count() == 0) ? true : false) ,
            "social" => (social::where('profile_id' , strval($acc_id))->delete()) ? true : ((social::all()->where('profile_id' , strval($acc_id))->count() == 0) ? true : false) ,
            "work" => (work::where('profile_id' , strval($acc_id))->delete()) ? true : ((work::all()->where('profile_id' , strval($acc_id))->count() == 0) ? true : false) ,
            "profile" => (User::where('profile_id' , strval($acc_id))->update([
                "location_id" => "99999",
                "language_flag" => "N",
                "about_th" => null,
                "about_en" => null,
                "gen_profile_flag" => "N"
            ])) ? true : ((User::all()
                            ->where('profile_id' , strval($acc_id))
                            ->where('language_flag' , 'N')
                            ->where('gen_profile_flag' , 'N')->count() > 0) ? true : false),
        // check exists folder Portfolio
            "f_certificate" => (File::deleteDirectory(public_path('img/user-data/' . strval($acc_id) . '/Certificate'))) ? true : (!File::exists(public_path('img/user-data/' . strval($acc_id) . '/Certificate'))),
            "f_portfolio" => (File::deleteDirectory(public_path('img/user-data/' . strval($acc_id) . '/Portfolio'))) ? true : (!File::exists(public_path('img/user-data/' . strval($acc_id) . '/Portfolio'))),
        );

        foreach ($clear_data as $cd) {
            if (!$cd) {
                $tmp_res = false;
                break;
            } else {
                $tmp_res = true;
            }
        }

        if ($tmp_res) {
            return redirect()->route('MyProfile' , ['type'=> 'about'])->with('success' , trans('profile.ReturnResetComplete'));
        } else {
            return redirect()->route('MyProfile' , ['type'=> 'about'])->with('error' , trans('profile.ReturnResetFail'));
        }
    })->name('reset.profile');
});

// For another user view profile
Route::get('{user_name}/{type}', function ($user_name , $type) {

    // Set session
    Session::put('search_name' , $user_name);

    $tmp_name = str_replace("." , " " , $user_name);
    $tmp_id = User::all()->where('name_en' , $tmp_name)->where('gen_profile_flag' , 'Y')->toArray();

    foreach ($tmp_id as $ti) {
        $search_id = str_pad($ti["profile_id"],5,"0",STR_PAD_LEFT);
    }

    if (!isset($search_id)) {
        return redirect()->route('MainPage')->with('error' , trans('route_error.create_profile_error'));
    } else {

        $master = User::all()->where('profile_id' , strval($search_id))->toArray();
        $modifyFlag = false;

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
            $certificate = DB::table('profile_t_certificate')->where('profile_id' , strval($search_id))->orderByDesc('cert_get_date')->get()->toArray();

        // Return to view
            return view('Profile.template.1.certificate' , compact(
                'ConfigProfile' ,
                'master' ,
                'modifyFlag' ,
                'certificate'
            ));
        } else if ($type == "education") {
            $learning_list = learning_list::all()->where('active_flag' , 'Y')->toArray();
            $education = DB::table('profile_t_education')->where('profile_id' , strval($search_id))->orderByDesc('efft_date')->get()->toArray();

            return view('Profile.template.1.education' , compact(
                'ConfigProfile' ,
                'master' ,
                'modifyFlag' ,
                'learning_list' ,
                'education'
            ));
        } else if ($type == "experience") {
            $work = DB::table('profile_t_work')->where('profile_id' , $profile_id)->orderByDesc('work_start_date')->get()->toArray();

            return view('Profile.template.1.experience' , compact(
                'ConfigProfile' ,
                'master' ,
                'modifyFlag' ,
                'work'
            ));
        } else if ($type == "portfolio") {
            $portfolio = portfolio::all()->where('profile_id' , strval($search_id))->toArray();

            return view('Profile.template.1.portfolio' , compact(
                'ConfigProfile' ,
                'master' ,
                'modifyFlag' ,
                'portfolio'
            ));
        } else {
            return redirect()->route('MainPage')->with('error' , trans('route_error.create_profile_error'));
        }
}
})->name('ViewProfile');


