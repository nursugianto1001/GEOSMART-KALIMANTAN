{{-- resources/views/admin/surveys/map.blade.php --}}
<x-layouts.admin>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-900 leading-tight">
            Peta Sebaran Survei Kemiskinan - Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12 bg-gradient-to-b from-blue-100 via-blue-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-blue-100">
                <div class="p-4 sm:p-6">
                    <!-- Map Controls -->
                    <div class="mb-6 bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg border border-blue-200">
                        <h3 class="text-lg font-medium text-blue-800 mb-4">Kontrol Peta</h3>
                        <div class="flex flex-wrap gap-4 items-center">
                            <div class="flex items-center">
                                <input type="checkbox" id="show-all-surveys" checked class="mr-2 rounded border-blue-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <label for="show-all-surveys" class="text-sm font-medium text-blue-700">Semua Survei</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="show-public-facilities" class="mr-2 rounded border-blue-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <label for="show-public-facilities" class="text-sm font-medium text-blue-700">Fasilitas Umum</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="show-main-roads" class="mr-2 rounded border-blue-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <label for="show-main-roads" class="text-sm font-medium text-blue-700">Jalan Utama</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="show-village-boundaries" class="mr-2 rounded border-blue-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <label for="show-village-boundaries" class="text-sm font-medium text-blue-700">Batas Desa</label>
                            </div>
                            
                            <!-- Filter by Status -->
                            <div class="flex items-center ml-4">
                                <label for="status-filter" class="text-sm font-medium text-blue-700 mr-2">Filter Status:</label>
                                <select id="status-filter" class="border-blue-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                    <option value="">Semua Status</option>
                                    <option value="draft">Draft</option>
                                    <option value="submitted">Menunggu Verifikasi</option>
                                    <option value="verified">Terverifikasi</option>
                                    <option value="rejected">Ditolak</option>
                                </select>
                            </div>

                            <!-- Filter by Village -->
                            <div class="flex items-center">
                                <label for="village-filter" class="text-sm font-medium text-blue-700 mr-2">Filter Desa:</label>
                                <select id="village-filter" class="border-blue-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                    <option value="">Semua Desa</option>
                                    @foreach($villages as $village)
                                        <option value="{{ $village->id }}">{{ $village->name }} ({{ $village->total_poor_families }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Map Container -->
                    <div id="map" style="height: 600px; width: 100%;" class="rounded-lg border border-blue-300 shadow-md"></div>

                    <!-- Legend -->
                    <div class="mt-6 p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border border-blue-200">
                        <h4 class="font-medium text-blue-900 mb-3">Keterangan:</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                            <!-- Poverty Levels -->
                            <div>
                                <h5 class="font-medium text-blue-800 mb-2">Tingkat Kemiskinan:</h5>
                                <div class="space-y-1">
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 bg-red-500 rounded-full mr-2"></div>
                                        <span class="text-blue-700">Sangat Miskin (≥20)</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 bg-orange-500 rounded-full mr-2"></div>
                                        <span class="text-blue-700">Miskin (15-19)</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 bg-yellow-500 rounded-full mr-2"></div>
                                        <span class="text-blue-700">Rentan Miskin (10-14)</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 bg-green-500 rounded-full mr-2"></div>
                                        <span class="text-blue-700">Tidak Miskin (<10)</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Survey Status -->
                            <div>
                                <h5 class="font-medium text-blue-800 mb-2">Status Survei:</h5>
                                <div class="space-y-1">
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 border-2 border-gray-500 rounded-full mr-2"></div>
                                        <span class="text-blue-700">Draft</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 border-2 border-yellow-500 rounded-full mr-2"></div>
                                        <span class="text-blue-700">Menunggu Verifikasi</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 border-2 border-green-500 rounded-full mr-2 bg-green-500"></div>
                                        <span class="text-blue-700">Terverifikasi</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 border-2 border-red-500 rounded-full mr-2"></div>
                                        <span class="text-blue-700">Ditolak</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Facilities -->
                            <div>
                                <h5 class="font-medium text-blue-800 mb-2">Fasilitas Umum:</h5>
                                <div class="space-y-1">
                                    <div class="flex items-center">
                                        <span class="w-4 h-4 mr-2 text-center">🏫</span>
                                        <span class="text-blue-700">Sekolah</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-4 h-4 mr-2 text-center">🏥</span>
                                        <span class="text-blue-700">Puskesmas/RS</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-4 h-4 mr-2 text-center">🏢</span>
                                        <span class="text-blue-700">Kantor Desa</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-4 h-4 mr-2 text-center">🕌</span>
                                        <span class="text-blue-700">Tempat Ibadah</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Roads -->
                            <div>
                                <h5 class="font-medium text-blue-800 mb-2">Kondisi Jalan:</h5>
                                <div class="space-y-1">
                                    <div class="flex items-center">
                                        <div class="w-4 h-1 bg-green-500 mr-2"></div>
                                        <span class="text-blue-700">Baik</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-1 bg-yellow-500 mr-2"></div>
                                        <span class="text-blue-700">Sedang</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-1 bg-red-500 mr-2"></div>
                                        <span class="text-blue-700">Rusak</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="mt-6 grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-blue-200 shadow-md">
                            <div class="text-2xl font-bold text-blue-600" id="total-surveys">{{ $allSurveys->count() }}</div>
                            <div class="text-sm text-blue-700">Total Survei</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-blue-200 shadow-md">
                            <div class="text-2xl font-bold text-red-600" id="sangat-miskin-count">{{ $allSurveys->where('poverty_level', 'Sangat Miskin')->count() }}</div>
                            <div class="text-sm text-blue-700">Sangat Miskin</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-blue-200 shadow-md">
                            <div class="text-2xl font-bold text-orange-600" id="miskin-count">{{ $allSurveys->where('poverty_level', 'Miskin')->count() }}</div>
                            <div class="text-sm text-blue-700">Miskin</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-blue-200 shadow-md">
                            <div class="text-2xl font-bold text-yellow-600" id="rentan-miskin-count">{{ $allSurveys->where('poverty_level', 'Rentan Miskin')->count() }}</div>
                            <div class="text-sm text-blue-700">Rentan Miskin</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-blue-200 shadow-md">
                            <div class="text-2xl font-bold text-green-600" id="verified-count">{{ $allSurveys->where('status_verifikasi', 'verified')->count() }}</div>
                            <div class="text-sm text-blue-700">Terverifikasi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
      crossorigin=""/>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
<script>
    // ✅ PERBAIKAN: Initialize map di Kalimantan Barat
    const map = L.map('map').setView([-0.0263, 109.3425], 9);

    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Force map to recalculate size
    setTimeout(function() {
        map.invalidateSize();
    }, 100);

    // Layer groups
    const surveysLayer = L.layerGroup().addTo(map);
    const facilitiesLayer = L.layerGroup();
    const roadsLayer = L.layerGroup();
    const villagesLayer = L.layerGroup();

    // ✅ PERBAIKAN: Survey data dengan syntax yang benar
    const allSurveys = {!! json_encode($allSurveys->map(function($survey) {
        return [
            'id' => $survey->id,
            'name' => $survey->nama_kepala_keluarga,
            'latitude' => (float) $survey->latitude,
            'longitude' => (float) $survey->longitude,
            'address' => $survey->alamat_lengkap,
            'village' => $survey->neighborhood->village->name ?? 'N/A',
            'district' => $survey->neighborhood->village->district->name ?? 'N/A',
            'regency' => $survey->neighborhood->village->district->regency->name ?? 'N/A',
            'province' => $survey->neighborhood->village->district->regency->province->name ?? 'N/A',
            'village_id' => $survey->neighborhood->village->id ?? null,
            'poverty_level' => $survey->poverty_level ?? 'Tidak Diketahui',
            'poverty_score' => $survey->poverty_score ?? 0,
            'members' => $survey->jumlah_anggota_keluarga,
            'status' => $survey->status_verifikasi,
            'created_at' => $survey->created_at->format('d/m/Y'),
            'economic_status' => $survey->sumber_penghasilan ?? 'N/A',
            'house_condition' => $survey->jenis_bangunan ?? 'N/A',
            'surveyor' => $survey->surveyor->name ?? 'N/A'
        ];
    })) !!};

    // ✅ PERBAIKAN: Public facilities data dengan properti yang benar
    const publicFacilities = {!! json_encode($publicFacilities->map(function($facility) {
        return [
            'id' => $facility->id,
            'name' => $facility->name,
            'type' => $facility->type,
            'latitude' => (float) $facility->latitude,
            'longitude' => (float) $facility->longitude,
            'village' => $facility->village->name ?? 'N/A',
            'kondisi' => $facility->kondisi ?? 'N/A',
            'alamat' => $facility->alamat ?? ''
        ];
    })) !!};

    // ✅ PERBAIKAN: Main roads data dengan properti sesuai migration
    const mainRoads = {!! json_encode($mainRoads->map(function($road) {
        return [
            'id' => $road->id,
            'name' => $road->name,
            'kondisi_jalan' => $road->kondisi_jalan ?? 'N/A',
            'jenis_jalan' => $road->jenis_jalan ?? 'N/A',
            'coordinates' => $road->coordinates ?? null,
            'village' => $road->village->name ?? 'N/A',
            'lebar_jalan' => $road->lebar_jalan ?? 0
        ];
    })) !!};

    // Village data
    const villages = {!! json_encode($villages->map(function($village) {
        return [
            'id' => $village->id,
            'name' => $village->name,
            'total_poor_families' => $village->total_poor_families ?? 0
        ];
    })) !!};

    let currentSurveys = allSurveys || [];

    // ✅ Debug console
    console.log('Map initialized at Kalimantan Barat');
    console.log('Surveys data:', allSurveys);
    console.log('Public facilities:', publicFacilities);
    console.log('Main roads:', mainRoads);

    // Load surveys on map
    function loadSurveys(surveys = currentSurveys) {
        surveysLayer.clearLayers();
        
        if (!Array.isArray(surveys)) {
            console.error('Surveys is not an array:', surveys);
            return;
        }
        
        surveys.forEach(survey => {
            if (!survey.latitude || !survey.longitude) {
                console.warn('Survey missing coordinates:', survey);
                return;
            }
            
            const povertyColor = getPovertyColor(survey.poverty_level);
            const statusStyle = getStatusStyle(survey.status);
            
            const marker = L.circleMarker([survey.latitude, survey.longitude], {
                color: statusStyle.color,
                fillColor: povertyColor,
                fillOpacity: statusStyle.fillOpacity,
                radius: 8,
                weight: statusStyle.weight
            });

            const popupContent = `
                <div class="p-3 min-w-64">
                    <h4 class="font-bold text-blue-900 mb-2">${survey.name}</h4>
                    <div class="space-y-1 text-sm">
                        <div><strong class="text-blue-700">Alamat:</strong> <span class="text-blue-900">${survey.address}</span></div>
                        <div><strong class="text-blue-700">Desa:</strong> <span class="text-blue-900">${survey.village}</span></div>
                        <div><strong class="text-blue-700">Kecamatan:</strong> <span class="text-blue-900">${survey.district}</span></div>
                        <div><strong class="text-blue-700">Kabupaten:</strong> <span class="text-blue-900">${survey.regency}</span></div>
                        <div><strong class="text-blue-700">Anggota:</strong> <span class="text-blue-900">${survey.members} orang</span></div>
                        <div><strong class="text-blue-700">Penghasilan:</strong> <span class="text-blue-900">${survey.economic_status.replace(/_/g, ' ')}</span></div>
                        <div><strong class="text-blue-700">Kondisi Rumah:</strong> <span class="text-blue-900">${survey.house_condition.replace(/_/g, ' ')}</span></div>
                        <div><strong class="text-blue-700">Surveyor:</strong> <span class="text-blue-900">${survey.surveyor}</span></div>
                        <div><strong class="text-blue-700">Status:</strong> 
                            <span class="px-2 py-1 text-xs font-semibold rounded-full ${getStatusBadgeClass(survey.status)}">
                                ${survey.status}
                            </span>
                        </div>
                        <div><strong class="text-blue-700">Kategori:</strong> 
                            <span class="px-2 py-1 text-xs font-semibold rounded-full ${getPovertyBadgeClass(survey.poverty_level)}">
                                ${survey.poverty_level}
                            </span>
                        </div>
                        <div><strong class="text-blue-700">Skor:</strong> <span class="text-blue-900">${survey.poverty_score}/25</span></div>
                        <div><strong class="text-blue-700">Tanggal:</strong> <span class="text-blue-900">${survey.created_at}</span></div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-blue-200">
                        <a href="/admin/surveys/${survey.id}/detail" 
                           style="display: block; width: 100%; background: linear-gradient(to right, #2563eb, #1d4ed8); color: #ffffff !important; text-align: center; padding: 8px 12px; border-radius: 6px; font-size: 14px; font-weight: 500; text-decoration: none; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
                           onmouseover="this.style.background='linear-gradient(to right, #1d4ed8, #1e40af)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.15)'"
                           onmouseout="this.style.background='linear-gradient(to right, #2563eb, #1d4ed8)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            `;
            
            marker.bindPopup(popupContent);
            surveysLayer.addLayer(marker);
        });

        updateStatistics(surveys);
    }

    // ✅ PERBAIKAN: Load public facilities
    function loadPublicFacilities() {
        facilitiesLayer.clearLayers();
        
        if (!Array.isArray(publicFacilities)) {
            console.warn('Public facilities data not available');
            return;
        }
        
        publicFacilities.forEach(facility => {
            if (!facility.latitude || !facility.longitude) {
                console.warn('Facility missing coordinates:', facility);
                return;
            }
            
            const marker = L.marker([facility.latitude, facility.longitude], {
                icon: L.divIcon({
                    className: 'facility-marker',
                    html: getFacilityIcon(facility.type),
                    iconSize: [30, 30],
                    iconAnchor: [15, 15]
                })
            });

            const popupContent = `
                <div class="p-3">
                    <h4 class="font-bold text-blue-900 mb-2">${facility.name}</h4>
                    <div class="space-y-1 text-sm">
                        <div><strong class="text-blue-700">Jenis:</strong> <span class="text-blue-900">${facility.type.replace(/_/g, ' ')}</span></div>
                        <div><strong class="text-blue-700">Desa:</strong> <span class="text-blue-900">${facility.village}</span></div>
                        <div><strong class="text-blue-700">Kondisi:</strong> 
                            <span class="px-2 py-1 text-xs font-semibold rounded-full ${facility.kondisi === 'baik' ? 'bg-green-100 text-green-800' : facility.kondisi === 'sedang' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}">
                                ${facility.kondisi}
                            </span>
                        </div>
                        ${facility.alamat ? `<div><strong class="text-blue-700">Alamat:</strong> <span class="text-blue-900">${facility.alamat}</span></div>` : ''}
                    </div>
                </div>
            `;
            
            marker.bindPopup(popupContent);
            facilitiesLayer.addLayer(marker);
        });
    }

    // ✅ PERBAIKAN: Load main roads dengan coordinates
    function loadMainRoads() {
        roadsLayer.clearLayers();
        
        if (!Array.isArray(mainRoads)) {
            console.warn('Main roads data not available');
            return;
        }
        
        mainRoads.forEach(road => {
            if (!road.coordinates) {
                console.warn('Road missing coordinates:', road);
                return;
            }
            
            try {
                const coordinates = typeof road.coordinates === 'string' 
                    ? JSON.parse(road.coordinates) 
                    : road.coordinates;
                
                if (!Array.isArray(coordinates) || coordinates.length < 2) {
                    console.warn('Invalid road coordinates:', road);
                    return;
                }
                
                const polyline = L.polyline(coordinates, {
                    color: getRoadColor(road.kondisi_jalan),
                    weight: 4,
                    opacity: 0.8
                });

                const popupContent = `
                    <div class="p-3">
                        <h4 class="font-bold text-blue-900 mb-2">${road.name}</h4>
                        <div class="space-y-1 text-sm">
                            <div><strong class="text-blue-700">Jenis:</strong> <span class="text-blue-900">${road.jenis_jalan.replace(/_/g, ' ')}</span></div>
                            <div><strong class="text-blue-700">Kondisi:</strong> 
                                <span class="px-2 py-1 text-xs font-semibold rounded-full ${road.kondisi_jalan === 'baik' ? 'bg-green-100 text-green-800' : road.kondisi_jalan === 'sedang' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}">
                                    ${road.kondisi_jalan}
                                </span>
                            </div>
                            <div><strong class="text-blue-700">Desa:</strong> <span class="text-blue-900">${road.village}</span></div>
                            ${road.lebar_jalan ? `<div><strong class="text-blue-700">Lebar:</strong> <span class="text-blue-900">${road.lebar_jalan}m</span></div>` : ''}
                        </div>
                    </div>
                `;
                
                polyline.bindPopup(popupContent);
                roadsLayer.addLayer(polyline);
            } catch (error) {
                console.error('Error processing road coordinates:', error, road);
            }
        });
    }

    // Load village boundaries
    function loadVillageBoundaries() {
        villagesLayer.clearLayers();
        
        villages.forEach((village, index) => {
            const villageSurveys = allSurveys.filter(s => s.village_id === village.id);
            
            if (villageSurveys.length > 0) {
                const centerLat = villageSurveys.reduce((sum, s) => sum + s.latitude, 0) / villageSurveys.length;
                const centerLng = villageSurveys.reduce((sum, s) => sum + s.longitude, 0) / villageSurveys.length;
                
                const marker = L.marker([centerLat, centerLng], {
                    icon: L.divIcon({
                        className: 'village-marker',
                        html: `<div style="background: linear-gradient(to right, #2563eb, #1d4ed8); color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">${village.name}</div>`,
                        iconSize: [120, 30],
                        iconAnchor: [60, 15]
                    })
                });

                const popupContent = `
                    <div class="p-3">
                        <h4 class="font-bold text-blue-900 mb-2">${village.name}</h4>
                        <div class="text-sm">
                            <div><strong class="text-blue-700">Total Keluarga Miskin Terverifikasi:</strong> <span class="text-blue-900">${village.total_poor_families}</span></div>
                        </div>
                    </div>
                `;
                
                marker.bindPopup(popupContent);
                villagesLayer.addLayer(marker);
            }
        });
    }

    // Helper functions
    function getPovertyColor(level) {
        switch(level) {
            case 'Sangat Miskin': return '#EF4444';
            case 'Miskin': return '#F97316';
            case 'Rentan Miskin': return '#EAB308';
            case 'Tidak Miskin': return '#22C55E';
            default: return '#6B7280';
        }
    }

    function getStatusStyle(status) {
        switch(status) {
            case 'draft': 
                return { color: '#6B7280', weight: 2, fillOpacity: 0.5 };
            case 'submitted': 
                return { color: '#F59E0B', weight: 3, fillOpacity: 0.6 };
            case 'verified': 
                return { color: '#10B981', weight: 2, fillOpacity: 0.8 };
            case 'rejected': 
                return { color: '#EF4444', weight: 3, fillOpacity: 0.4 };
            default: 
                return { color: '#6B7280', weight: 2, fillOpacity: 0.5 };
        }
    }

    function getPovertyBadgeClass(level) {
        switch(level) {
            case 'Sangat Miskin': return 'bg-red-100 text-red-800';
            case 'Miskin': return 'bg-orange-100 text-orange-800';
            case 'Rentan Miskin': return 'bg-yellow-100 text-yellow-800';
            case 'Tidak Miskin': return 'bg-green-100 text-green-800';
            default: return 'bg-gray-100 text-gray-800';
        }
    }

    function getStatusBadgeClass(status) {
        switch(status) {
            case 'draft': return 'bg-gray-100 text-gray-800';
            case 'submitted': return 'bg-yellow-100 text-yellow-800';
            case 'verified': return 'bg-green-100 text-green-800';
            case 'rejected': return 'bg-red-100 text-red-800';
            default: return 'bg-gray-100 text-gray-800';
        }
    }

    function getFacilityIcon(type) {
        const icons = {
            'sekolah': '🏫',
            'puskesmas': '🏥',
            'rumah_sakit': '🏥',
            'kantor_desa': '🏢',
            'pasar': '🏪',
            'masjid': '🕌',
            'gereja': '⛪',
            'lainnya': '📍'
        };
        return `<div style="background: white; border-radius: 50%; padding: 4px; font-size: 18px; border: 2px solid #2563eb; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">${icons[type] || icons['lainnya']}</div>`;
    }

    function getRoadColor(kondisi) {
        switch(kondisi) {
            case 'baik': return '#10B981';
            case 'sedang': return '#F59E0B';
            case 'rusak': return '#EF4444';
            default: return '#6B7280';
        }
    }

    function updateStatistics(surveys) {
        if (!Array.isArray(surveys)) return;
        
        const totalElement = document.getElementById('total-surveys');
        const sangat = document.getElementById('sangat-miskin-count');
        const miskin = document.getElementById('miskin-count');
        const rentan = document.getElementById('rentan-miskin-count');
        const verified = document.getElementById('verified-count');
        
        if (totalElement) totalElement.textContent = surveys.length;
        if (sangat) sangat.textContent = surveys.filter(s => s.poverty_level === 'Sangat Miskin').length;
        if (miskin) miskin.textContent = surveys.filter(s => s.poverty_level === 'Miskin').length;
        if (rentan) rentan.textContent = surveys.filter(s => s.poverty_level === 'Rentan Miskin').length;
        if (verified) verified.textContent = surveys.filter(s => s.status === 'verified').length;
    }

    // Event listeners for toggles
    const showSurveys = document.getElementById('show-all-surveys');
    if (showSurveys) {
        showSurveys.addEventListener('change', function() {
            if (this.checked) {
                map.addLayer(surveysLayer);
            } else {
                map.removeLayer(surveysLayer);
            }
        });
    }

    const showFacilities = document.getElementById('show-public-facilities');
    if (showFacilities) {
        showFacilities.addEventListener('change', function() {
            if (this.checked) {
                map.addLayer(facilitiesLayer);
                loadPublicFacilities();
            } else {
                map.removeLayer(facilitiesLayer);
            }
        });
    }

    const showRoads = document.getElementById('show-main-roads');
    if (showRoads) {
        showRoads.addEventListener('change', function() {
            if (this.checked) {
                map.addLayer(roadsLayer);
                loadMainRoads();
            } else {
                map.removeLayer(roadsLayer);
            }
        });
    }

    const showVillages = document.getElementById('show-village-boundaries');
    if (showVillages) {
        showVillages.addEventListener('change', function() {
            if (this.checked) {
                map.addLayer(villagesLayer);
                loadVillageBoundaries();
            } else {
                map.removeLayer(villagesLayer);
                villagesLayer.clearLayers();
            }
        });
    }

    // Status filter
    const statusFilter = document.getElementById('status-filter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value;
            const selectedVillage = document.getElementById('village-filter').value;
            filterSurveys(selectedStatus, selectedVillage);
        });
    }

    // Village filter
    const villageFilter = document.getElementById('village-filter');
    if (villageFilter) {
        villageFilter.addEventListener('change', function() {
            const selectedVillage = this.value;
            const selectedStatus = document.getElementById('status-filter').value;
            filterSurveys(selectedStatus, selectedVillage);
        });
    }

    // Filter function
    function filterSurveys(status = '', village = '') {
        let filteredSurveys = allSurveys;
        
        if (status !== '') {
            filteredSurveys = filteredSurveys.filter(survey => survey.status === status);
        }
        
        if (village !== '') {
            filteredSurveys = filteredSurveys.filter(survey => survey.village_id == village);
        }
        
        currentSurveys = filteredSurveys;
        loadSurveys(currentSurveys);
    }

    // Export data functionality
    function exportCurrentData() {
        const csvContent = generateCSV(currentSurveys);
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', `survey_data_${new Date().toISOString().split('T')[0]}.csv`);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function generateCSV(surveys) {
        const headers = [
            'ID', 'Nama Kepala Keluarga', 'Alamat', 'Desa', 'Kecamatan', 'Kabupaten', 'Provinsi',
            'Latitude', 'Longitude', 'Jumlah Anggota', 'Sumber Penghasilan', 'Kondisi Rumah',
            'Status', 'Kategori Kemiskinan', 'Skor Kemiskinan', 'Surveyor', 'Tanggal Survei'
        ];
        
        let csvContent = headers.join(',') + '\n';
        
        surveys.forEach(survey => {
            const row = [
                survey.id,
                `"${survey.name}"`,
                `"${survey.address}"`,
                `"${survey.village}"`,
                `"${survey.district}"`,
                `"${survey.regency}"`,
                `"${survey.province}"`,
                survey.latitude,
                survey.longitude,
                survey.members,
                `"${survey.economic_status}"`,
                `"${survey.house_condition}"`,
                `"${survey.status}"`,
                `"${survey.poverty_level}"`,
                survey.poverty_score,
                `"${survey.surveyor}"`,
                `"${survey.created_at}"`
            ];
            csvContent += row.join(',') + '\n';
        });
        
        return csvContent;
    }

    // Initial load
    loadSurveys();

    // Center map on all surveys if available
    if (allSurveys && allSurveys.length > 0) {
        setTimeout(() => {
            const group = new L.featureGroup(surveysLayer.getLayers());
            if (group.getLayers().length > 0) {
                map.fitBounds(group.getBounds().pad(0.1));
            }
        }, 500);
    }

    // Add scale control
    L.control.scale().addTo(map);

    // Add fullscreen control
    const fullscreenControl = L.Control.extend({
        onAdd: function(map) {
            const container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
            container.style.backgroundColor = 'white';
            container.style.width = '30px';
            container.style.height = '30px';
            container.style.cursor = 'pointer';
            container.innerHTML = '⛶';
            container.style.fontSize = '18px';
            container.style.textAlign = 'center';
            container.style.lineHeight = '30px';
            container.title = 'Fullscreen';
            
            container.onclick = function() {
                const mapContainer = document.getElementById('map');
                if (mapContainer.requestFullscreen) {
                    mapContainer.requestFullscreen();
                } else if (mapContainer.webkitRequestFullscreen) {
                    mapContainer.webkitRequestFullscreen();
                } else if (mapContainer.msRequestFullscreen) {
                    mapContainer.msRequestFullscreen();
                }
                
                setTimeout(() => {
                    map.invalidateSize();
                }, 100);
            };
            
            return container;
        }
    });

    map.addControl(new fullscreenControl({position: 'topright'}));

    // Export control
    const exportControl = L.Control.extend({
        onAdd: function(map) {
            const container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
            container.style.backgroundColor = 'white';
            container.style.width = '30px';
            container.style.height = '30px';
            container.style.cursor = 'pointer';
            container.innerHTML = '📊';
            container.style.fontSize = '18px';
            container.style.textAlign = 'center';
            container.style.lineHeight = '30px';
            container.title = 'Export Data';
            
            container.onclick = function() {
                exportCurrentData();
            };
            
            return container;
        }
    });

    map.addControl(new exportControl({position: 'topright'}));

    // Print control
    const printControl = L.Control.extend({
        onAdd: function(map) {
            const container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
            container.style.backgroundColor = 'white';
            container.style.width = '30px';
            container.style.height = '30px';
            container.style.cursor = 'pointer';
            container.innerHTML = '🖨';
            container.style.fontSize = '18px';
            container.style.textAlign = 'center';
            container.style.lineHeight = '30px';
            container.title = 'Print Map';
            
            container.onclick = function() {
                window.print();
            };
            
            return container;
        }
    });

    map.addControl(new printControl({position: 'topright'}));

    // Add print styles
    const printStyles = document.createElement('style');
    printStyles.textContent = `
        @media print {
            .leaflet-control-container {
                display: none !important;
            }
            #map {
                height: 80vh !important;
                width: 100% !important;
            }
            .no-print {
                display: none !important;
            }
        }
    `;
    document.head.appendChild(printStyles);
</script>
@endpush

</x-layouts.admin>