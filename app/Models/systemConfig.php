<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class systemConfig extends Model
{
    use HasFactory;
    protected $table = "profile_t_system_config";
    public $timestamps = false;
    protected $fillable = [
        'config_type' , 'exp_date' , 'config_desc' , 'upd_user_id'
    ];
}
