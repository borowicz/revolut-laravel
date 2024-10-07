<?php

namespace App\Livewire\Revolut\Stock;

use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Livewire\Forms\UploadForm;
use App\Imports\Stock\TransactionsImport;

class Upload extends UploadForm
{
    public function uploadCsv()
    {
        $this->validate();
        // Store the file in the 'uploads' directory
        $filePath = $this->file->store('uploads');

        if (!empty($filePath)) {
            $importStats = [
                'total'    => 0,
                'inserted' => 0,
                'skipped'  => 0,
            ];
            Session::put('importStats', $importStats);

            // Process the CSV
            $result = Excel::import(new TransactionsImport, $this->file->getRealPath());

            $importStats = Session::get('importStats');
            $msg = ' Stats:';
            foreach ($importStats as $key => $value) {
                $msg .= $key . ': ' . $value . ', ';
            }
            $this->reset('file');
            $this->isUploaded = true;

            session()->flash('message', 'File uploaded successfully. ' . $msg);
        } else {
            session()->flash('error', 'Failed to upload file.');
        }
    }
}
