<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_files', function (Blueprint $table) {
            $table->increments('cf_id');
            $table->integer('comment_id')->unsigned();
            $table->char('file', 12)->unique();
            $table->char('file_thumb', 13)->unique();
            $table->char('file_extension', '4');
            $table->char('file_mime', '20');
        });

        Schema::table('comment_files', function ($table) {
            // cascade delete users posts
            // cascade delete posts comments
            $table->foreign('comment_id')
                ->references('id')
                ->on('comments')
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
