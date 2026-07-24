<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'product_id',
        'order_no',
        'total_price',
        'deposit_amount',
        'final_amount',
        'deposit_paid',
        'deposit_paid_at',
        'final_paid',
        'final_paid_at',
        'status',
        'tech_stack',
        'requirements',
        'preview_files',
        'delivery_files',
        'remaining_revisions',
        'is_jumped',
        'jump_message',
        'agreed_third_party',
        'agreed_at',
        'customer_notes',
        'admin_notes',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'deposit_paid' => 'boolean',
        'final_paid' => 'boolean',
        'is_jumped' => 'boolean',
        'agreed_third_party' => 'boolean',
        'tech_stack' => 'array',
        'requirements' => 'array',
        'preview_files' => 'array',
        'delivery_files' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $order): void {
            if (empty($order->order_no)) {
                $order->order_no = self::makeOrderNo();
            }

            if ($order->product_id && empty($order->total_price)) {
                $order->syncPricingSnapshot();
            }
        });

        static::saving(function (self $order): void {
            if ($order->product_id && empty($order->total_price)) {
                $order->syncPricingSnapshot();
            }
        });
    }

    public static function getStatuses(): array
    {
        return [
            'pending_deposit' => '待启动金',
            'processing' => '处理中',
            'pending_final' => '待尾款',
            'completed' => '已完成',
            'after_sale' => '售后中',
            'cancelled' => '已取消',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::getStatuses()[$this->status] ?? $this->status;
    }

    public function syncPricingSnapshot(): void
    {
        $product = $this->product()->first();

        if (! $product) {
            return;
        }

        $summary = $product->getPricingSummary(! $this->deposit_paid);

        $this->total_price = $summary['total_price'];
        $this->deposit_amount = $summary['deposit_amount'];
        $this->final_amount = $summary['final_amount'];

        if (empty($this->remaining_revisions)) {
            $this->remaining_revisions = $product->max_revisions;
        }
    }

    public static function makeOrderNo(): string
    {
        return 'AI'.date('Ymd').strtoupper(Str::random(4));
    }
}
