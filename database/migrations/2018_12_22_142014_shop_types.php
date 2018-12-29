<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_shop_types', function (Blueprint $table) {
            $table->string('id', 24)->unique()->index();
            $table->string('name');
            $table->string('distributor');
            $table->text('extra');
            $table->primary(['id']);
        });

        \Illuminate\Support\Facades\DB::table('site_shop_types')
            ->insert([
                'id' => 'item',
                'name' => 'Предмет',
                'distributor' => '\App\Services\Shop\Distributor\FleynaroDistributor',
                'extra' => '{"id":"Игровой ID предмета"}'
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_shop_types');
    }
}
