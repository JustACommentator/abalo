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
        Schema::create('ab_article_has_articlecategory', function(Blueprint $table){
            $table->id()->comment('Primärschlüssel');
            $table->integer('ab_articlecategory_id')->nullable(false)->comment('Referenz auf eine Artikelkategorie');
            $table->integer('ab_article_id')->nullable(false)->comment('Referenz auf einen Artikel');
            $table->foreign('ab_articlecategory_id')->references('id')->on('ab_articlecategory');
            $table->foreign('ab_article_id')->references('id')->on('ab_article');
            $table->unique(['ab_articlecategory_id', 'ab_article_id']);
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
