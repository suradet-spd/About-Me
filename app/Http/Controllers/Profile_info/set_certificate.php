<?php

namespace App\Http\Controllers\Profile_info;

use App\Http\Controllers\Controller;
use App\Models\certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class set_certificate extends Controller
{
    private function CertificateValidate(array $data)
    {
        return Validator::make([
            "cert_name_th" => 'required_if:lang_flag,A,T',
            "cert_name_en" => 'required_if:lang_flag,A,E',
            'cert_desc_th' => 'required|max:500|string' ,
            'cert_desc_en' => 'required|max:500|string' ,
            "cert_date" => 'required',
            "cert_images" => 'required|image|mimes:jpeg,png,jpg,svg'
        ] , $messages = [
            'image' => trans('profile.ctl_msg_image_type'),
            'mimes' => trans('profile.ctl_msg_mimes'),
            'max' => trans('profile.ctl_cert_max_valid') ,
            'string' => trans('profile.ctl_str'),
            'cert_name_th.required' => trans('profile.js_cert_name_th'),
            'cert_name_en.required' => trans('profile.js_cert_name_en'),
            'cert_desc_th.required' => trans('profile.ctl_cert_desc_th'),
            'cert_desc_en.required' => trans('profile.ctl_cert_desc_en'),
            'cert_date.required' => trans('profile.js_cert_date'),
            'cert_images.required' => trans('profile.js_cert_images')
        ])->validate();
    }

    public function SetCertificate(Request $req)
    {
        if (!$req->exists('_token')) {
            // validate token not exists
            return redirect()->back()->with('error' , trans('profile.LosingToken'));
        } else if ($req->get('_token') != csrf_token() or $req->get('_token') == null) {
            // validate token
            return redirect()->back()->with('error' , trans('profile.ValidateToken'));
        } else {

            // Validate form data
            $this->CertificateValidate($req->all());

            // Declare data
            $cert_seq = intval(certificate::all()->where('profile_id' , Auth::user()->profile_id)->max('cert_seq')) + 1;
            $profile_id = str_pad(Auth::user()->profile_id,5,"0",STR_PAD_LEFT);
            $tmp_file_name = [];
            $img_cnt = 0;

            // upload file
            foreach ($req->file('cert_images') as $files) {

                // upload file variable
                $img_cnt ++;
                $file_type = explode("." , $files->getClientOriginalName());
                $file_name = $profile_id . "_" . $cert_seq . "_" . $img_cnt . "." . end($file_type);
                $path = 'img/user-data/' . $profile_id . "/Certificate";
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
            $ins_res = new certificate([
                'profile_id' => $profile_id,
                'cert_seq' => $cert_seq,
                'cert_name_th' => ($req->exists('cert_name_th')) ? $req->get('cert_name_th') : null,
                'cert_name_en' => ($req->exists('cert_name_en')) ? $req->get('cert_name_en') : null,
                'cert_desc_th' => ($req->exists('cert_desc_th')) ? $req->get('cert_desc_th') : null,
                'cert_desc_en' => ($req->exists('cert_desc_en')) ? $req->get('cert_desc_en') : null,
                'cert_get_date' => $req->get('cert_date'),
                'cert_images' => encrypt(json_encode($tmp_file_name)),
                'upd_user_id' => $profile_id,
            ]);

            $ins_res->save();

            // check res
            $chk_res = certificate::all()->where('profile_id' , $profile_id)->where('cert_seq' , $cert_seq)->count();

            if ($chk_res == 0) {
                return redirect()->back()->with('error' , trans('profile.ctl_msg_cert_fail'));
            } else {
                return redirect()->back()->with('success' , trans('profile.ctl_msg_cert_success'));
            }
        }
    }
}
