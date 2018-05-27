<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_goals', function (Blueprint $table) {
            $table->increments('id');
            /**
             * name
             * type
             * level
             * gebruiken / uitleggen / toepassen (3x bool)
             */
            $table->string('title');
            $table->string('type');
            $table->unsignedInteger('level');
//            $table->boolean('can_use')->default(false);
//            $table->boolean('can_explain')->default(false);
//            $table->boolean('can_apply')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_goals');
    }
}
