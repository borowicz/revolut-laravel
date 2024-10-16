<?php

namespace App\Livewire\Revolut;

use App\Http\Controllers\Revolut\AbstractRevolutController;
use Livewire\Component;

abstract class AbstractComponent extends Component
{
    public $showAll = false;

    public $paginationTheme = 'tailwind';

    public $showButtons = true;

    public $searchBox = false;

    public $search = '';

    public $perPage = 10; // Number of items per page
    public $sortField = 'date';
    public $sortDirection = 'DESC';

    public $selectedTicker = null;
    public $tickers;
    public $ticker;

    public $types;
    public $itemStatus = [];

    public $selectedType = null;

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

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'DESC';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function reloadPage()
    {
        $this->emit('reloadPage');
    }

    public function setStatusDisabled(mixed $modelClass, int $itemId): void
    {
        try {
            $model = new $modelClass();
            $model = $model->find($itemId);
            $newStatus = $model->disabled ? 0 : 1; // Toggle status
            $model->disabled = $newStatus;
            $model->save();

            $this->itemStatus[$itemId] = $newStatus;

            session()->flash('message', 'Status updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update status: ' . $e->getMessage());
        }
    }
}
