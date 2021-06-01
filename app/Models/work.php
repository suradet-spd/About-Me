<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class work extends Model
{
    use HasFactory;
    protected $table = "profile_t_work";
    public $timestamps = false;
    protected $fillable = [
        'profile_id',
        'work_seq',
        'work_name_th' ,
        'work_name_en' ,
        'work_office_th' ,
        'work_office_en' ,
        'work_desc_th' ,
        'work_desc_en' ,
        'work_start_date' ,
        'work_end_date' ,
        'upd_user_id' ,
    ];
}
