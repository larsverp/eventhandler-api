<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHosUsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hos_uses', function (Blueprint $table) {
            $table->id();
            $table->uuid('host_id');
            $table->uuid('user_id');
            $table->integer('points')->default(0);
            $table->boolean('following')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hos_uses');
    }
}
