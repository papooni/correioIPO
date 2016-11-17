<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nr_mecanografico')->unique;
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('ativo')->default(1);
            $table->boolean('admin')->default(0);
            $table->boolean('notificacoes')->default(0);
            $table->integer('inserido_por');
            $table->integer('alterado_por')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([

            'nome' => 'admin',
            'nr_mecanografico' => '1111',
            'email' => '8030083@gmail.com',
            'password' => bcrypt('123456'),
            'admin' => 1

        ]);




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
