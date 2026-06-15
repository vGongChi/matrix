<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Case_ extends Model
{
    protected $table = 'cases';

    protected $fillable = [
        'title',
        'cover',
        'description',
        'result',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the tags for the case.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(CaseTag::class, 'case_tag_relations', 'case_id', 'tag_id')
            ->withTimestamps();
    }
}
