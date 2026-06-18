<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materials';

    use HasFactory;

    const TYPE_IMAGE = 'image';
    const TYPE_VIDEO = 'video';
    const TYPE_TEXT = 'text';
    const TYPE_CODE = 'code';

    protected $fillable = [
        'title',
        'type',
        'description',
        'thumbnail',
        'image_url',
        'video_url',
        'text_content',
        'code_content',
        'code_language',
        'code_repo_url',
        'sort',
        'is_active',
    ];

    public static function getTypes()
    {
        return [
            self::TYPE_IMAGE => '图片素材',
            self::TYPE_VIDEO => '视频素材',
            self::TYPE_TEXT => '文字素材',
            self::TYPE_CODE => '代码素材',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort')->orderBy('id');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function getTypeNameAttribute()
    {
        return self::getTypes()[$this->type] ?? '未知类型';
    }
}

