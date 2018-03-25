<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locker_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->text('address');
            $table->text('address_2');
            $table->string('zip_code',10);
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('city_id')->unsigned();
            $table->integer('building_type_id')->unsigned();
            $table->string('operasional_hours');
            $table->string('locker_capacity');
            $table->timestamps();
            $table->index(['name', 'city_id', 'building_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
