<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable()->comment('客户姓名');
            $table->string('contact')->nullable()->comment('联系方式');
            $table->text('message')->nullable()->comment('需求内容');
            $table->string('source', 100)->nullable()->comment('来源渠道');
            $table->tinyInteger('status')->default(0)->comment('0未处理 1已联系 2已成交 3无效');
            $table->timestamps();
            $table->index('created_at');
            $table->index('status');
            $table->comment('客户线索表（核心业务数据）');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
