<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('quantity');
            $table->string('unit')->default('');
            $table->string('commande_no');
            $table->text('description');
            $table->string('total_value');
            $table->string('start_date')->nullable(true);
            $table->string('end_date')->nullable(true);
            $table->string('created_by');
            $table->string('status')->default('1');
            $table->bigInteger('supplier_id')->unsigned();
            $table->foreign('supplier_id')
                    ->references('id')
                    ->on('suppliers')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('order_details');
    }
}
