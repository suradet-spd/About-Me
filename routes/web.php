<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

// root route
Route::get('/', function () {
    return view('home');
})->name('MainPage');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Language route
Route::get('change/{locale}', function ($locale) {
    session()->put('locale', $locale);
    return redirect()->back();
});

// Frontend route
Route::post('/register', [RegisterController::class , 'req_Register'])->name('submit-register');

// Authen route
Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

    /* call file in storage or call API */
    Route::get('get-image/{id}', function ($id) {
        $tmp_image = public_path("img/Profile/$id");
        $ImageName = $id;

        $headers = [
            "file_type" => 'png'
        ];
        return response()->download($tmp_image, $ImageName, $headers);
    })->name('GetImage');

// Backend route
Route::middleware(['auth'])->group(function () {

    Route::get('Profile/{type}', function ($type) {

        if ($type == "about") {
            return view('Profile.template.1.about');
        } else if ($type == "awards") {
            return view('Profile.template.1.awards');
        } else if ($type == "education") {
            return view('Profile.template.1.education');
        } else if ($type == "experience") {
            return view('Profile.template.1.experience');
        } else if ($type == "portfolio") {
            return view('Profile.template.1.portfolio');
        } else if ($type == "skills") {
            return view('Profile.template.1.skills');
        } else {
            return redirect()->route('MainPage')->with('error' , 'ไม่พบ url ที่กำหนด');
        }
    })->name('MyProfile');
});


