<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_details', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->bigInteger('transfer_id');
            $table->bigInteger('itemdetail_id');
            $table->float('item_quantity');
            $table->bigInteger('shelf_from')->nullable();
            $table->integer('floor_from')->nullable();
            $table->integer('cell_from')->nullable();
            $table->bigInteger('shelf_to')->nullable();
            $table->integer('floor_to')->nullable();
            $table->integer('cell_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfer_details');
    }
}
