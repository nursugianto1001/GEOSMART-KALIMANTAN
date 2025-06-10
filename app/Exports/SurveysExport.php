<?php
// app/Exports/SurveysExport.php

namespace App\Exports;

use App\Models\PoorFamily;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SurveysExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle
{
    protected $families;
    protected $filters;

    public function __construct($families, $filters = [])
    {
        $this->families = $families;
        $this->filters = $filters;
    }

    public function collection()
    {
        return $this->families;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Kepala Keluarga',
            'NIK',
            'Jenis Kelamin KK',
            'Jumlah Anggota Keluarga',
            'Status Keluarga',
            'Alamat Lengkap',
            'RT/RW',
            'Desa',
            'Kecamatan',
            'Koordinat (Lat, Long)',
            'Tipe Tempat Tinggal',
            'Sumber Penghasilan',
            'Penghasilan Bulanan',
            'Status Kepemilikan',
            'Aset Utama',
            'Jenis Bangunan',
            'Luas Rumah (m²)',
            'Lantai Rumah',
            'Dinding Rumah',
            'Atap Rumah',
            'Sumber Air',
            'Sumber Listrik',
            'Akses Sekolah',
            'Akses Kesehatan',
            'Akses Jalan',
            'Anak Tidak Sekolah',
            'Ada Difabel/Lansia',
            'Ada Sakit Menahun',
            'Bantuan Pemerintah',
            'Skor Kemiskinan',
            'Kategori Kemiskinan',
            'Status Verifikasi',
            'Surveyor',
            'Tanggal Survei',
            'Verifikator',
            'Tanggal Verifikasi',
            'Alasan Penolakan',
            'Catatan Tambahan'
        ];
    }

    public function map($family): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $family->nama_kepala_keluarga,
            $family->nik ?: '-',
            $family->jenis_kelamin_kk === 'L' ? 'Laki-laki' : 'Perempuan',
            $family->jumlah_anggota_keluarga,
            ucfirst(str_replace('_', ' ', $family->status_keluarga)),
            $family->alamat_lengkap,
            "RT {$family->neighborhood->rt}/RW {$family->neighborhood->rw}",
            $family->neighborhood->village->name,
            $family->neighborhood->village->district->name,
            "{$family->latitude}, {$family->longitude}",
            ucfirst(str_replace('_', ' ', $family->tipe_tempat_tinggal)),
            ucfirst(str_replace('_', ' ', $family->sumber_penghasilan)),
            $family->penghasilan_bulanan ? 'Rp ' . number_format($family->penghasilan_bulanan, 0, ',', '.') : '-',
            ucfirst(str_replace('_', ' ', $family->status_kepemilikan)),
            $family->aset_utama ? implode(', ', array_map(function($asset) {
                return ucfirst(str_replace('_', ' ', $asset));
            }, $family->aset_utama)) : '-',
            ucfirst(str_replace('_', ' ', $family->jenis_bangunan)),
            $family->luas_rumah ? $family->luas_rumah . ' m²' : '-',
            ucfirst($family->lantai_rumah),
            ucfirst(str_replace('_', ' ', $family->dinding_rumah)),
            ucfirst($family->atap_rumah),
            strtoupper($family->sumber_air),
            strtoupper(str_replace('_', ' ', $family->sumber_listrik)),
            str_replace('_', ' ', $family->akses_sekolah),
            strtoupper(str_replace('_', ' ', $family->akses_kesehatan)),
            str_replace('_', ' ', $family->akses_jalan),
            $family->anak_tidak_sekolah ? 'Ya' : 'Tidak',
            $family->ada_difabel_lansia ? 'Ya' : 'Tidak',
            $family->ada_sakit_menahun ? 'Ya' : 'Tidak',
            $family->bantuan_pemerintah ? implode(', ', array_map('strtoupper', $family->bantuan_pemerintah)) : '-',
            $family->poverty_score . '/25',
            $family->poverty_level,
            $family->status_text,
            $family->surveyor->name,
            $family->created_at->format('d/m/Y H:i'),
            $family->verifier ? $family->verifier->name : '-',
            $family->verified_at ? $family->verified_at->format('d/m/Y H:i') : '-',
            $family->rejection_reason ?: '-',
            $family->catatan_tambahan ?: '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header styling
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ],
            // Data rows styling
            'A2:AM' . ($this->families->count() + 1) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC']
                    ]
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_TOP,
                    'wrapText' => true
                ]
            ]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 20,  // Nama KK
            'C' => 18,  // NIK
            'D' => 12,  // Jenis Kelamin
            'E' => 10,  // Jumlah Anggota
            'F' => 15,  // Status Keluarga
            'G' => 30,  // Alamat
            'H' => 12,  // RT/RW
            'I' => 15,  // Desa
            'J' => 15,  // Kecamatan
            'K' => 20,  // Koordinat
            'L' => 15,  // Tipe Tempat Tinggal
            'M' => 15,  // Sumber Penghasilan
            'N' => 15,  // Penghasilan
            'O' => 15,  // Status Kepemilikan
            'P' => 20,  // Aset Utama
            'Q' => 15,  // Jenis Bangunan
            'R' => 10,  // Luas Rumah
            'S' => 12,  // Lantai
            'T' => 12,  // Dinding
            'U' => 12,  // Atap
            'V' => 12,  // Sumber Air
            'W' => 12,  // Sumber Listrik
            'X' => 12,  // Akses Sekolah
            'Y' => 12,  // Akses Kesehatan
            'Z' => 12,  // Akses Jalan
            'AA' => 10, // Anak Tidak Sekolah
            'AB' => 12, // Difabel/Lansia
            'AC' => 12, // Sakit Menahun
            'AD' => 20, // Bantuan Pemerintah
            'AE' => 12, // Skor Kemiskinan
            'AF' => 15, // Kategori Kemiskinan
            'AG' => 15, // Status Verifikasi
            'AH' => 15, // Surveyor
            'AI' => 15, // Tanggal Survei
            'AJ' => 15, // Verifikator
            'AK' => 15, // Tanggal Verifikasi
            'AL' => 25, // Alasan Penolakan
            'AM' => 25, // Catatan Tambahan
        ];
    }

    public function title(): string
    {
        return 'Data Survei Kemiskinan';
    }
}
