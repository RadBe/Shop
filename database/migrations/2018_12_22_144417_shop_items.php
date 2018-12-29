<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_shop_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 16);
            $table->string('name');
            $table->string('description')->nullable();
            $table->text('extra');
            $table->foreign('type')->references('id')->on('site_shop_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_shop_items', function (Blueprint $table) {
            $table->dropForeign(['type']);
            $table->dropIfExists();
        });
    }
}
