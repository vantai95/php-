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
            $table->timestamps();
            $table->integer('role_id')->nullable();
            $table->string('full_name')->nullable();
            $table->string('email', 50)->unique()->nullable();
            $table->string('phone', 20)->unique()->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();

            $table->boolean('is_locked')->default(false);
            $table->boolean('has_password')->default(true);
            $table->string('fb_uid')->nullable();
            $table->string('google_uid')->nullable();

            $table->date('birth_day')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('address', 300)->nullable();
            $table->string('image_1')->nullable();
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
