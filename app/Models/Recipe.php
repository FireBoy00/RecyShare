<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'prep_time',
        'cook_time',
        'servings',
        'ingredients',
        'instructions',
        'categories',
        'average_rating',
        'ratings_count',
    ];

    protected $casts = [
        'ingredients' => 'array',
        'instructions' => 'array',
        'categories' => 'array',
        'average_rating' => 'float',
    ];

    // Relation to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

    // Ratings relation
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
