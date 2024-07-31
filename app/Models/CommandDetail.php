<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin_command',
        'origin_listing',
        'origin_listing_subentry',
        'name',
        'surname',
        'place_of_origin',
        'date_of_birth',
        'begin_date',
        'end_date',
        'calculated_price'
    ];
}
