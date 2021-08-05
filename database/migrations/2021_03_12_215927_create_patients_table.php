<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement()->unsigned();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('image', 200)->nullable();
            $table->date('birth_date')->nullable();
            $table->boolean('gender')->nullable();
            $table->string('address', 200)->nullable();
            $table->string('facebook_id', 200)->nullable();
            $table->string('google_id', 200)->nullable();
            $table->string('apple_id', 200)->nullable();
            $table->string('lang')->default('en');
            $table->string('token', 200)->nullable();
            $table->string('hash', 200)->nullable();
            $table->timestamps();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
