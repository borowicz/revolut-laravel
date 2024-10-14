<?php

namespace App\Models\Revolut\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Revolut\AbstractRevolutModel;

class StockProfitLossOtherTransaction extends AbstractRevolutModel
{
    protected $fillable = [
            'hash',
            'date',             //Date
            'symbol',           //Symbol
            'security_name',    //Security name
            'isin',             //ISIN
            'country',          //Country
            'gross_amount',     //Gross amount
            'withholding_tax',  //Withholding tax
            'net_amount',       //Net Amount
            'currency',         //Currency
        ];
}
