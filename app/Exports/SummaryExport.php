<?php
// app/Exports/SummaryExport.php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SummaryExport implements FromArray, WithHeadings, WithStyles, WithTitle
{
    protected $families;
    protected $filters;

    public function __construct($families, $filters = [])
    {
        $this->families = $families;
        $this->filters = $filters;
    }

    public function array(): array
    {
        $total = $this->families->count();
        $verified = $this->families->where('status_verifikasi', 'verified')->count();
        $submitted = $this->families->where('status_verifikasi', 'submitted')->count();
        $draft = $this->families->where('status_verifikasi', 'draft')->count();
        $rejected = $this->families->where('status_verifikasi', 'rejected')->count();

        $sangat_miskin = $this->families->where('poverty_level', 'Sangat Miskin')->count();
        $miskin = $this->families->where('poverty_level', 'Miskin')->count();
        $rentan_miskin = $this->families->where('poverty_level', 'Rentan Miskin')->count();
        $tidak_miskin = $this->families->where('poverty_level', 'Tidak Miskin')->count();

        return [
            ['RINGKASAN LAPORAN SURVEI KEMISKINAN'],
            ['Digenerate pada:', date('d/m/Y H:i:s')],
            [''],
            ['FILTER YANG DITERAPKAN:'],
            ['Desa:', $this->filters['village'] ?? 'Semua Desa'],
            ['Status:', $this->filters['status'] ?? 'Semua Status'],
            ['Kategori Kemiskinan:', $this->filters['poverty_level'] ?? 'Semua Kategori'],
            ['Surveyor:', $this->filters['surveyor'] ?? 'Semua Surveyor'],
            ['Periode:', ($this->filters['date_from'] ?? 'Awal') . ' - ' . ($this->filters['date_to'] ?? 'Akhir')],
            [''],
            ['STATISTIK UMUM:'],
            ['Total Survei:', $total],
            ['Terverifikasi:', $verified, ($total > 0 ? round(($verified/$total)*100, 1) : 0) . '%'],
            ['Menunggu Verifikasi:', $submitted, ($total > 0 ? round(($submitted/$total)*100, 1) : 0) . '%'],
            ['Draft:', $draft, ($total > 0 ? round(($draft/$total)*100, 1) : 0) . '%'],
            ['Ditolak:', $rejected, ($total > 0 ? round(($rejected/$total)*100, 1) : 0) . '%'],
            [''],
            ['DISTRIBUSI KEMISKINAN:'],
            ['Sangat Miskin:', $sangat_miskin, ($total > 0 ? round(($sangat_miskin/$total)*100, 1) : 0) . '%'],
            ['Miskin:', $miskin, ($total > 0 ? round(($miskin/$total)*100, 1) : 0) . '%'],
            ['Rentan Miskin:', $rentan_miskin, ($total > 0 ? round(($rentan_miskin/$total)*100, 1) : 0) . '%'],
            ['Tidak Miskin:', $tidak_miskin, ($total > 0 ? round(($tidak_miskin/$total)*100, 1) : 0) . '%'],
        ];
    }

    public function headings(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            4 => ['font' => ['bold' => true]],
            11 => ['font' => ['bold' => true]],
            18 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Ringkasan';
    }
}
