<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('key')->unique();
            $table->unsignedBigInteger('user_id');

            $table->string('shipperName');
            $table->string('shipperNum');
            $table->string('shipperAddress');

            $table->string('recieverName');
            $table->string('recieverNum');
            $table->string('recieverAddress');

            $table->string('type');
            $table->float('weight');
            $table->string('departure');
            $table->string('destination');
            $table->string('bookingMode');
            $table->float('amount');
            $table->string('mode');
            $table->string('pickupDate');
            $table->text('description');
            
            $table->timestamps();
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shippments');
    }
}
