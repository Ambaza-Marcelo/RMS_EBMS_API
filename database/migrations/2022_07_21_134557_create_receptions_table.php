<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receptions', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('reception_no');
            $table->string('invoice_no');
            $table->string('commande_no');
            $table->string('supplier');
            $table->string('receptionist');
            $table->string('created_by');
            $table->string('status')->nullable();
            //bordereau d'expedition
            $table->string('waybill')->nullable(true);
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receptions');
    }
}
