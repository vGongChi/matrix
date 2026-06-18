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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('素材标题');
            $table->enum('type', ['image', 'video', 'text', 'code'])->comment('素材类型');
            $table->text('description')->nullable()->comment('素材描述');
            $table->string('thumbnail')->comment('封面缩略图');
            $table->text('image_url')->nullable()->comment('图片素材URL');
            $table->text('video_url')->nullable()->comment('视频素材URL');
            $table->longText('text_content')->nullable()->comment('文字内容');
            $table->longText('code_content')->nullable()->comment('代码内容');
            $table->string('code_language')->nullable()->comment('代码语言');
            $table->text('code_repo_url')->nullable()->comment('代码仓库地址（可掩饰）');
            $table->integer('sort')->default(0)->comment('排序');
            $table->boolean('is_active')->default(true)->comment('是否启用');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
