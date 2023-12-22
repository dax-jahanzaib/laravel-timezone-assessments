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
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // assuming 'users' table already exists
            $table->string('scheduled_at', 100)->nullable();
            $table->enum('frequency', ['daily', 'weekly', 'monthly', 'custom']);
            $table->text('notification_message')->nullable(); // You can adjust the data type as needed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notifications');
    }
};
