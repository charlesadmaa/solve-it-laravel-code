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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('status')->default(1)->comment("active:1,restricted:0");
            $table->string('dob')->comment("sample:12/24/1992");
            $table->string('gender')->comment("sample:male,female");
            $table->string('password');
            $table->string('avatar')->default('default-image.png');
            $table->string('last_login')->nullable();
            $table->string('role_id')->default(4)->
            comment('student:1,lecturer:2,school_staff:3,general_public:4,admin:5,moderator:6');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
