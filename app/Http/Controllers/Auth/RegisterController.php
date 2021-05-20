<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    use RegistersUsers;


    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'regist_profile_img' => ['mimes:jpeg,jpg,png' , 'required' , 'max:10000'],
            'regist_nickname' => ['string' , 'max:255'],
            'regist_name_th'=> ['required', 'string', 'max:255'],
            'regist_name_en' => ['required', 'string', 'max:255'],
            'regist_email' => ['required', 'string', 'email', 'max:255', 'unique:profile_t_master'],
            'regist_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    // protected function create(array $data)
    // {
    //     $tmp_id = User::max('id');
    //     $new_id = (intval($tmp_id) + 1);
    //     return User::create([
    //         'id' => DB::raw("LPAD('$new_id' , 5 , 0)"),
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //         'upd_user_id' => DB::raw("LPAD('$new_id' , 5 , 0)"),
    //     ]);

    //     return redirect()->route('MainPage')->with('success' , "Register complete1");
    // }

    protected function validate_data(array $data)
    {
        return Validator::make($data, [
            'regist_profile_img' => ['mimes:jpeg,jpg,png' , 'required' , 'max:10000'],
            'regist_nickname' => ['required' ,'string' , 'max:255'],
            'regist_name_th'=> ['required', 'string', 'max:255'],
            'regist_name_en' => ['required', 'string', 'max:255'],
            'regist_email' => ['required', 'string', 'email', 'max:255'],
            'regist_telephone' => ['required' , 'min:9' , 'max:20'],
            'regist_password' => ['required', 'min:8', 'confirmed'],
        ] , $messages = [
        // profile Image
            'regist_profile_img.mimes' => trans('register.err_image_mimes'),
            'regist_profile_img.required' => trans('register.err_image_req'),
            'regist_profile_img.max' => trans('register.err_image_size'),
        // profile nickname
            'regist_nickname.required' => trans('register.err_nick_req'),
            'regist_nickname.string' => trans('register.err_nick_str'),
            'regist_nickname.max' => trans('register.err_nick_max'),
        // profile name_th
            'regist_name_th.required' => trans('register.err_name_th_req'),
            'regist_name_th.string' => trans('register.err_name_th_str'),
            'regist_name_th.max' => trans('register.err_name_th_max'),
        // profile name_en
            'regist_name_en.required' => trans('register.err_name_en_req'),
            'regist_name_en.string' => trans('register.err_name_en_str'),
            'regist_name_en.max' => trans('register.err_name_en_max'),
        // profile email
            'regist_email.required' => trans('register.err_email_req'),
            'regist_email.string' => trans('register.err_email_str'),
            'regist_email.email' => trans('register.err_email_mail'),
            'regist_email.max' => trans('register.err_email_max'),
        // profile telephone
            'regist_telephone.required' => trans('register.err_phone_req'),
            'regist_telephone.min' => trans('register.err_phone_min'),
            'regist_telephone.max' => trans('register.err_phone_max'),
        // password
            'regist_password.required' => trans('register.err_pass_req'),
            'regist_password.min' => trans('register.err_pass_min'),
            'regist_password.confirmed' => trans('register.err_pass_confirm'),
        ])->validate();
    }
    protected function req_Register(Request $request){

        $this->validate_data($request->all()); // Validate form

        $chk_exist = User::all()->where('email' , $request->get('regist_email'))->count();

        if ($chk_exist > 0 ) {
            return redirect()->route('MainPage')->with('error' , trans('register.AlreadyEmail'));
        } else {
            $tmp_id = User::max('profile_id');
            $new_id = (intval($tmp_id) + 1);
            $tmp_gen = DB::raw("SELECT LPAD('$new_id' , 5 , 0) as temp_new_id FROM dual;");
            $gen = DB::select($tmp_gen);
                foreach ($gen as $new_create) {
                    $create_id = $new_create->temp_new_id;
                }
        // Gen new id
            $file_type = explode("." , $request->regist_profile_img->getClientOriginalName());
            $file_name = $create_id . "." . end($file_type);
            $filePath = $request->file('regist_profile_img')->storeAs('img/Profile', $file_name, 'public');
        // Store file to storage
            $regist_res = new User([
                'profile_id' => strval($create_id),
                'name_th' => $request['regist_name_th'],
                'name_en' => $request['regist_name_en'],
                'nickname' => $request['regist_nickname'],
                'photo_name' => $file_name,
                'email' => $request['regist_email'],
                'telephone' => $request['regist_telephone'],
                'password' => Hash::make($request['regist_password']),
                'upd_user_id' => DB::raw("LPAD('$new_id' , 5 , 0)"),
            ]);
            $regist_res->save();
        // save data to database
            $cnt = User::all()->where('profile_id' , $create_id)->count();
        // check data after insert
            if ($cnt > 0) {
                return redirect()->route('MainPage')->with('success' , trans('register.RegisterResultComplete'));
            } else {
                return redirect()->route('MainPage')->with('error' , trans('register.RegisterResultError'));
            }

        }
    }
}
