<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'date',
        'place_id',
        'event_id',
        'start_time',
        'end_time',
        'comment',
    ];
}
