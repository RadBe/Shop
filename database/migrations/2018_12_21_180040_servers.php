<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Servers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_servers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64);
            $table->boolean('enabled')->default(0);
            $table->integer('shop_id')->unsigned();
            $table->string('ip', 64);
            $table->integer('query_port');
            $table->integer('rcon_port');
            $table->string('rcon_pass');
            $table->timestamp('created_at')->useCurrent()->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_servers');
    }
}
