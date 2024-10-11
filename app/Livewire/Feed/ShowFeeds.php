<?php

namespace App\Livewire\Feed;

use App\Models\Revolut\Stock\StockTicker;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\NewsFeed;

class ShowFeeds extends Component
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
    public $hasPages = false;

    public function mount()
    {
        $this->itemStatus = NewsFeed::pluck('disabled', 'id')->toArray();
    }

    public function render()
    {
        $query = NewsFeed::query()
            ->orderBy($this->sortField, $this->sortDirection);

        if (empty($this->perPage)) {
            $items = $query->get();
        } else {
            $items = $query->paginate($this->perPage);
        }

        return view('livewire.pages.feeds.show', [
            'items'    => $items,
            'hasPages' => false,
        ])->layout('layouts.app');
    }

    public function delete(Note $note)
    {
        $note->delete();
    }

    public function updateStatus($itemId)
    {
        try {
            $model = NewsFeed::find($itemId);
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
