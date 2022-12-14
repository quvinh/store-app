<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name', 50);
            $table->char('supplier_code', 20);
            $table->char('supplier_codetax', 20);
            $table->char('supplier_phone', 15);
            $table->string('supplier_email', 100)->nullable();
            $table->boolean('supplier_type')->nullable();// personally or enterprise
            $table->tinyInteger('supplier_status');
            $table->char('supplier_citizenid', 20)->nullable();
            $table->bigInteger('bank_id')->nullable();
            $table->string('supplier_branch', 200)->nullable();
            $table->char('supplier_numbank', 20)->nullable();
            $table->string('supplier_ownerbank', 50)->nullable();
            $table->text('supplier_note')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
}
