<?php

namespace App\Http\Controllers\Profile_config;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class config_language extends Controller
{
    public function SetLang(Request $request)
    {
        $GetLangVal = $request->get('Lang');
        $Update_res = User::where('profile_id' , Auth::user()->profile_id)
                ->update(['language_flag' => $GetLangVal]);

        if ($Update_res == 0) {
            return redirect()->back()->with('error' , trans('controller_error.SetLangReturnError'));
        } else {
            return redirect()->back()->with('success' , trans('controller_error.SetLangReturnSuccess'));
        }

    }
}
