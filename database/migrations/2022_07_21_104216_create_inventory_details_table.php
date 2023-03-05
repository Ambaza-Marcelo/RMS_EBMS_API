<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_details', function (Blueprint $table) {
            $table->id();
            $table->string('inventory_no')->nullable();
            $table->string('date');
            $table->string('title')->nullable();
            $table->string('quantity');
            $table->string('unit');
            $table->string('unit_price');
            $table->string('total_value');
            $table->string('new_quantity')->nullable();
            $table->string('new_price')->nullable();
            $table->string('new_total_value');
            $table->string('relica');
            $table->text('description');
            $table->string('created_by');
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
        Schema::dropIfExists('inventory_details');
    }
}
