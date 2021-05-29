<?php

namespace App\Http\Controllers\Profile_info;

use App\Http\Controllers\Controller;
use App\Models\social;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class set_social extends Controller
{
    public function SetSocialAccount(Request $req)
    {
        $get_social_type = $req->get('social_select');
        $link_detail = $req->get('profile_link');

        if ($get_social_type == "" or $get_social_type == null) {
            return redirect()->back()->with('error' , trans('profile.JsValidateSocialOption'));
        } else if ($link_detail == "" or $link_detail == null) {
            return redirect()->back()->with('error' , trans('profile.JsValidateSocialUrl'));
        } else {
            //check duplicate
            $chk_dup = social::all()
                        ->where('profile_id' , Auth::user()->profile_id)
                        ->where('social_list_id' , $get_social_type)
                        ->count();
            if ($chk_dup > 0) {
                return redirect()->back()->with('error' , trans('profile.MsgDuplicateSocial'));
            } else {
                $insert_res = new social([
                    'profile_id' => DB::raw("LPAD('" . Auth::user()->profile_id . "' , 5 , 0)"),
                    'social_list_id' => $get_social_type,
                    'social_account_link' => $link_detail,
                    'upd_user_id' => DB::raw("LPAD('" . Auth::user()->profile_id . "' , 5 , 0)"),
                ]);

                $insert_res->save();

                $chk_res = social::all()
                            ->where('profile_id' , Auth::user()->profile_id)
                            ->where('social_list_id' , $get_social_type)
                            ->count();

                if ($chk_res == 0) {
                    return redirect()->back()->with('error' , trans('profile.MsgErrorSocial'));
                } else {
                    return redirect()->back()->with('success' , trans('profile.MsgCompleteSocial'));
                }
            }
        }
    }
}
