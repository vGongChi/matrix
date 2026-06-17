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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('成员名字');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->string('position')->nullable()->comment('岗位职责');
            $table->longText('description')->nullable()->comment('文字介绍');
            $table->json('images')->nullable()->comment('图片数组 JSON');
            $table->string('video_url')->nullable()->comment('视频介绍地址');
            $table->string('audio_url')->nullable()->comment('音频介绍地址');
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
        Schema::dropIfExists('teams');
    }
};
