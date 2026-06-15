<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('服务名称');
            $table->text('description')->nullable()->comment('服务描述');
            $table->string('icon', 100)->nullable()->comment('图标');
            $table->integer('sort')->default(0)->comment('排序');
            $table->timestamps();
            $table->comment('服务模块');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
