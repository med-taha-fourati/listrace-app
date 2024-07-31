<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    public function author() {
        return $this->hasMany(User::class, 'author');
    }

    protected $fillable = [
        'author',
        'headline',
        'content',
        'image_url'
    ];
}
