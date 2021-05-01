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

    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:profile_t_login'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }

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

    protected function req_Register(Request $request){

        // dd($request);
        $validate_res = $request->validate([
            'profile_img' => ['mimes:jpeg,jpg,png' , 'required' , 'max:10000'],
            'nickname' => ['string' , 'max:255'],
            'name_th'=> ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:profile_t_login'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $chk_exist = User::all()->where('email' , $request->get('email'))->count();

        if ($chk_exist > 0 ) {
            return redirect()->route('MainPage')->with('error' , 'Email already exists');
        } else {
            $tmp_id = User::max('id');
            $new_id = (intval($tmp_id) + 1);
            $tmp_gen = DB::raw("SELECT LPAD('$new_id' , 5 , 0) as temp_new_id FROM dual;");
            $gen = DB::select($tmp_gen);
                foreach ($gen as $new_create) {
                    $create_id = $new_create->temp_new_id;
                }
        // Gen new id
            $file_type = explode("." , $request->profile_img->getClientOriginalName());
            $file_name = $create_id . "." . end($file_type);
            $filePath = $request->file('profile_img')->storeAs('img/Profile', $file_name, 'public');
        // Store file to storage
            $regist_res = new User([
                'id' => strval($create_id),
                'name_th' => $request['name_th'],
                'name_en' => $request['name_en'],
                'nickname' => $request['nickname'],
                'photo_name' => $file_name,
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'upd_user_id' => DB::raw("LPAD('$new_id' , 5 , 0)"),
            ]);
            $regist_res->save();
        // save data to database
            $cnt = User::all()->where('id' , $create_id)->count();
        // check data after insert
            if ($cnt > 0) {
                return redirect()->route('MainPage')->with('success' , "Register complete");
            } else {
                return redirect()->route('MainPage')->with('error' , "Can't Register ! Please try again.");
            }

        }
    }
}
