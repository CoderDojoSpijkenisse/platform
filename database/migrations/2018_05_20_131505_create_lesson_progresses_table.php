<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonProgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_progresses', function (Blueprint $table) {
            $table->increments('id');
            /**
             * feedback
             * quiz
             * signoff (person and date)
             * notes
             * public
             */
            $table->unsignedInteger('ninja_profile_id');
            $table->unsignedInteger('lesson_id');
            $table->unsignedInteger('feedback')->nullable();
            $table->unsignedInteger('signed_off_by')->nullable()->default(null);
            $table->dateTime('signed_off_at')->nullable()->default(null);
            $table->text('notes')->nullable();
            $table->boolean('public')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('lesson_id')->references('id')->on('lessons');
            $table->foreign('signed_off_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lesson_progresses', function (Blueprint $table) {
            $table->dropForeign(['lesson_id']);
            $table->dropForeign(['signed_off_by']);
            $table->drop();
        });
    }
}
