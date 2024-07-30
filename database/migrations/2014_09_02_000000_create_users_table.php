<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('civilite')->nullable();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('folder')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->string('cni')->nullable();
            $table->integer('anciennete')->nullable();
            $table->boolean('complet')->default(false);
            $table->timestamp('date_naissance')->nullable();
            $table->enum('status', ['PARTICULIER', 'ENTREPRISE'])->nullable();
            $table->unsignedBigInteger('profil')->nullable();
            $table->unsignedBigInteger('role')->nullable();
            $table->string('pays')->nullable();
            $table->string('ville')->nullable();
            $table->string('profession')->nullable();
            $table->text('parcours')->nullable();
            $table->string('device_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('profil')->references('id')->on('profile_investisseurs')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('status')->references('type')->on('profil_porteur_projets')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('role')->references('id')->on('roles')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
