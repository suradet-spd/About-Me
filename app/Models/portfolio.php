<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class portfolio extends Model
{
    use HasFactory;

    protected $table = "profile_t_portfolio";
    public $timestamps = false;

    protected $fillable = [
        'profile_id',
        'portfolio_seq',
        'portfolio_name_th',
        'portfolio_name_en',
        'portfolio_tag',
        'portfolio_images',
        'portfolio_desc_th',
        'portfolio_desc_en',
        'upd_user_id'
    ];
}
