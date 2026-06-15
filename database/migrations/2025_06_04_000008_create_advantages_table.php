<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvantagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advantages', function (Blueprint $table) {
            $table->id();
            $table->string('icon', 100)->nullable()->comment('图标');
            $table->string('title')->nullable()->comment('标题');
            $table->text('description')->nullable()->comment('描述');
            $table->integer('sort')->default(0)->comment('排序');
            $table->timestamps();
            $table->comment('优势模块');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advantages');
    }
}
