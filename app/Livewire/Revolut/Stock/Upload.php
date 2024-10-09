<?php

namespace App\Livewire\Revolut\Stock;

use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Livewire\Forms\UploadForm;
use App\Imports\Stock\TransactionsImport;

class Upload extends UploadForm
{
    public function render()
    {
        return view('livewire.revolut.stock.upload')->layout('layouts.app');
    }

    public function uploadCsv()
    {
        $this->validate();
        $filePath = $this->file->store('uploads');

        if ($filePath) {
            Session::put('importStats', [
                'total'    => 0,
                'inserted' => 0,
                'skipped'  => 0,
            ]);

            Excel::import(new TransactionsImport, $this->file->getRealPath());

            $importStats = Session::get('importStats');
            $msg = ' Stats: ' . implode(', ', array_map(
                    fn($key, $value) => "$key: $value",
                    array_keys($importStats),
                    $importStats
                ));
            $this->reset('file');
            $this->isUploaded = true;

            session()->flash('message', 'File uploaded successfully.' . $msg);
        } else {
            session()->flash('error', 'Failed to upload file.');
        }
    }
}
