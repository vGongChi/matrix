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
        Schema::create('after_sale_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('request_type', ['revision', 'bug_fix', 'consultation'])->default('revision');
            $table->text('description');
            $table->json('attachments')->nullable();
            $table->enum('status', ['pending', 'processing', 'resolved', 'closed'])->default('pending');
            $table->text('admin_response')->nullable();
            $table->json('response_files')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('after_sale_requests');
    }
};
