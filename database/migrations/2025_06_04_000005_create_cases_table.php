<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('案例标题');
            $table->string('cover')->nullable()->comment('封面图');
            $table->text('description')->nullable()->comment('案例描述');
            $table->string('result')->nullable()->comment('成果说明');
            $table->timestamps();
            $table->index('created_at');
            $table->comment('案例表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cases');
    }
}
