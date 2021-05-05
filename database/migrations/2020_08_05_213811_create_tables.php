<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon');
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->unsignedTinyInteger('rating');
            $table->timestamp('date');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
        });

        Schema::create('post_photos', function (Blueprint $table) {
            $table->id();
            $table->string('photo');
            $table->unsignedBigInteger('post_id');
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            $table->timestamp('date');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id');
        });

        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('follower_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('followers');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('post_photos');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('categories');
    }
}
