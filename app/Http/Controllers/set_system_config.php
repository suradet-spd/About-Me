<?php

namespace App\Http\Controllers;

use App\Models\systemConfig;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class set_system_config extends Controller
{
    private function ValidateForm(array $data){
        return Validator::make($data , [
            "modify" => 'required',
            "SetBackgroundType" => 'required_if:modify,BG',
            "PrimaryColor" => 'required_if:SetBackgroundType,C,G',
            "SecondaryColor" => 'required_if:SetBackgroundType,G',
            "SetFontColor" => 'required_if:modify,FC',
            "SetButtonColor" => 'required_if:modify,BC',
            "SetLineAccount" => 'required_if:modify,AD',
            "SetMailAccount" => 'required_if:modify,AD'
        ] , $messages = [
            'required' => "please enter values!"
        ])->validate();
    }

    public function SetSystem(Request $req)
    {
        $this->ValidateForm($req->all());
        $tk = $req->exists('_token');

        if(!$tk){
            return redirect()->back()->with('error' , trans('profile.LosingToken'));
        } else if ($tk != csrf_field()) {
            return redirect()->back()->with('error' , trans('profile.ValidateToken'));
        } else {
            $arr = array(
                'config_type' => ($req->exists('modify')) ? $req->get('modify') : null,
                'config_desc' => ($req->exists('modify')) ? (
                    ($req->get('modify') == "BG") ? (
                        array(
                            "background_type" => (($req->exists('SetBackgroundType')) ? $req->get('SetBackgroundType') : null),
                            "primary_color" => (($req->exists('PrimaryColor')) ? $req->get('PrimaryColor') : null),
                            "secondary_color" => (($req->exists('SecondaryColor')) ? $req->get('SecondaryColor') : null)
                        )
                    ) : (($req->get('modify') == "FC") ? (
                        array(
                            "font_color" => (($req->exists('SetFontColor')) ? $req->get('SetFontColor') : null)
                        )
                    ) : (($req->get('modify') == "BC") ? (
                        array(
                            "button_color" => (($req->exists('SetButtonColor')) ? $req->get('SetButtonColor') : null)
                        )
                    ) : (($req->get('modify') == "AD") ? (
                        array(
                            "LineAccount" => (($req->exists('SetLineAccount')) ? $req->get('SetLineAccount') : null),
                            "MailAccount" => (($req->exists('SetMailAccount')) ? $req->get('SetMailAccount') : null)
                        )
                    ) : null)))
                ) : null,
            );

            if ($arr["config_type"] == null or $arr["config_desc"] == null) {
                return redirect()->back()->with('error' , 'can not update system config pls try again.');
            } else {
                $chk_exists = systemConfig::all()->where('config_type' , $arr["config_type"])->whereNull('exp_date')->count();

                $config_desc = encrypt(json_encode($arr["config_desc"]));
                if ($chk_exists != 0) {
                    $update_res = systemConfig::where('config_type' , $arr["config_type"])
                                    ->whereNull('exp_date')
                                    ->update([
                                        'exp_date' => DB::raw('CURRENT_TIMESTAMP'),
                                        'last_upd_date' => DB::raw('CURRENT_TIMESTAMP'),
                                        'upd_user_id' => str_pad(Auth::user()->profile_id , 5,"0",STR_PAD_LEFT)
                                    ]);
                }

                $ins_res = new systemConfig([
                    'config_type' => $arr["config_type"] ,
                    'config_desc' => $config_desc ,
                    'upd_user_id' => str_pad(Auth::user()->profile_id,5,"0",STR_PAD_LEFT) ,
                ]);
                $ins_res->save();

                $res = (systemConfig::all()->where('config_type' , $arr["config_type"])->where('config_desc' , $config_desc)->count() == 1) ? true : false;

                if ($res) {
                    return redirect()->back()->with('success' , 'Update website complete!');
                } else{
                    return redirect()->back()->with('error' , 'can not update website pls try again!');
                }
            }
        }
    }
}
