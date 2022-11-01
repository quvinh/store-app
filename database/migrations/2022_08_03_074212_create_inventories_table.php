<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->char('inventory_code', 20);
            $table->tinyInteger('inventory_status');
            $table->text('inventory_note')->nullable();
            $table->bigInteger('invoice_id');
            $table->bigInteger('created_by');
            $table->bigInteger('warehouse_id');
            $table->string('participants')->nullable();
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
        Schema::dropIfExists('inventories');
    }
}
