<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class social extends Model
{
    use HasFactory;
    protected $table = "profile_t_social";
    public $timestamps = false;
    protected $fillable = [
        'profile_id',
        'social_list_id',
        'social_account_link',
        'upd_user_id',
    ];
}
