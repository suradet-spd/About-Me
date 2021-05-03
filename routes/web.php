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

    Route::get('get-logo', function () {
        $path = public_path("img/logo.png");

        $headers = [
            "file_type" => 'png'
        ];
        return response()->download($path , "logo.png" , $headers);
    })->name('GetLogo');

// Backend route
Route::middleware(['auth'])->group(function () {
    Route::get('/your-profile/{flag}', function ($flag) {
        if ($flag == "create" or $flag == "update") {
            return view('Profile.modify');
        } else if ($flag == "view") {
            return view('Profile.view');
        }
    })->name('your.profile');
});
