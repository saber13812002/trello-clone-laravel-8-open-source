<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBoardCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('board_card', function (Blueprint $table) {
            $table->unsignedInteger('owner_id')->nullable();            
            $table->foreign('owner_id')->references('id')->on('users');
            //updateCardownerid
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumn('owner_id');
    }
}
