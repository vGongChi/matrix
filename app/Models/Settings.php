<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Settings extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'site_name',
        'site_name_en',
        'logo',
        'phone',
        'email',
        'address',
        'wechat_qr',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'seo_image',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
