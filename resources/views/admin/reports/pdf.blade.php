{{-- resources/views/admin/reports/pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Laporan Data Survei Kemiskinan' }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm 10mm 15mm 10mm; /* top right bottom left */
        }
        
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
            color: #14532d; /* Green 900 untuk teks utama */
            line-height: 1.3;
            width: 190mm; /* A4 width minus margins */
            max-width: 190mm;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #16a34a; /* Green 600 */
            padding-bottom: 12px;
        }
        
        .header h1 {
            color: #14532d; /* Green 900 */
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 8px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .header p {
            color: #166534; /* Green 800 */
            font-size: 10px;
            margin: 3px 0;
        }
        
        .logo-section {
            margin-bottom: 10px;
        }
        
        .logo-section h2 {
            color: #15803d; /* Green 700 */
            font-size: 12px;
            margin: 0;
            font-weight: 600;
        }
        
        .filters {
            background-color: #f0fdf4; /* Green 50 */
            padding: 10px 12px;
            margin-bottom: 15px;
            border-radius: 6px;
            color: #166534; /* Green 800 */
            font-size: 9px;
            border: 1px solid #dcfce7; /* Green 100 */
        }
        
        .filters h3 {
            color: #15803d; /* Green 700 */
            font-size: 11px;
            margin: 0 0 6px 0;
            font-weight: 600;
        }
        
        .filters p {
            margin: 2px 0;
            line-height: 1.2;
        }
        
        .filters strong {
            color: #14532d; /* Green 900 */
            font-weight: 600;
        }
        
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 8px;
            margin-top: 15px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        
        th, td {
            border: 1px solid #bbf7d0; /* Green 200 */
            padding: 4px 3px;
            vertical-align: top;
        }
        
        th {
            background: linear-gradient(to bottom, #dcfce7, #bbf7d0); /* Green 100 to Green 200 */
            font-weight: 700;
            font-size: 7px;
            color: #14532d; /* Green 900 */
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            height: 25px;
        }
        
        th:first-child {
            border-top-left-radius: 4px;
        }
        
        th:last-child {
            border-top-right-radius: 4px;
        }
        
        td {
            background-color: #ffffff;
            color: #14532d; /* Green 900 */
            font-size: 8px;
            height: 20px;
        }
        
        tr:nth-child(even) td {
            background-color: #f9fafb; /* Gray 50 untuk zebra striping */
        }
        
        /* Status Colors - Smaller badges for A4 */
        .status-verified { 
            color: #22c55e; /* Green 500 */
            font-weight: 700; 
            background-color: #dcfce7; /* Green 100 */
            padding: 1px 3px;
            border-radius: 2px;
            font-size: 7px;
            display: inline-block;
        }
        
        .status-submitted { 
            color: #f59e0b; /* Yellow 500 */
            font-weight: 700; 
            background-color: #fef3c7; /* Yellow 100 */
            padding: 1px 3px;
            border-radius: 2px;
            font-size: 7px;
            display: inline-block;
        }
        
        .status-draft { 
            color: #6b7280; /* Gray 600 */
            font-weight: 700; 
            background-color: #f3f4f6; /* Gray 100 */
            padding: 1px 3px;
            border-radius: 2px;
            font-size: 7px;
            display: inline-block;
        }
        
        .status-rejected { 
            color: #ef4444; /* Red 500 */
            font-weight: 700; 
            background-color: #fee2e2; /* Red 100 */
            padding: 1px 3px;
            border-radius: 2px;
            font-size: 7px;
            display: inline-block;
        }
        
        /* Poverty Level Colors - Smaller badges for A4 */
        .poverty-sangat-miskin { 
            color: #ef4444; /* Red 500 */
            font-weight: 700; 
            background-color: #fee2e2; /* Red 100 */
            padding: 1px 3px;
            border-radius: 2px;
            font-size: 7px;
            display: inline-block;
        }
        
        .poverty-miskin { 
            color: #f97316; /* Orange 500 */
            font-weight: 700; 
            background-color: #fed7aa; /* Orange 100 */
            padding: 1px 3px;
            border-radius: 2px;
            font-size: 7px;
            display: inline-block;
        }
        
        .poverty-rentan-miskin { 
            color: #eab308; /* Yellow 500 */
            font-weight: 700; 
            background-color: #fef3c7; /* Yellow 100 */
            padding: 1px 3px;
            border-radius: 2px;
            font-size: 7px;
            display: inline-block;
        }
        
        .poverty-tidak-miskin { 
            color: #22c55e; /* Green 500 */
            font-weight: 700; 
            background-color: #dcfce7; /* Green 100 */
            padding: 1px 3px;
            border-radius: 2px;
            font-size: 7px;
            display: inline-block;
        }
        
        .poverty-tidak-diketahui { 
            color: #6b7280; /* Gray 600 */
            font-weight: 700; 
            background-color: #f3f4f6; /* Gray 100 */
            padding: 1px 3px;
            border-radius: 2px;
            font-size: 7px;
            display: inline-block;
        }
        
        .footer {
            margin-top: 20px;
            text-align: left;
            font-size: 8px;
            color: #4b5563; /* Gray 600 */
            border-top: 2px solid #bbf7d0; /* Green 200 */
            padding-top: 10px;
        }
        
        .footer .summary {
            background-color: #f0fdf4; /* Green 50 */
            padding: 8px 10px;
            border-radius: 4px;
            margin-bottom: 10px;
            border: 1px solid #dcfce7; /* Green 100 */
        }
        
        .footer .summary h4 {
            color: #15803d; /* Green 700 */
            font-size: 10px;
            margin: 0 0 5px 0;
            font-weight: 600;
        }
        
        .footer .summary p {
            margin: 2px 0;
            color: #166534; /* Green 800 */
            line-height: 1.2;
        }
        
        .footer .copyright {
            text-align: center;
            color: #6b7280; /* Gray 600 */
            font-size: 7px;
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px solid #dcfce7; /* Green 100 */
        }
        
        /* Alignment for specific columns */
        td:nth-child(1), /* No */
        td:nth-child(5), /* Anggota */
        td:nth-child(6), /* Skor */
        td:nth-child(10) /* Tanggal */
        {
            text-align: center;
        }
        
        /* Column widths optimized for A4 */
        .col-no { width: 4%; }
        .col-nama { width: 16%; }
        .col-alamat { width: 20%; }
        .col-desa { width: 12%; }
        .col-anggota { width: 6%; }
        .col-skor { width: 6%; }
        .col-kategori { width: 12%; }
        .col-status { width: 10%; }
        .col-surveyor { width: 10%; }
        .col-tanggal { width: 4%; }
        
        .no-data {
            text-align: center; 
            padding: 15px; 
            color: #6b7280; /* Gray 600 */
            font-style: italic;
            background-color: #f9fafb; /* Gray 50 */
        }
        
        /* Page break handling */
        .page-break {
            page-break-before: always;
        }
        
        /* Ensure content fits in A4 */
        .content-wrapper {
            max-width: 190mm;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <div class="header">
            <div class="logo-section">
                <h2>SISTEM PEMETAAN KEMISKINAN</h2>
            </div>
            <h1>{{ $title ?? 'Laporan Data Survei Kemiskinan' }}</h1>
            <p>Digenerate pada: {{ $generated_at ?? date('d/m/Y H:i:s') }}</p>
        </div>

        @if(isset($filters) && is_array($filters))
        <div class="filters">
            <h3>Filter yang Diterapkan:</h3>
            <p><strong>Desa:</strong> {{ $filters['village'] ?? 'Semua Desa' }}</p>
            <p><strong>Status:</strong> {{ $filters['status'] ?? 'Semua Status' }}</p>
            @if(isset($filters['poverty_level']))
                <p><strong>Kategori Kemiskinan:</strong> {{ $filters['poverty_level'] ?? 'Semua Kategori' }}</p>
            @endif
            @if(isset($filters['surveyor']))
                <p><strong>Surveyor:</strong> {{ $filters['surveyor'] ?? 'Semua Surveyor' }}</p>
            @endif
            @if((isset($filters['date_from']) && $filters['date_from']) || (isset($filters['date_to']) && $filters['date_to']))
                <p><strong>Periode:</strong> 
                    {{ isset($filters['date_from']) && $filters['date_from'] ? date('d/m/Y', strtotime($filters['date_from'])) : 'Awal' }} - 
                    {{ isset($filters['date_to']) && $filters['date_to'] ? date('d/m/Y', strtotime($filters['date_to'])) : 'Akhir' }}
                </p>
            @endif
        </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-nama">Nama KK</th>
                    <th class="col-alamat">Alamat</th>
                    <th class="col-desa">Desa</th>
                    <th class="col-anggota">Anggota</th>
                    <th class="col-skor">Skor</th>
                    <th class="col-kategori">Kategori</th>
                    <th class="col-status">Status</th>
                    <th class="col-surveyor">Surveyor</th>
                    <th class="col-tanggal">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $dataToLoop = $families ?? $surveys ?? [];
                    $totalCount = $total_count ?? (isset($families) ? $families->count() : (isset($surveys) ? $surveys->count() : 0));
                @endphp
                
                @forelse($dataToLoop as $index => $item)
                    @php
                        $survey = $item;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $survey->nama_kepala_keluarga ?? '-' }}</strong></td>
                        <td>{{ isset($survey->alamat_lengkap) ? Str::limit($survey->alamat_lengkap, 30) : '-' }}</td>
                        <td>{{ $survey->neighborhood->village->name ?? '-' }}</td>
                        <td>{{ $survey->jumlah_anggota_keluarga ?? '-' }}</td>
                        <td><strong>{{ ($survey->poverty_score ?? 0) }}/25</strong></td>
                        <td>
                            <span class="poverty-{{ strtolower(str_replace(' ', '-', $survey->poverty_level ?? 'tidak-diketahui')) }}">
                                {{ $survey->poverty_level ?? 'Tidak Diketahui' }}
                            </span>
                        </td>
                        <td>
                            <span class="status-{{ $survey->status_verifikasi ?? 'draft' }}">
                                {{ $survey->status_text ?? ucfirst($survey->status_verifikasi ?? 'Draft') }}
                            </span>
                        </td>
                        <td>{{ $survey->surveyor->name ?? '-' }}</td>
                        <td>
                            {{ isset($survey->created_at) ? $survey->created_at->format('d/m/Y') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="no-data">
                            Tidak ada data survei yang sesuai dengan filter yang diterapkan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            <div class="summary">
                <h4>Ringkasan Laporan</h4>
                <p><strong>Total Survei: {{ $totalCount }} data</strong></p>
                @if($totalCount > 0)
                    @php
                        $verified = collect($dataToLoop)->where('status_verifikasi', 'verified')->count();
                        $submitted = collect($dataToLoop)->where('status_verifikasi', 'submitted')->count();
                        $draft = collect($dataToLoop)->where('status_verifikasi', 'draft')->count();
                        $rejected = collect($dataToLoop)->where('status_verifikasi', 'rejected')->count();
                        
                        $sangatMiskin = collect($dataToLoop)->where('poverty_level', 'Sangat Miskin')->count();
                        $miskin = collect($dataToLoop)->where('poverty_level', 'Miskin')->count();
                        $rentanMiskin = collect($dataToLoop)->where('poverty_level', 'Rentan Miskin')->count();
                        $tidakMiskin = collect($dataToLoop)->where('poverty_level', 'Tidak Miskin')->count();
                    @endphp
                    <p><strong>Status Verifikasi:</strong> Terverifikasi: {{ $verified }}, Menunggu: {{ $submitted }}, Draft: {{ $draft }}, Ditolak: {{ $rejected }}</p>
                    <p><strong>Kategori Kemiskinan:</strong> Sangat Miskin: {{ $sangatMiskin }}, Miskin: {{ $miskin }}, Rentan Miskin: {{ $rentanMiskin }}, Tidak Miskin: {{ $tidakMiskin }}</p>
                @endif
            </div>
            
            <div class="copyright">
                <p>Laporan ini digenerate secara otomatis oleh Sistem Pemetaan Kemiskinan</p>
                <p>&copy; {{ date('Y') }} - Sistem Informasi Survei Kemiskinan</p>
            </div>
        </div>
    </div>
</body>
</html>
