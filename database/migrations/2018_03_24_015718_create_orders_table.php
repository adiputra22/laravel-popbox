<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference');
            $table->string('delivery_type');
            $table->integer('origin_id');
            $table->string('origin_name');
            $table->string('origin_address');
            $table->integer('destination_id');
            $table->string('destination');
            $table->string('user_id');
            $table->string('contact');
            $table->string('status');
            $table->text('notes');
            $table->timestamps();
            $table->index('reference');
            $table->index('delivery_type');
            $table->index('origin_id');
            $table->index('destination_id');
            $table->index('user_id');
            $table->index('contact');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
