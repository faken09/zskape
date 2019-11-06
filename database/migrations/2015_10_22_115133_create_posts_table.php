<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->char('id', 10);
            $table->integer('user_id')->unsigned();
            $table->string('title', 300);
            $table->char('file_thumb', 11)->unique();
            $table->char('file_extension', '4');
            $table->char('file_mime', '20');
            $table->integer('up')->default(1);
            $table->integer('down')->default(0);
            $table->integer('rating')->default(1);
            $table->timestamps();

            $table->primary('id');

        });

        Schema::table('posts', function ($table) {
            // cascade delete users posts
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });


        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::drop('posts');
    }
}
