<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $table = 'profile_t_login';
    use HasFactory, Notifiable;

    public $timestamps = false;
    protected $fillable = [
        'id',
        'name_th',
        'name_en',
        'nickname',
        'photo_name',
        'email',
        'password',
        'upd_user_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

}
