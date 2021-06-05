<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class education extends Model
{
    use HasFactory;
    protected $table = "profile_t_education";
    public $timestamps = false;

    protected $fillable = [
        'profile_id',
        'learning_list_id',
        'efft_date',
        'exp_date',
        'college_name_th',
        'college_name_en',
        'faculty_name_th',
        'faculty_name_en',
        'gpa',
        'upd_user_id'
    ];
}
