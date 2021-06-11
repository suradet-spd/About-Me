<?php

namespace App\Http\Controllers\Profile_info;

use App\Http\Controllers\Controller;
use App\Models\portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Prophecy\Promise\ReturnPromise;

class set_portfolio extends Controller
{
    private function PortfolioValidate(array $data)
    {
        return Validator::make([
            "port_name_th" => 'required_if:lang_flag,A,T',
            "port_name_en" => 'required_if:lang_flag,A,E',
            "port_desc_th" => 'required_if:lang_flag,A,T',
            "port_desc_en" => 'required_if:lang_flag,A,E',
            "port_tag" => 'required',
            "port_images" => 'required|image|mimes:jpeg,png,jpg,svg'
        ] , $messages = [
            'image' => trans('profile.ctl_msg_image_type'),
            'mimes' => trans('profile.ctl_msg_mimes'),
            'port_name_th.required' => trans('profile.ctl_msg_port_name_th_req'),
            'port_name_en.required' => trans('profile.ctl_msg_port_name_en_req'),
            'port_desc_th.required' => trans('profile.ctl_msg_port_desc_th_req'),
            'port_desc_en.required' => trans('profile.ctl_msg_port_desc_en_req'),
            'port_tag.required' => trans('profile.ctl_msg_port_tag_req'),
            'port_images.required' => trans('profile.ctl_msg_port_images_req')
        ])->validate();
    }

    public function SetPortfolio(Request $req)
    {
        if (!$req->exists('_token')) {
            // validate token not exists
            return redirect()->back()->with('error' , trans('profile.LosingToken'));
        } else if ($req->get('_token') != csrf_token() or $req->get('_token') == null) {
            // validate token
            return redirect()->back()->with('error' , trans('profile.ValidateToken'));
        } else {

            // Validate form data
            $this->PortfolioValidate($req->all());

            // Declare data
            $port_seq = intval(portfolio::all()->where('profile_id' , Auth::user()->profile_id)->count()) + 1;
            $profile_id = str_pad(Auth::user()->profile_id,5,"0",STR_PAD_LEFT);
            $tmp_file_name = [];
            $img_cnt = 0;

            // upload file
            foreach ($req->file('port_images') as $files) {

                // upload file variable
                $img_cnt ++;
                $file_type = explode("." , $files->getClientOriginalName());
                $file_name = $profile_id . "_" . $port_seq . "_" . $img_cnt . "." . end($file_type);
                $path = 'img/user-data/' . $profile_id . "/Portfolio";
                $chk_path = $path . "/" . $file_name;

                // check exists file
                if (File::exists(public_path($chk_path))) {
                    File::delete($chk_path);
                }

                // upload file
                $filePath = $files->storeAs($path , $file_name, 'public');

                // insert file name to array
                array_push($tmp_file_name , $file_name);
            }

            // insert data
            $ins_res = new portfolio([
                'profile_id' => $profile_id,
                'portfolio_seq' => $port_seq,
                'portfolio_name_th' => ($req->exists('port_name_th')) ? $req->get('port_name_th') : null,
                'portfolio_name_en' => ($req->exists('port_name_en')) ? $req->get('port_name_en') : null,
                'portfolio_tag' => ($req->exists('port_tag')) ? $req->get('port_tag') : null,
                'portfolio_images' => encrypt(json_encode($tmp_file_name)),
                'portfolio_desc_th' => ($req->exists('port_desc_th')) ? $req->get('port_desc_th') : null,
                'portfolio_desc_en' => ($req->exists('port_desc_en')) ? $req->get('port_desc_en') : null,
                'upd_user_id' => $profile_id,
            ]);

            $ins_res->save();

            // check res
            $chk_res = portfolio::all()->where('profile_id' , $profile_id)->where('portfolio_seq' , $port_seq)->count();

            if ($chk_res == 0) {
                return redirect()->back()->with('error' , trans('profile.ctl_msg_port_fail'));
            } else {
                return redirect()->back()->with('success' , trans('profile.ctl_msg_port_success'));
            }
        }
    }
}
