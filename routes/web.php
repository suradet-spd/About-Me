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

    Route::get('profile/{flag}', function ($flag) {
        if ($flag == "create" or $flag == "update") {
            return view('Profile.modify');
        } else if ($flag == "view") {
            return view('Profile.view');
        }
    });

    Route::group(['prefix' => 'profile/{flag}'] , function ($flag) {
            Route::get('/about', function ($flag) {
                return view('Profile.template.1.about' , compact('flag'));
            })->name('profile.about');

            Route::get('/awards', function ($flag) {
                return view('Profile.template.1.awards' , compact('flag'));
            })->name('profile.awards');

            Route::get('/education', function ($flag) {
                return view('Profile.template.1.education' , compact('flag'));
            })->name('profile.education');

            Route::get('/experience', function ($flag) {
                return view('Profile.template.1.experience' , compact('flag'));
            })->name('profile.experience');

            Route::get('/portfolio', function ($flag) {
                return view('Profile.template.1.portfolio' , compact('flag'));
            })->name('profile.portfolio');

            Route::get('/skills', function ($flag) {
                return view('Profile.template.1.skills' , compact('flag'));
            })->name('profile.skills');
    });
});
