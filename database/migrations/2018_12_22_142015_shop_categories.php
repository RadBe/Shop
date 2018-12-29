<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_shop_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('server_id')->unsigned()->nullable();
            $table->string('name');
            $table->smallInteger('weight')->default(1);
            $table->foreign('server_id')->references('id')->on('site_servers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_shop_categories', function (Blueprint $table) {
            $table->dropForeign(['server_id']);
            $table->dropIfExists();
        });
    }
}
