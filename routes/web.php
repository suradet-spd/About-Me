<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// root route
Route::get('/', function () {
    return view('home');
})->name('MainPage');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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
Route::get('/your-profile/{flag}', function ($flag) {
    if ($flag == "create") {
        return view('tmp_profile.profile' , compact('flag'));
    } else if ($flag == "view" or $flag == "update") {
        return view('tmp_profile.profile' , compact('flag'));
    }
})->middleware('auth')->name('your.profile');
