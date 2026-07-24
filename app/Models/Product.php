<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'level',
        'deposit_rate',
        'price',
        'depend_product_id',
        'jump_fee_penalty',
        'max_revisions',
        'requires_tech_stack',
        'demo_images',
        'status',
    ];

    protected $casts = [
        'deposit_rate' => 'decimal:2',
        'price' => 'decimal:2',
        'jump_fee_penalty' => 'decimal:2',
        'requires_tech_stack' => 'boolean',
        'status' => 'boolean',
        'demo_images' => 'array',
    ];

    public static function getLevels(): array
    {
        return [
            'light' => '轻量',
            'standard' => '标准',
            'heavy' => '重型',
        ];
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'depend_product_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'depend_product_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', true);
    }

    public function getLevelTextAttribute(): string
    {
        return self::getLevels()[$this->level] ?? $this->level;
    }

    public function getDemoImagesAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [$value];
    }

    public function setDemoImagesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['demo_images'] = json_encode(array_values(array_filter($value)));
            return;
        }

        $this->attributes['demo_images'] = $value;
    }

    public function getEffectivePrice(float $basePrice, bool $hasRequiredDependency = true): float
    {
        if (! $hasRequiredDependency && ! empty($this->depend_product_id)) {
            return round($basePrice * (1 + ((float) $this->jump_fee_penalty / 100)), 2);
        }

        return round($basePrice, 2);
    }

    public function getPricingSummary(bool $hasRequiredDependency = true): array
    {
        $totalPrice = $this->getEffectivePrice((float) $this->price, $hasRequiredDependency);
        $depositAmount = round($totalPrice * ((float) $this->deposit_rate / 100), 2);

        return [
            'total_price' => $totalPrice,
            'deposit_amount' => $depositAmount,
            'final_amount' => round($totalPrice - $depositAmount, 2),
        ];
    }
}
