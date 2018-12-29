<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopPacks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_shop_packs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->integer('amount')->unsigned();
            $table->foreign('product_id')->references('id')->on('site_shop_products')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('site_shop_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_shop_packs', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['item_id']);
            $table->dropIfExists();
        });
    }
}
