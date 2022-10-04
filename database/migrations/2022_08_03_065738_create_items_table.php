<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_code');
            $table->char('item_barcode', 20);
            $table->string('item_name');
            $table->float('item_importprice');
            $table->float('item_exportprice');
            $table->float('item_quantity');
            $table->float('item_error')->default(0);
            $table->text('item_images')->nullable();
            $table->float('item_weight')->nullable();
            $table->char('item_weightuint', 2)->nullable();
            $table->float('item_long')->nullable();
            $table->float('item_width')->nullable();
            $table->float('item_height')->nullable();
            $table->tinyInteger('item_status');
            $table->text('item_note')->nullable();
            $table->bigInteger('category_id');
            $table->bigInteger('warehouse_id');
            $table->bigInteger('supplier_id');
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
        Schema::dropIfExists('items');
    }
}
