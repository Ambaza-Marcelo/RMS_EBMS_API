<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockoutDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockout_details', function (Blueprint $table) {
            $table->id();
            $table->string('quantity');
            $table->text('observation')->nullable(true);
            $table->date('date');
            $table->string('unit')->nullable(true);
            $table->string('bon_no');
            $table->string('total_value');
            $table->string('created_by');
            //numero de recquisition
            $table->string('requisition_no')->nullable(true);
            //Demandeur
            $table->string('asker')->nullable(true);
            $table->string('destination')->nullable(true);
            $table->bigInteger('article_id')->unsigned();
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
        Schema::dropIfExists('stockout_details');
    }
}
