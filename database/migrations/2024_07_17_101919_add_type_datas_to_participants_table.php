<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeDatasToParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participants', function (Blueprint $table) {
            //
            $table->text('porteurProjet')->nullable();
            $table->text('presentationUn')->nullable();
            $table->text('presentationDeux')->nullable();
            $table->text('environnement')->nullable();
            $table->text('financement')->nullable();
            $table->text('impact')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participants', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('porteurProjet');
            $table->unsignedBigInteger('presentationUn');
            $table->unsignedBigInteger('presentationDeux');
            $table->unsignedBigInteger('environnement');
            $table->unsignedBigInteger('financement');
            $table->unsignedBigInteger('impact');
        });
    }
}
