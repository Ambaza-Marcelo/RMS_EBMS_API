<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceptionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reception_details', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('reception_no');
            $table->string('invoice_no');
            $table->string('commande_no');
            $table->string('supplier');
            $table->bigInteger('article_id')->unsigned();
            $table->string('quantity');
            $table->string('unit')->nullable(true);
            $table->string('unit_price');
            $table->string('total_value');
            $table->string('remaining_quantity')->nullable();
            $table->string('created_by');
            $table->text('description');
            $table->string('status')->nullable();
            //bordereau d'expedition
            $table->string('waybill')->nullable(true);
            $table->string('receptionist');
            $table->foreign('article_id')
                    ->references('id')
                    ->on('articles')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('reception_details');
    }
}
