<?php

namespace App\Models\Revolut\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Revolut\AbstractRevolutModel;

class StockProfitLossTransaction extends AbstractRevolutModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'hash',
            'date_acquired',    //Date acquired
            'date_sold',        //Date sold
            'symbol',           //Symbol
            'security_name',    //Security name
            'isin',             //ISIN
            'country',          //Country
            'quantity',         //Quantity
            'cost_basis',       //Cost basis
            'gross_proceeds',   //Gross proceeds
            'gross_pnl',        //Gross PnL
            'currency',         //Currency
        ];
}
