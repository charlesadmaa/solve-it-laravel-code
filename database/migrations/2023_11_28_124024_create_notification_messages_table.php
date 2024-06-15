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
        Schema::create('notification_messages', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->longText('message');
            $table->json('referenced_objects')->nullable(); //['product-1']
            
            $table->string('type')->default('general'); //comment, like
            $table->unsignedBigInteger('referenced_user_id')->nullable(); //auth-user
            $table->string('featured_image')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_messages');
    }
};
