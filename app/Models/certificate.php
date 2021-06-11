<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class certificate extends Model
{
    use HasFactory;

    protected $table = "profile_t_certificate";
    public $timestamps = false;

    protected $fillable = [
        'profile_id',
        'cert_seq',
        'cert_name_th',
        'cert_name_en',
        'cert_desc_th' ,
        'cert_desc_en' ,
        'cert_get_date',
        'cert_images',
        'upd_user_id'
    ];
}
