<?php

namespace App\Http\Controllers\Profile_info;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class set_about extends Controller
{
    public function SetAbout(Request $req)
    {
        if (Auth::user()->language_flag == "A") {
            $about_th = $req->get('about_tag_th');
            $about_en = $req->get('about_tag_en');
        } elseif (Auth::user()->language_flag == "T") {
            $about_th = $req->get('about_tag_th');
            $about_en = null;
        } elseif (Auth::user()->language_flag == "E") {
            $about_th = null;
            $about_en = $req->get('about_tag_en');
        } else {
            return redirect()->back()->with('error' , trans('profile.ErrJsOther'));
        }

        if (($about_th == "" or $about_th == null) and ($about_en == "" or $about_en == null)) {
            return redirect()->back()->with('error' , trans('profile.ErrControllerMsg'));
        } else {
            $update_res = User::where('profile_id' , Auth::user()->profile_id)
                            ->update([
                                "about_th" => $about_th ,
                                "about_en" => $about_en
                            ]);

            if ($update_res == 0) {
                return redirect()->back()->with('error' , trans('profile.MsgErrorAbout'));
            } else {
                return redirect()->back()->with('success' , trans('profile.MsgCompleteAbout'));
            }
        }
    }
}
