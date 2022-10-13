<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->char('warehouse_code', 20);
            $table->string('warehouse_name');
            $table->char('warehouse_contact');
            $table->string('warehouse_street');
            $table->tinyInteger('warehouse_status');
            $table->text('warehouse_note')->nullable();
            $table->string('warehouse_image')->nullable();
            $table->bigInteger('country_id')->nullable();
            $table->bigInteger('city_id')->nullable();
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
        Schema::dropIfExists('warehouses');
    }
}
