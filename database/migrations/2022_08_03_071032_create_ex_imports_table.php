<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ex_imports', function (Blueprint $table) {
            $table->id();
            $table->char('exim_code', 20);
            $table->tinyInteger('exim_status');
            $table->tinyInteger('exim_type');
            $table->bigInteger('invoice_id');
            $table->bigInteger('warehouse_id');
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('ex_imports');
    }
}
