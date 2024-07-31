<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    public function listing() {
        return $this->hasMany(Listing::class);
    }

    public function user_id() {
        return $this->hasMany(User::class);
    }

    protected $fillable = [
        'listing',
        'user_id',
        'beginning_date',
        'end_date',
        'accepted'
    ];
}
