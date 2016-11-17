<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorreiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('assunto');
            $table->string('observacoes');
            $table->integer('inserido_por');
            $table->integer('alterado_por')->nullable();
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
        Schema::dropIfExists('correios');
    }
}
