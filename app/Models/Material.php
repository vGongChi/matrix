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

    protected $casts = [
        'is_active' => 'boolean',
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

    public function getThumbnailAttribute($value)
    {
        if (is_array($value)) {
            return $this->normalizeImageList($value);
        }

        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $this->normalizeImageList($decoded);
        }

        return $this->normalizeImageList([$value]);
    }

    public function setThumbnailAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['thumbnail'] = json_encode($this->normalizeImageList($value));
            return;
        }

        $this->attributes['thumbnail'] = $value;
    }

    public function getImageUrlAttribute($value)
    {
        if (is_array($value)) {
            return $value[0] ?? '';
        }

        if (empty($value)) {
            return '';
        }

        $decoded = json_decode($value, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded[0] ?? '';
        }

        return trim((string) $value);
    }

    public function setImageUrlAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['image_url'] = (string) ($value[0] ?? '');
            return;
        }

        $this->attributes['image_url'] = trim((string) $value);
    }

    protected function normalizeImageList(array $values): array
    {
        return array_values(array_filter(array_map(function ($item) {
            return is_string($item) ? trim($item) : $item;
        }, $values), function ($item) {
            return filled($item);
        }));
    }
}

