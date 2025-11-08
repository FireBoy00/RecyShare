<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'ingredients',
        'instructions',
    ];

    protected $casts = [
        'ingredients' => 'array',
        'instructions' => 'array',
    ];

    // Relation to comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relation to favorites
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
