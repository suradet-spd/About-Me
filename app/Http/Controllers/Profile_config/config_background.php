<?php

namespace App\Http\Controllers\Profile_config;

use App\Http\Controllers\Controller;
use App\Models\config_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class config_background extends Controller
{
    protected function ValidateBackground(array $get_data){
        return Validator::make($get_data , [
            "SetBackgroundType" => 'required',
            "BackgroundColor" => 'required',
            "MenuColor" => 'required' ,
            "TextMainColor" => 'required',
            "TextSubColor" => 'required'
        ] , $messages = [
            'SetBackgroundType.required' => trans('background.color_type'),
            'BackgroundColor.required' => trans('background.background_color'),
            'MenuColor.required' => trans('background.menu_color'),
            'TextMainColor.required' => trans('background.main_font'),
            'TextSubColor.required' => trans('background.sub_font')
        ])->validate();
    }

    public function SetBackgroundColor(Request $req)
    {
        // Validate form
            $this->ValidateBackground($req->all());

        // Declare array
            $background_color = array(
                'color_type' => $req->get('SetBackgroundType'),
                'background_color' => $req->get('BackgroundColor'),
                'menu_color' => $req->get('MenuColor'),
            );

            $font_color = array(
                'main_color' => $req->get('TextMainColor'),
                'sub_color' => $req->get('TextSubColor'),
            );

        // Json Encode / encrypt
            $tmp_encrypt = array(
                'background' => encrypt(json_encode($background_color)),
                'font' => encrypt(json_encode($font_color)),
            );

        // Check duplicate data before insert data
            $chk_data = config_profile::all()
                        ->where('profile_id' , Auth::user()->profile_id)
                        ->whereIn('config_type' , ['BC','FC'])
                        ->whereNull('exp_date')
                        ->count();

        // conditions before insert
            if ($chk_data >= 1) {
                $update_res = config_profile::where('profile_id' , Auth::user()->profile_id)
                                ->whereIn('config_type' , ['BC','FC'])
                                ->whereNull('exp_date')
                                ->delete();
            }

        // Insert Data
            $config_bc = new config_profile([
                'profile_id' => DB::raw("LPAD(". Auth::user()->profile_id . " , 5 , '0')") ,
                'config_type' => "BC" ,
                'config_desc' => $tmp_encrypt["background"],
                'upd_user_id' => DB::raw("LPAD(". Auth::user()->profile_id . " , 5 , '0')"),
            ]);
            $config_bc->save();

            $config_fc = new config_profile([
                'profile_id' => DB::raw("LPAD(". Auth::user()->profile_id . " , 5 , '0')") ,
                'config_type' => "FC",
                'config_desc' => $tmp_encrypt["font"],
                'upd_user_id' => DB::raw("LPAD(". Auth::user()->profile_id . " , 5 , '0')"),
            ]);
            $config_fc->save();

        // check result
            $chk_res = config_profile::all()
                        ->where('profile_id' , Auth::user()->profile_id)
                        ->whereIn('config_type' , ['BC' , 'FC'])
                        ->whereIn('config_desc' , [$tmp_encrypt["background"] , $tmp_encrypt['font']])
                        ->whereNull('exp_date')
                        ->count();
            if ($chk_res == 2) {

                return redirect()->back()->with('success' , trans('background.SuccessMSG'));

            } else {

            // delete data when insert not complete
                $del_res = config_profile::where('profile_id' , Auth::user()->profile_id)
                        ->whereIn('config_type' , ['BC' , 'FC'])
                        ->whereIn('config_desc' , [$tmp_encrypt["background"] , $tmp_encrypt['font']])
                        ->whereNull('exp_date')
                        ->delete();
                return redirect()->back()->with('error' , trans('background.ErrorMSG'));
            }
    }
}
