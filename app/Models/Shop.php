<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'shop_num',
        'shop_name',
        'genre_id',
        'reserve',
        'pr_img_1',
        'pr_img_2',
        'pr_img_3',
        'pr_txt_1',
        'pr_txt_2',
        'pr_txt_3',
        'area',
        'instagram',
        'twitter',
        'facebook',
        'homepage',
        'shop_img',
        'shop_tag',
    ];
}
