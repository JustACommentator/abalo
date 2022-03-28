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
        Schema::create('ab_articlecategory', function (Blueprint $table) {
            $table->id()->comment('Primärschlüssel');
            $table->char('ab_name', 100)->nullable(false)->unique()->comment('Name');
            $table->char('ab_description', 1000)->nullable()->comment('Beschreibung');
            $table->integer('ab_parent')->nullable()->comment('Referenz auf die mögliche Elternkategorie.
                                                                                Artikelkategorien sind hierarchisch organisiert. Eine Kategorie kann beliebig viele Kind Kategorien haben. Eine Kategorie kann nur eine Elternkategorie besitzen.
                                                                                NULL, falls es keine Elternkategorie gibt und es sich um eine Wurzelkategorie handelt.');
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
