<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AfterSaleRequest extends Model
{
    use HasFactory;

    protected $table = 'after_sale_requests';

    protected $fillable = [
        'order_id',
        'user_id',
        'request_type',
        'description',
        'attachments',
        'status',
        'admin_response',
        'response_files',
        'resolved_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'response_files' => 'array',
    ];

    public static function getStatuses(): array
    {
        return [
            'pending' => '待处理',
            'processing' => '处理中',
            'resolved' => '已解决',
            'closed' => '已关闭',
        ];
    }

    public static function getRequestTypes(): array
    {
        return [
            'revision' => '修改',
            'bug_fix' => '问题修复',
            'consultation' => '咨询',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
