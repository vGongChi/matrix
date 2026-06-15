<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeroSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('主标题');
            $table->string('highlight_text')->nullable()->comment('高亮文字');
            $table->text('subtitle')->nullable()->comment('副标题');
            $table->string('image')->nullable()->comment('图片URL');
            $table->timestamps();
            $table->comment('首页Hero区域');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hero_sections');
    }
}
