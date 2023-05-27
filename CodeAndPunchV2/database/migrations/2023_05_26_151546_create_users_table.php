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
                ->nullable()
                ->change();
            $table
                ->string('phone')
                ->default('')
                ->nullable();
            $table->enum('role', ['student', 'teacher', 'admin'])->default('student');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table
                ->string('email')
                ->nullable(false)
                ->change();
        });
        Schema::dropIfExists('users');
    }
}
