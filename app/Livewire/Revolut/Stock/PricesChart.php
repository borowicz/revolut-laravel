<?php

namespace App\Livewire\Revolut\Stock;

use Livewire\Component;

class PricesChart extends Component
{
    public $timePeriod = 'daily';
    public $stockData = [];

    public function mount()
    {
        $this->loadStockData();
    }

    public function loadStockData()
    {
        // Example stock data - you would replace this with actual API calls
        // Daily, Weekly, Monthly, Yearly Stock Data
        $data = [
            'daily' => [100, 102, 98, 105, 110],
            'weekly' => [95, 97, 100, 102, 105],
            'monthly' => [90, 95, 100, 105, 110],
            'yearly' => [80, 85, 90, 95, 100],
        ];

        $this->stockData = $data[$this->timePeriod];
    }

    public function updatedTimePeriod()
    {
        $this->loadStockData();  // Load new data based on the selected period
        $this->dispatchBrowserEvent('refreshChart', ['data' => $this->stockData]); // Refresh the chart
    }

    public function render()
    {
        return view('livewire.pages.stock.price-chart', [
            'stockData' => $this->stockData,
        ]);
    }
}
