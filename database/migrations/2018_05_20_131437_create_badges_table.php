<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->increments('id');
            /**
             * Name
             * Date achieved
             * Type
             * Level
             * Description
             * Image
             * Description
             */
            $table->string('name');
            $table->string('type');
            $table->unsignedInteger('level');
            $table->text('description');
            $table->string('image_url');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('badge_ninja_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('badge_id');
            $table->unsignedInteger('ninja_profile_id');
            $table->unsignedInteger('rewarded_by');
            $table->timestamps();

            $table->foreign('badge_id')->references('id')->on('badges');
            $table->foreign('ninja_profile_id')->references('id')->on('ninja_profiles');
            $table->foreign('rewarded_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('badge_ninja_profile', function (Blueprint $table) {
            $table->dropForeign(['badge_id']);
            $table->dropForeign(['ninja_profile_id']);
            $table->dropForeign(['rewarded_by']);
            $table->drop();
        });
        Schema::dropIfExists('badges');
    }
}
