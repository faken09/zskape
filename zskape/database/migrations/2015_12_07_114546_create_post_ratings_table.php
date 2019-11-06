<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
        //    public function up()
        {
            Schema::create('post_ratings', function (Blueprint $table) {
                $table->increments('id');
                $table->char('post_id', '10');
                $table->integer('user_id')->unsigned();
                $table->boolean('voted');
                $table->timestamps();
            });

            Schema::table('post_ratings', function ($table) {
                // cascade delete users posts
                // cascade delete posts comments
                $table->foreign('post_id')
                    ->references('id')
                    ->on('posts')
                    ->onDelete('cascade');


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
        //
    }
}
