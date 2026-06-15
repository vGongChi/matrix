<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroFeature extends Model
{
    protected $table = 'hero_features';

    protected $fillable = [
        'icon',
        'text',
        'sort',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'sort' => 0,
    ];
}
