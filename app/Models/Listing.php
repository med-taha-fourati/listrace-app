<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    public function type() {
        return $this->hasMany(Type::class);
    }

    protected $fillable = [
        'name',
        'short-desc',
        'long-desc',
        'location',
        'type',
        'price-min',
        'price-max',
        'status',
        'image_url'
    ];
}
