<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('phone', 20);
            $table->boolean('will_pickup_children');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('ninja_profile_parent_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_profile_id');
            $table->unsignedInteger('ninja_profile_id');
            $table->string('relation')->nullable()->default(null);

            $table->foreign('parent_profile_id')->references('id')->on('parent_profiles');
            $table->foreign('ninja_profile_id')->references('id')->on('ninja_profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ninja_profile_parent_profile', function (Blueprint $table) {
            $table->dropForeign(['parent_profile_id']);
            $table->dropForeign(['ninja_profile_id']);
            $table->drop();
        });

        Schema::table('parent_profiles', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->drop();
        });
    }
}
