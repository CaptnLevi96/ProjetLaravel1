<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('livres', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('auteur');
            $table->integer('annee_publication');
            $table->text('resume');
            $table->decimal('prix', 8, 2);
            $table->date('date_creation');
            $table->date('date_modification');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('livres');
    }
};