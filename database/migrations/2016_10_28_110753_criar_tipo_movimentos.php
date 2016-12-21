<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriarTipoMovimentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_movimentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao');
            $table->integer('inserido_por')->nullable();
            $table->integer('alterado_por')->nullable();
            $table->timestamps();
        });

        DB::table('tipo_movimentos')->insert([
            'descricao' => 'Entrada',
        ]);
        DB::table('tipo_movimentos')->insert([
            'descricao' => 'Saída',
        ]);
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
