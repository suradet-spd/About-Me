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
            "MenuColor" => 'required'
        ] , $messages = [
            'SetBackgroundType.required' => trans('background.color_type'),
            'BackgroundColor.required' => trans('background.background_color'),
            'MenuColor.required' => trans('background.menu_color'),
        ])->validate();
    }

    public function SetBackgroundColor(Request $req)
    {
        // Validate form
            $this->ValidateBackground($req->all());

        // Declare array
            $config_data = array(
                'color_type' => $req->get('SetBackgroundType'),
                'background_color' => $req->get('BackgroundColor'),
                'menu_color' => $req->get('MenuColor'),
            );

        // Json Encode
            $Json_data = json_encode($config_data);

        // Encrypt data
            $tmp_encrypt = encrypt($Json_data);

        // Check duplicate data before insert data
            $chk_data = config_profile::all()
                        ->where('profile_id' , Auth::user()->profile_id)
                        ->where('config_type' , 'BC')
                        ->whereNull('exp_date')
                        ->count();

        // conditions before insert
            if ($chk_data >= 1) {
                $update_res = config_profile::where('profile_id' , Auth::user()->profile_id)
                                ->where('config_type' , 'BC')
                                ->whereNull('exp_date')
                                ->delete();
            }

        // Insert Data
            $config = new config_profile([
                'profile_id' => DB::raw("LPAD(". Auth::user()->profile_id . " , 5 , '0')") ,
                'config_type' => "BC" ,
                'config_desc' => $tmp_encrypt,
                'upd_user_id' => DB::raw("LPAD(". Auth::user()->profile_id . " , 5 , '0')"),
            ]);
            $config->save();

        // check result
            $chk_res = config_profile::all()
                        ->where('profile_id' , Auth::user()->profile_id)
                        ->where('config_type' , 'BC')
                        ->where('config_desc' , $tmp_encrypt)
                        ->whereNull('exp_date')
                        ->count();
            if ($chk_res == 1) {

                return redirect()->back()->with('success' , trans('background.SuccessMSG'));

            } else {

            // delete data when insert not complete
                $del_res = config_profile::where('profile_id' , Auth::user()->profile_id)
                        ->where('config_type' , 'BC')
                        ->where('config_desc' , $tmp_encrypt)
                        ->whereNull('exp_date')
                        ->delete();
                return redirect()->back()->with('error' , trans('background.ErrorMSG'));
            }
    }
}
