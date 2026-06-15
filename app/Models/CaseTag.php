<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CaseTag extends Model
{
    protected $table = 'case_tags';

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the cases that have this tag.
     */
    public function cases(): BelongsToMany
    {
        return $this->belongsToMany(Case_::class, 'case_tag_relations', 'tag_id', 'case_id')
            ->withTimestamps();
    }
}
