<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseTagRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_tag_relations', function (Blueprint $table) {
            $table->unsignedBigInteger('case_id')->comment('案例ID');
            $table->unsignedBigInteger('tag_id')->comment('标签ID');
            $table->primary(['case_id', 'tag_id']);
            $table->index('case_id');
            $table->index('tag_id');
            $table->foreign('case_id')->references('id')->on('cases')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('case_tags')->onDelete('cascade');
            $table->comment('案例标签关联表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('case_tag_relations');
    }
}
