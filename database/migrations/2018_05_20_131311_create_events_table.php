<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->dateTime('time_start');
            $table->dateTime('time_end');
            $table->string('address_street')->nullable()->default(null);
            $table->string('address_postal_code', 10)->nullable()->default(null);
            $table->string('address_city')->nullable()->default(null);
            $table->unsignedInteger('capacity');
            $table->unsignedInteger('eventbrite_id')->nullable();
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
        Schema::dropIfExists('events');
    }
}
