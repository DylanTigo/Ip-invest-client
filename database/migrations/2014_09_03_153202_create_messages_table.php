<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('envoyeur');
            $table->unsignedBigInteger('recepteur');
            $table->unsignedBigInteger('projet')->nullable();
            $table->text('message');
            $table->uuid('conversation');
            $table->boolean('vu')->default(false);
            $table->foreign('envoyeur')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('recepteur')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('projet')->references('id')->on('projets')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('messages');
    }
}
