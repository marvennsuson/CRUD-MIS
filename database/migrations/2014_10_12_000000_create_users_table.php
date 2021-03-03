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
            $table->integer('user_group_id')->nullable();
            $table->tinyInteger('user_level')->default(9);
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->string('exname')->nullable();
            $table->string('gender')->nullable();
            $table->string('age')->nullable();
            $table->string('dob')->nullable();
            $table->longText('address')->nullable();
            $table->string('mobile')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('postalcode')->nullable();
            $table->longText('barangay')->nullable();
            $table->string('housenumber')->nullable();
            $table->longText('streetname')->nullable();
            $table->longText('otherinfo')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('visibility')->default(1);
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
