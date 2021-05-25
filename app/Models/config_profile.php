<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class config_profile extends Model
{
    use HasFactory;
    protected $table = "profile_t_config";
    public $timestamps = false;
    protected $fillable = [
        'profile_id' ,
        'config_type' ,
        'config_desc' ,
        'upd_user_id'
    ];
}
