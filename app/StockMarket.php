<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMarket extends Model
{
    use HasFactory;

    protected $table = 'stock_markets';

    protected $fillable = ['ticker','url','price','chg','rsi','macd','pe_ratio','volume','52_week_high','one_month','three_month','six_month','one_year'];

    public $timestamps = true;
}
