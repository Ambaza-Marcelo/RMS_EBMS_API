<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactureRestaurantDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facture_restaurant_details', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->nullable(true);
            $table->timestamp('invoice_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('tp_type')->nullable(true);
            $table->string('tp_name')->nullable(true);
            $table->string('tp_TIN')->nullable(true);
            $table->string('tp_trade_number')->nullable(true);
            $table->string('tp_phone_number')->nullable(true);
            $table->string('tp_address_province')->nullable(true);
            $table->string('tp_address_commune')->nullable(true);
            $table->string('tp_address_quartier')->nullable(true);
            $table->string('tp_address_avenue')->nullable(true);
            $table->string('tp_address_rue')->nullable(true);
            $table->string('tp_address_number')->nullable(true);
            $table->string('vat_taxpayer')->nullable(true);
            $table->string('ct_taxpayer')->nullable(true);
            $table->string('tl_taxpayer')->nullable(true);
            $table->string('tp_fiscal_center')->nullable(true);
            $table->string('tp_activity_sector')->nullable(true);
            $table->string('tp_legal_form')->nullable(true);
            $table->string('payment_type')->nullable(true);
            $table->string('customer_name')->nullable(true);
            $table->string('customer_TIN')->nullable(true);
            $table->string('customer_address')->nullable(true);
            $table->string('vat_customer_payer')->nullable(true);
            $table->string('cancelled_invoice_ref')->nullable(true);
            $table->string('cancelled_invoice')->nullable(true);
            $table->string('invoice_ref')->nullable(true);
            $table->string('cn_motif')->nullable(true);
            $table->string('commande_no')->nullable(true);
            $table->string('invoice_currency')->nullable(true);
            $table->timestamp('invoice_signature_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('invoice_signature')->nullable(true);
            $table->string('item_designation')->nullable(true);
            $table->string('item_quantity')->nullable(true);
            $table->string('item_price')->nullable(true);
            $table->string('item_ct')->nullable(true);
            $table->string('item_tl')->nullable(true);
            $table->string('item_price_nvat')->nullable(true);
            $table->string('vat')->nullable(true);
            $table->string('item_price_wvat')->nullable(true);
            $table->string('item_total_amount')->nullable(true);
            $table->string('etat')->default('0');
            $table->bigInteger('employe_id')->unsigned()->nullable(true);
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
        Schema::dropIfExists('facture_restaurant_details');
    }
}