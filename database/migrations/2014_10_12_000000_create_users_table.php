<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('description')->nullable()->default('Halo Parents!');
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->date('birthday')->nullable();
            $table->boolean('verifikasi')->default(false);
            // $table->string('profile_picture')->nullable()->default('default-profile.png');
            $table->string('profile_picture')->nullable()->default('1677490183-user.jpg');
            $table->string('profile_cover')->nullable()->default('default-banner.png');
            $table->timestamps();
            // $table->bigInteger('follower')->nullable()->default(0);
            // $table->bigInteger('following')->nullable()->default(0);
            // $table->rememberToken();
            // $table->timestamp('email_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
