<?php

namespace App\Http\Controllers\Profile_info;

use App\Http\Controllers\Controller;
use App\Models\location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class set_address extends Controller
{
    public function SetAddress(Request $req)
    {
        $province = $req->get('home_province');
        $district = $req->get('home_district');
        $sub_district = $req->get('home_sub_district');

        $tmp_location_code = DB::table('profile_t_location')
                            ->select('location_id')
                            ->where('province_code' , $province)
                            ->where('district_code' , $district)
                            ->where('sub_district_code' , $sub_district)
                            ->get()
                            ->toArray();
        foreach ($tmp_location_code as $tl) {
            $location_code = $tl->location_id;
        }

        $insert_res = User::where('profile_id' , Auth::user()->profile_id)
                        ->update([
                            'location_id' => $location_code,
                            'last_upd_date' => DB::raw('CURRENT_TIMESTAMP()'),
                            'upd_user_id' => DB::raw("LPAD('" . Auth::user()->profile_id . "' , 5 , 0)")
                        ]);
        if ($insert_res == 0) {
            return redirect()->back()->with('error' , trans('profile.MsgReturnError'));
        } else {
            return redirect()->back()->with('success' , trans('profile.MsgReturnSuccess'));
        }
    }
}
