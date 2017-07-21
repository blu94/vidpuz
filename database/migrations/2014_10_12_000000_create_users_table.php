<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('surname');
            $table->string('givenname');
            $table->string('username');
            $table->boolean('is_active')->default(1);
            $table->string('email')->unique();
            $table->integer('role_id')->index()->unsigned()->default(1);
            $table->boolean('first_login')->default(1);
            $table->dateTime('birthday')->nullable();
            $table->string('gender')->default('M');
            $table->string('password');
            $table->longText('bio')->nullable();
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
