<?php

use Carbon\Carbon;
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
        Schema::create('ab_shoppingcart_item', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('ab_shoppingcart_id');
            $table->unsignedBigInteger('ab_article_id');
            $table->timestamp('ab_createdate')->default(Carbon::now()->toDateTimeString());

            $table->foreign('ab_shoppingcart_id')
                ->references('id')
                ->on('ab_shoppingcart')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('ab_article_id')
                ->references('id')
                ->on('ab_article');

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
