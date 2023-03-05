<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDrinkDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_drink_details', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('commande_no');
            $table->bigInteger('employe_id')->unsigned();
            $table->string('status')->default('0');
            $table->string('table_no')->nullable(true);
            $table->string('auteur')->nullable(true);
            $table->text('description')->nullable(true);
            $table->string('quantity');
            $table->string('total_value');
            $table->bigInteger('article_id')->unsigned();
            $table->foreign('article_id')
                    ->references('id')
                    ->on('articles')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreign('employe_id')
                    ->references('id')
                    ->on('employes')
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
        Schema::dropIfExists('order_drink_details');
    }
}
