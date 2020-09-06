<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfiloOffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profili_offerente', function (Blueprint $table) {
            $table->id();
            $table->text('desc');
            $table->text('ragione_sociale');
            $table->text('telefono');

            $table->text('email');
            $table->text('categoria_settore');
            $table->text('indirizzo');
            $table->text('regione');

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
        Schema::dropIfExists('profilo_offs');
    }
}
