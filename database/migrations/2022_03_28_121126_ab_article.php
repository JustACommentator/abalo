<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ab_article', function (Blueprint $table) {
            $table->id()->comment('Primärschlüssel')->autoIncrement();
            $table->char('ab_name', 80)->nullable(false)->comment('Name');
            $table->integer('ab_price')->nullable(false)->comment('Price in Cent');
            $table->char('ab_description', 1000)->nullable(false)->comment('Beschreibung, die die Güte oder die Beschaffenheit näher darstellt. Wird durch den "Ersteller" (ab_user) gepflegt');
            $table->integer('ab_creator_id', false, true)->nullable(false)->comment('Referenz auf den/die Nutzer:in, der den Artikel erstellt hat und verkaufen möchte');
            $table->timestamp('ab_createdate')->nullable(false)->comment('Zeitpunk der Erstellung des Artikels');
            $table->foreign('ab_creator_id')->references('id')->on('ab_user');
        });
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
};
