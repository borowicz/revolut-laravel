<?php

namespace App\Livewire\Revolut;

use Livewire\Component;

abstract class AbstractComponent extends Component
{
    public $showAll = false;

    protected $paginationTheme = 'tailwind';

    public $showButtons = true;

    public $tickers = [];

    public $ticker; // Add this if you need to use $ticker

    public $searchBox = false;

    public $search = '';

    public $perPage = 10; // Number of items per page

    public $sortField = 'date';

    public $sortDirection = 'DESC';

    public $selectedTicker = null;

    public $types;

    public $selectedType = null;

    public function mount($ticker = null, $perPage = 10) // initialize $ticker
    {
        $this->ticker = $ticker;
        $this->perPage = $perPage;
    }

    public function setPagination($query)
    {
        if (empty($this->perPage)) {
            $items = $query->get();
        } else {
            $items = $query->paginate($this->perPage);
        }

        return $items;
    }

    public function hasPagination($items)
    {
        // Check if the results are paginated (only paginated instances have hasPages method)
        if ($items instanceof \Illuminate\Pagination\AbstractPaginator) {
            $hasPages = $items->hasPages();
        } else {
            $hasPages = false;
        }

        return $hasPages;
    }
}
