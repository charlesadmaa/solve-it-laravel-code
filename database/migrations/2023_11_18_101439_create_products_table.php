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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type')->default('product')->comment("product or service");
            $table->string('featured_image')->nullable();
            $table->unsignedBigInteger('created_by_id');

            $table->string('amount')->default("100.00");
            $table->string('currency')->default('₦');
            $table->unsignedBigInteger('product_tag_id')->nullable();
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();

            $table->string('is_featured')->default("0");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
