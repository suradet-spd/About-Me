<?php

namespace App\Http\Controllers\Profile_info;

use App\Http\Controllers\Controller;
use App\Models\work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class set_work_experience extends Controller
{
    private function ValidateForm(array $data){

        return Validator::make($data , [
            "office_name_th" => 'required_if:lang_flag,A,T' ,
            "office_name_en" => 'required_if:lang_flag,A,E' ,
            "position_name_th" => 'required_if:lang_flag,A,T' ,
            "position_name_en" => 'required_if:lang_flag,A,E' ,
            "work_desc_th" => 'required_if:lang_flag,A,T',
            "work_desc_en" => 'required_if:lang_flag,A,E'
        ] , $messages = [
            'office_name_th.required_if' => "pls enter office thai name",
            'office_name_en.required_if' => "pls enter office eng name",

            'position_name_th.required_if' => "pls enter position thai name",
            'position_name_en.required_if' => "pls enter position eng name",

            'work_desc_th.required_if' => "pls enter work desc thai",
            'work_desc_en.required_if' => "pls enter work desc eng",
        ])->validate();
    }

    public function SetWork(Request $req)
    {
    // validate form
        $this->ValidateForm($req->all());

    // validate token
        $tk = $req->exists('_token');
        if (!$tk) {

            return redirect()->back()->with('error' , 'Token is invalid pls try again!');

        } else {

            if ($tk != csrf_field()) {

                return redirect()->back()->with('error' , 'Token is not verify pls try again!');

            } else {

            // validate variable
                $lang_flag = $req->get('lang_flag');
                $tmp_data = array(
                    'office_name_th' => ($req->exists('office_name_th')) ? $req->get('office_name_th') : null ,
                    'office_name_en' => ($req->exists('office_name_en')) ? $req->get('office_name_en') : null ,
                    'start_date' => ($req->exists('start_date')) ? ($req->get('start_date') <= date('Y-m-d') ? $req->get('start_date') : null ) : null ,
                    'end_date' => ($req->exists('exp_date')) ? $req->get('exp_date') : null ,
                    'position_name_th' => ($req->exists('position_name_th')) ? $req->get('position_name_th') : null ,
                    'position_name_en' => ($req->exists('position_name_en')) ? $req->get('position_name_en') : null ,
                    'work_desc_th' => ($req->exists('work_desc_th')) ? $req->get('work_desc_th') : null ,
                    'work_desc_en' => ($req->exists('work_desc_en')) ? $req->get('work_desc_en') : null
                );

                $cnt_work = work::all()->where('profile_id' , Auth::user()->profile_id)->count();

                $ins_res = new work([
                    'profile_id' => DB::raw("LPAD('" . Auth::user()->profile_id . "' , 5 , 0)"),
                    'work_seq' => (intval($cnt_work) +1),
                    'work_name_th' => $tmp_data["position_name_th"],
                    'work_name_en' => $tmp_data["position_name_en"],
                    'work_office_th' => $tmp_data["office_name_th"],
                    'work_office_en' => $tmp_data["office_name_en"],
                    'work_desc_th' => $tmp_data["work_desc_th"],
                    'work_desc_en' => $tmp_data["work_desc_en"],
                    'work_start_date' => $tmp_data["start_date"],
                    'work_end_date' => $tmp_data["end_date"],
                    'upd_user_id' => DB::raw("LPAD('" . Auth::user()->profile_id . "' , 5 , 0)"),
                ]);

                $ins_res->save();

                // check result

                $chk_profile = work::all()->where('profile_id' , Auth::user()->profile_id)->where('work_seq' , (intval($cnt_work) + 1))->count();

                if ($chk_profile == 1) {
                    return redirect()->back()->with('success' , 'insert data complete');
                } else {
                    return redirect()->back()->with('error' , 'Something wentwrong');
                }


            }
        }
    }
}
