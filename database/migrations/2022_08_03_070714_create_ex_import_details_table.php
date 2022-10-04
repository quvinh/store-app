<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExImportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ex_import_details', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->bigInteger('exim_id');
            $table->bigInteger('item_id');
            $table->float('item_quantity');
            $table->float('item_price');
            $table->float('item_total');
            $table->float('item_vat');
            $table->bigInteger('supplier_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ex_import_details');
    }
}
