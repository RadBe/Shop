<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_shop_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id')->unsigned()->nullable()->comment('Null если это набор');
            $table->integer('category_id')->unsigned();
            $table->integer('amount')->unsigned();
            $table->integer('price')->unsigned();
            $table->smallInteger('discount')->unsigned()->default(0)->comment('Скидка в % от 1 до 99, 0 - без скидки');
            $table->dateTime('discount_time')->nullable()->default(null)->comment('До какого числа скидка');
            $table->text('for_groups')->nullable()->comment('Для каких групп доступна покупка');
            $table->string('name')->nullable()->comment('Название, например для наборов');
            $table->string('pic')->nullable()->comment('Картинка, например для наборов');
            $table->boolean('enabled')->default(false);
            $table->timestamp('created_at')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('item_id')->references('id')->on('site_shop_items')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('site_shop_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_shop_products', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
            $table->dropForeign(['category_id']);
            $table->dropIfExists();
        });
    }
}
