<?php

namespace App\Livewire\Keywords;

use App\Models\Batche;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Keywords extends Component
{
    use WithFileUploads;

    public $file;
    public $data = [];
    public $inputAdd;

    public function addKeyword() {
        if (!empty(trim($this->inputAdd)) ) {
            $this->data[] = $this->inputAdd;
            $this->inputAdd = '';
        }
    }

    
    public function batch()
    {
        return $this->belongsTo(Batche::class);
    }

    public function readExcel()
    {
        if (!$this->file) {
            return;
        }

        $path = $this->file->getRealPath();
        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getRowIterator() as $row) {
            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = $cell->getValue();
            }
            $this->data[] = implode(' ', $rowData);
        }
    }

    public function render()
    {
        return view('livewire.keywords.keywords');
    }
}
