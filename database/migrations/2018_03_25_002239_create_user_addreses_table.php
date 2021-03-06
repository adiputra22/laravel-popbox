<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddresesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addreses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->text('address');
            $table->text('address_2');
            $table->string('zip_code',10);
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->index(['name', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_addreses');
    }
}
