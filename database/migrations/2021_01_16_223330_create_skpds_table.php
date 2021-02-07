<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkpdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skpds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('namaskpd');
            $table->string('alamat');
            $table->string('tlp');
            $table->string('kota');
            $table->string('pembuat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skpds');
    }
}
