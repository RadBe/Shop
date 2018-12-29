<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Groups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_donate_durations', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('server_id')->unsigned()->nullable();
            $table->string('status', 32);
            $table->timestamp('date_start')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('date_end');
            $table->foreign('user_id')->references('user_id')->on('dle_users')->onDelete('cascade');
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
        Schema::table('site_donate_durations', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['server_id']);
            $table->dropIfExists();
        });
    }
}
