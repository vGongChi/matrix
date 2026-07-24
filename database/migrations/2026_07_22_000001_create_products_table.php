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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('商品名称');
            $table->enum('level', ['light', 'standard', 'heavy'])->default('light')->comment('难度等级');
            $table->decimal('deposit_rate', 5, 2)->default(30.00)->comment('启动金比例(%)');
            $table->decimal('price', 10, 2)->comment('基准总价');
            $table->foreignId('depend_product_id')->nullable()->constrained('products')->nullOnDelete()->comment('前置依赖商品ID');
            $table->decimal('jump_fee_penalty', 5, 2)->default(25.00)->comment('跳阶加收比例(%)');
            $table->integer('max_revisions')->default(2)->comment('免费修改次数');
            $table->boolean('requires_tech_stack')->default(false)->comment('是否需要选择技术栈');
            $table->json('demo_images')->nullable()->comment('参考样例图(JSON数组)');
            $table->boolean('status')->default(true)->comment('状态(1上架0下架)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
