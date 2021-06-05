<?php

namespace App\Http\Controllers\Profile_info;

use App\Http\Controllers\Controller;
use App\Models\education;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class set_education extends Controller
{
    private function ValidateEducate(array $data){
        return Validator::make($data , [
            "learning_list" => ["required"] ,
            "college_name_th" => ["required_if:lang_flag,A,T" , "string" , "max:255" , "min:5"],
            "college_name_en" => ["required_if:lang_flag,A,E" , "string" , "max:255" , "min:5"],
            "faculty_name_th" => ["required_if:lang_flag,A,T" , "string" , "max:255" , "min:5"],
            "faculty_name_en" => ["required_if:lang_flag,A,E" , "string" , "max:255" , "min:5"],
            "gpa_value" => ["required"]

        ] , $messages = [
            "learning_list.required" => trans('profile.ctl_learning_list_req') ,

            "college_name_th.required" => trans('profile.ctl_college_name_th_req') ,
            "college_name_th.string" => trans('profile.ctl_str') ,
            "college_name_th.max" => trans('profile.ctl_college_name_th_max'),
            "college_name_th.min" => trans('profile.ctl_college_name_th_min') ,

            "college_name_en.required" => trans('profile.ctl_college_name_en_req') ,
            "college_name_en.string" => trans('profile.ctl_str') ,
            "college_name_en.max" => trans('profile.ctl_college_name_en_max') ,
            "college_name_en.min" => trans('profile.ctl_college_name_en_min') ,

            "faculty_name_th.required" => trans('profile.ctl_faculty_name_th_req') ,
            "faculty_name_th.string" => trans('profile.ctl_str') ,
            "faculty_name_th.max" => trans('profile.ctl_faculty_name_th_max') ,
            "faculty_name_th.min" => trans('profile.ctl_faculty_name_th_min') ,

            "faculty_name_en.required" => trans('profile.ctl_faculty_name_en_req') ,
            "faculty_name_en.string" => trans('profile.ctl_str') ,
            "faculty_name_en.max" => trans('profile.ctl_faculty_name_en_max') ,
            "faculty_name_en.min" => trans('profile.ctl_faculty_name_en_min') ,

            "gpa_value.required" => trans('profile.ctl_gpa_value_req')
        ])->validate();
    }

    public function SetEducation(Request $req)
    {
        if (!$req->exists('_token')) {
            // validate token not exists
            return redirect()->back()->with('error' , trans('profile.LosingToken'));
        } else if ($req->get('_token') != csrf_token() or $req->get('_token') == null) {
            // validate token
            return redirect()->back()->with('error' , trans('profile.ValidateToken'));
        } else {

            // Validate data
            $this->ValidateEducate($req->all());

            // variable
            $Educate = array(
                "profile_id" => DB::raw("LPAD('" . Auth::user()->profile_id . "' , 5 , 0)"),
                "learning_list" => ($req->exists('learning_list')) ? $req->get('learning_list') : null ,
                "efft_date" => ($req->exists('start_date')) ? $req->get('start_date') : null ,
                "exp_date" => ($req->exists('exp_date')) ? $req->get('exp_date') : null ,
                "college_name_th" => ($req->exists('college_name_th')) ? $req->get('college_name_th') : null ,
                "college_name_en" => ($req->exists('college_name_en')) ? $req->get('college_name_en') : null ,
                "faculty_name_th" => ($req->exists('faculty_name_th')) ? $req->get('faculty_name_th') : null ,
                "faculty_name_en" => ($req->exists('faculty_name_en')) ? $req->get('faculty_name_en') : null ,
                "gpa" => ($req->exists('gpa_value')) ? $req->get('gpa_value') : null,
                "upd_user_id" => DB::raw("LPAD('" . Auth::user()->profile_id . "' , 5 , 0)")
            );

            $ins_res = new education([
                'profile_id' => $Educate["profile_id"],
                'learning_list_id' => $Educate["learning_list"],
                'efft_date' => $Educate["efft_date"],
                'exp_date' => $Educate["exp_date"],
                'college_name_th' => $Educate["college_name_th"],
                'college_name_en' => $Educate["college_name_en"],
                'faculty_name_th' => $Educate["faculty_name_th"],
                'faculty_name_en' => $Educate["faculty_name_en"],
                'gpa' => $Educate["gpa"],
                'upd_user_id' => $Educate["upd_user_id"],
            ]);

            $ins_res->save();

            // check result
            $chk_res = education::all()->where('profile_id' , Auth::user()->profile_id)->where('learning_list_id' , $Educate["learning_list"])->where('efft_date' , $Educate["efft_date"])->count();

            if ($chk_res == 0) {
                return redirect()->back()->with('error' , trans('profile.msg_error_return'));
            } else {
                return redirect()->back()->with('success' , trans('profile.msg_success_return'));
            }

        }
    }
}
