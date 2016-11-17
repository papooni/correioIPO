<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('correios_id');
            $table->integer('tipo_movimentos_id');
            $table->string('observacoes');
            $table->boolean('lido')->default(0);
            $table->integer('colaborador_origem');
            $table->integer('servico_origem');
            $table->integer('colaborador_destino');
            $table->integer('servico_destino');
            $table->integer('recebido_por');
            $table->timestamp('recebido_em');
            $table->integer('inserido_por');
            $table->integer('alterado_por')->nullable();
            //created_at
            //updated_at
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
        Schema::dropIfExists('movimentos');
    }
}
