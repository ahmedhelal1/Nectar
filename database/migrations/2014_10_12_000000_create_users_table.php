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
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_email_verified')->default(0);
            $table->string('password');
            $table->tinyInteger('account_type');
            $table->enum('language', ['ar', 'en']);


            /////////////////////////////////////////////////////////////////
            // $table->string('address')->nullable();
            // $table->boolean('is_first_login')->default(0);
            // $table->string('phone')->unique()->nullable();
            // $table->tinyInteger('account_type');
            // $table->text('bio')->nullable();
            // $table->boolean('active_notification')->default(1);
            // $table->index(['name', 'email', 'phone']);
            $table->string('social_id')->nullable();
            $table->string('social_type')->nullable();
            $table->rememberToken();
            $table->softDeletes();
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
