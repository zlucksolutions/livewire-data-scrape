<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_markets', function (Blueprint $table) {
            $table->id();
            $table->string('ticker')->nullable();
            $table->string('url')->nullable();
            $table->string('price')->nullable();
            $table->string('chg')->nullable();
            $table->string('rsi')->nullable();
            $table->string('macd')->nullable();
            $table->string('pe_ratio')->nullable();
            $table->string('volume')->nullable();
            $table->string('52_week_high')->nullable();
            $table->string('one_month')->nullable();
            $table->string('three_month')->nullable();
            $table->string('six_month')->nullable();
            $table->string('one_year')->nullable();
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
        Schema::dropIfExists('stock_markets');
    }
}
