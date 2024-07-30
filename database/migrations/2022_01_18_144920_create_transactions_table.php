<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('trans_id');
            $table->string('telephone')->nullable();
            $table->string('methode')->nullable();
            $table->enum('etat', ['INITIE', 'REUSSI', 'ECHOUE'])->default('INITIE');
            $table->bigInteger('montant');
            $table->boolean('valider')->default(false);
            $table->enum('type', ['INSCRIPTION', 'PROFIL', 'PROJET', 'EVENT'])->default('INSCRIPTION');
            $table->foreignId('projet_id')
                ->nullable()
                ->constrained('projets')
                ->onDelete('cascade');
            $table->foreignId('event_id')
                ->nullable()
                ->constrained('evenements')
                ->onDelete('cascade');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('participant_id')
                ->nullable()
                ->constrained('participants')
                ->onDelete('cascade');
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
        Schema::dropIfExists('transactions');
    }
}
