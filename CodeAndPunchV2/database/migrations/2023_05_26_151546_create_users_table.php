<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table
                ->string('full_name')
                ->default('')
                ->nullable();
            $table
                ->string('email')
                ->default('')
                ->nullable();
            $table
                ->string('phone')
                ->default('')
                ->nullable();
            $table->enum('role', ['student', 'teacher', 'admin'])->default('student');
            $table->timestamps();
            $table->rememberToken();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}