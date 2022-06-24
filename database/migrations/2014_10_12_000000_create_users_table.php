<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->foreignId('category_id')->constrained()->onDelete('set null');
            $table->foreignId('country_id')->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('state')->nullable();
            $table->text('address')->nullable();
            $table->string('city');
            $table->json('city_coordinates');
            $table->string('lang')->nullable();
            $table->text('avatar')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
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
}
