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
            $table->char('item_barcode', 20)->nullable();
            $table->string('item_name');
            $table->string('item_unit');
            $table->float('item_importprice')->nullable();
            $table->float('item_exportprice')->nullable();
            $table->float('item_quantity')->default(0);
            $table->float('item_error')->default(0);
            $table->text('item_images')->nullable();
            $table->float('item_weight')->nullable();
            $table->char('item_weightuint', 2)->nullable();
            $table->float('item_long')->nullable();
            $table->float('item_width')->nullable();
            $table->float('item_height')->nullable();
            $table->tinyInteger('item_status')->default(0);
            $table->text('item_note')->nullable();
            $table->bigInteger('category_id');
            $table->boolean('item_bigsize')->default(0); // Kich co vat tu (to/nho)
            $table->dateTime('item_manufacturing')->nullable(); // Ngay san xuat
            $table->dateTime('item_date')->nullable(); // Ngay het han
            $table->bigInteger('item_max')->default(1000000); // Dinh muc toi da
            $table->integer('item_min')->default(0); // Dinh muc toi thieu
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
