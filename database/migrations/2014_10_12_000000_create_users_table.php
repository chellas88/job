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
            $table->integer('category_id')->nullable();
//            $table->integer('country_id')->nullable();
            $table->string('country')->nullable();
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('email')->unique();
            $table->string('state')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->json('coordinates')->nullable();
            $table->string('lang')->nullable();
            $table->text('avatar')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('google_id')->nullable();
            $table->boolean('recommended')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->string('role')->nullable();
            $table->boolean('policy')->nullable();
            $table->text('tags')->nullable();
            $table->text('description_ua')->nullable();
            $table->text('description_ru')->nullable();
            $table->text('description_en')->nullable();
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
