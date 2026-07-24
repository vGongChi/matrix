<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('order_no', 32)->unique()->comment('订单编号');
            $table->decimal('total_price', 10, 2)->comment('订单最终总价');
            $table->decimal('deposit_amount', 10, 2)->comment('启动金金额');
            $table->decimal('final_amount', 10, 2)->comment('尾款金额');
            $table->boolean('deposit_paid')->default(false)->comment('启动金是否已付');
            $table->timestamp('deposit_paid_at')->nullable();
            $table->boolean('final_paid')->default(false)->comment('尾款是否已付');
            $table->timestamp('final_paid_at')->nullable();
            $table->enum('status', ['pending_deposit', 'processing', 'pending_final', 'completed', 'after_sale', 'cancelled'])->default('pending_deposit');
            $table->json('tech_stack')->nullable()->comment('客户选择的技术栈');
            $table->json('requirements')->comment('客户填写的结构化需求表单');
            $table->json('preview_files')->nullable()->comment('带水印的预览文件');
            $table->json('delivery_files')->nullable()->comment('最终交付物');
            $table->integer('remaining_revisions')->default(2)->comment('剩余免费修改次数');
            $table->boolean('is_jumped')->default(false)->comment('是否触发跳阶');
            $table->string('jump_message')->nullable()->comment('跳阶提示信息');
            $table->boolean('agreed_third_party')->default(false)->comment('是否同意三方接口免责协议');
            $table->timestamp('agreed_at')->nullable()->comment('协议勾选时间');
            $table->text('customer_notes')->nullable()->comment('客户补充备注');
            $table->text('admin_notes')->nullable()->comment('管理员内部备注');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
