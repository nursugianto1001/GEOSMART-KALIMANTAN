<?php
// app/Exports/DetailedSurveysExport.php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DetailedSurveysExport implements WithMultipleSheets
{
    protected $families;
    protected $filters;

    public function __construct($families, $filters = [])
    {
        $this->families = $families;
        $this->filters = $filters;
    }

    public function sheets(): array
    {
        return [
            'Data Survei' => new SurveysExport($this->families, $this->filters),
            'Ringkasan' => new SummaryExport($this->families, $this->filters),
        ];
    }
}
