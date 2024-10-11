<?php

namespace App\Models\Revolut\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Revolut\AbstractRevolutModel;

class StockCost extends AbstractRevolutModel
{
    use HasFactory;

    protected $fillable = [ // @todo: add fillable fields migrations/2024_10_01_090916_create_table_stock_costs.php

        ];
}
