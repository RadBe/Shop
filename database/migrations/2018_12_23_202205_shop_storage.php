<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopStorage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_shop_storage', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('server_id')->unsigned();
            $table->string('uuid', '64');
            $table->string('item');
            $table->integer('amount')->unsigned();
            $table->timestamp('date')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::table('site_shop_storage', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['server_id']);
            $table->dropIfExists();
        });
    }
}
