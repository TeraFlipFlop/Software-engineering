<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfiloCSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profili_candidato', function (Blueprint $table) {
            $table->id();
            $table->text('titolo_studi');
            $table->text('telefono');
            $table->text('nome');
            $table->text('congnome');
            $table->integer('età');
            $table->text('settore');
            $table->text('indirizzo');
            $table->json('skills');
            $table->text('regione');
            $table->text('tipo_contratto');
            $table->text('email');

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
        Schema::dropIfExists('profilo_c_s');
    }
}
