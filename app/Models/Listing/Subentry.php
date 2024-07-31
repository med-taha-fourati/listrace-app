<?php

namespace App\Models\Listing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subentry extends Model
{
    use HasFactory;

    protected $fillable = [
        'listing_id',
        'subentry',
        'price'
    ];
}
