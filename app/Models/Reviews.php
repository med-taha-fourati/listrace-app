<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    public function user_id() {
        return $this->hasMany(User::class);
    }

    protected $fillable = [
        'user_id',
        'listing_id',
        'stars',
        'content'
    ];
}
