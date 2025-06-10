{{-- resources/views/petugas/surveys/map.blade.php --}}
<x-layouts.petugas>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-900 leading-tight">
            Peta Sebaran Survei Kemiskinan
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12 bg-gradient-to-b from-green-100 via-green-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-green-100">
                <div class="p-4 sm:p-6">
                    <!-- Map Controls -->
                    <div class="mb-6 bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg border border-green-200">
                        <h3 class="text-lg font-medium text-green-800 mb-4">Kontrol Peta</h3>
                        <div class="flex flex-wrap gap-4 items-center">
                            <div class="flex items-center">
                                <input type="checkbox" id="show-my-surveys" checked class="mr-2 rounded border-green-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <label for="show-my-surveys" class="text-sm font-medium text-green-700">Survei Saya</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="show-public-facilities" class="mr-2 rounded border-green-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <label for="show-public-facilities" class="text-sm font-medium text-green-700">Fasilitas Umum</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="show-main-roads" class="mr-2 rounded border-green-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <label for="show-main-roads" class="text-sm font-medium text-green-700">Jalan Utama</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="show-work-area" class="mr-2 rounded border-green-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <label for="show-work-area" class="text-sm font-medium text-green-700">Wilayah Kerja</label>
                            </div>

                            <!-- Filter by Status -->
                            <div class="flex items-center ml-4">
                                <label for="status-filter" class="text-sm font-medium text-green-700 mr-2">Filter Status:</label>
                                <select id="status-filter" class="border-green-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 text-sm">
                                    <option value="">Semua Status</option>
                                    <option value="draft">Draft</option>
                                    <option value="submitted">Menunggu Verifikasi</option>
                                    <option value="verified">Terverifikasi</option>
                                    <option value="rejected">Ditolak</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Map Container -->
                    <div id="map" style="height: 600px; width: 100%;" class="rounded-lg border border-green-300 shadow-md"></div>

                    <!-- Legend -->
                    <div class="mt-6 p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-lg border border-green-200">
                        <h4 class="font-medium text-green-900 mb-3">Keterangan:</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                            <!-- Poverty Levels -->
                            <div>
                                <h5 class="font-medium text-green-800 mb-2">Tingkat Kemiskinan:</h5>
                                <div class="space-y-1">
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 bg-red-500 rounded-full mr-2"></div>
                                        <span class="text-green-700">Sangat Miskin (≥20)</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 bg-orange-500 rounded-full mr-2"></div>
                                        <span class="text-green-700">Miskin (15-19)</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 bg-yellow-500 rounded-full mr-2"></div>
                                        <span class="text-green-700">Rentan Miskin (10-14)</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 bg-green-500 rounded-full mr-2"></div>
                                        <span class="text-green-700">Tidak Miskin (<10)< /span>
                                    </div>
                                </div>
                            </div>

                            <!-- Survey Status -->
                            <div>
                                <h5 class="font-medium text-green-800 mb-2">Status Survei:</h5>
                                <div class="space-y-1">
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 border-2 border-gray-500 rounded-full mr-2"></div>
                                        <span class="text-green-700">Draft</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 border-2 border-yellow-500 rounded-full mr-2"></div>
                                        <span class="text-green-700">Menunggu Verifikasi</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 border-2 border-green-500 rounded-full mr-2 bg-green-500"></div>
                                        <span class="text-green-700">Terverifikasi</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-4 border-2 border-red-500 rounded-full mr-2"></div>
                                        <span class="text-green-700">Ditolak</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Facilities -->
                            <div>
                                <h5 class="font-medium text-green-800 mb-2">Fasilitas Umum:</h5>
                                <div class="space-y-1">
                                    <div class="flex items-center">
                                        <span class="w-4 h-4 mr-2 text-center">🏫</span>
                                        <span class="text-green-700">Sekolah</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-4 h-4 mr-2 text-center">🏥</span>
                                        <span class="text-green-700">Puskesmas/RS</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-4 h-4 mr-2 text-center">🏢</span>
                                        <span class="text-green-700">Kantor Desa</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-4 h-4 mr-2 text-center">🕌</span>
                                        <span class="text-green-700">Tempat Ibadah</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Roads -->
                            <div>
                                <h5 class="font-medium text-green-800 mb-2">Kondisi Jalan:</h5>
                                <div class="space-y-1">
                                    <div class="flex items-center">
                                        <div class="w-4 h-1 bg-green-500 mr-2"></div>
                                        <span class="text-green-700">Baik</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-1 bg-yellow-500 mr-2"></div>
                                        <span class="text-green-700">Sedang</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-4 h-1 bg-red-500 mr-2"></div>
                                        <span class="text-green-700">Rusak</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-green-200 shadow-md">
                            <div class="text-2xl font-bold text-green-600" id="total-surveys">{{ $surveys->count() }}</div>
                            <div class="text-sm text-green-700">Total Survei</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-green-200 shadow-md">
                            <div class="text-2xl font-bold text-red-600" id="sangat-miskin-count">{{ $surveys->where('poverty_level', 'Sangat Miskin')->count() }}</div>
                            <div class="text-sm text-green-700">Sangat Miskin</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-green-200 shadow-md">
                            <div class="text-2xl font-bold text-orange-600" id="miskin-count">{{ $surveys->where('poverty_level', 'Miskin')->count() }}</div>
                            <div class="text-sm text-green-700">Miskin</div>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-green-200 shadow-md">
                            <div class="text-2xl font-bold text-yellow-600" id="rentan-miskin-count">{{ $surveys->where('poverty_level', 'Rentan Miskin')->count() }}</div>
                            <div class="text-sm text-green-700">Rentan Miskin</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    // Initialize map
    const map = L.map('map').setView([-0.0263, 109.3425], 9); // ✅ Center ke Kalimantan Barat

    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    setTimeout(function() {
        map.invalidateSize();
    }, 100);

    // Layer groups
    const surveysLayer = L.layerGroup().addTo(map);
    const facilitiesLayer = L.layerGroup();
    const roadsLayer = L.layerGroup();
    const workAreaLayer = L.layerGroup();

    // ✅ PERBAIKAN: Hapus spasi di arrow operator
    const allSurveys = {!! json_encode($surveys->map(function($survey) {
        return [
            'id' => $survey->id,
            'name' => $survey->nama_kepala_keluarga,
            'latitude' => (float) $survey->latitude,
            'longitude' => (float) $survey->longitude,
            'address' => $survey->alamat_lengkap,
            'village' => $survey->neighborhood->village->name ?? 'N/A',
            'poverty_level' => $survey->poverty_level ?? 'Tidak Diketahui',
            'poverty_score' => $survey->poverty_score ?? 0,
            'members' => $survey->jumlah_anggota_keluarga,
            'status' => $survey->status_verifikasi,
            'created_at' => $survey->created_at->format('d/m/Y'),
            'economic_status' => $survey->sumber_penghasilan ?? 'N/A',
            'house_condition' => $survey->jenis_bangunan ?? 'N/A'
        ];
    })) !!};

    const publicFacilities = {!! json_encode($publicFacilities->map(function($facility) {
        return [
            'id' => $facility->id,
            'name' => $facility->name,
            'type' => $facility->type,
            'latitude' => (float) $facility->latitude,
            'longitude' => (float) $facility->longitude,
            'condition' => $facility->kondisi,
            'village' => $facility->village->name ?? 'N/A',
            'address' => $facility->alamat ?? ''
        ];
    })) !!};

    const mainRoads = {!! json_encode($mainRoads->map(function($road) {
        return [
            'id' => $road->id,
            'name' => $road->name,
            'condition' => $road->kondisi_jalan,
            'type' => $road->jenis_jalan,
            'coordinates' => $road->coordinates,
            'village' => $road->village->name ?? 'N/A',
            'width' => $road->lebar_jalan
        ];
    })) !!};

    // Work area data
    const workAreas = {!! json_encode($workAreaVillages->map(function($village) {
        return [
            'name' => $village->name,
            'district' => $village->district->name
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
                    <h4 class="font-bold text-green-900 mb-2">${survey.name}</h4>
                    <div class="space-y-1 text-sm">
                        <div><strong class="text-green-700">Alamat:</strong> <span class="text-green-900">${survey.address}</span></div>
                        <div><strong class="text-green-700">Desa:</strong> <span class="text-green-900">${survey.village}</span></div>
                        <div><strong class="text-green-700">Anggota:</strong> <span class="text-green-900">${survey.members} orang</span></div>
                        <div><strong class="text-green-700">Penghasilan:</strong> <span class="text-green-900">${survey.economic_status.replace('_', ' ')}</span></div>
                        <div><strong class="text-green-700">Kondisi Rumah:</strong> <span class="text-green-900">${survey.house_condition.replace('_', ' ')}</span></div>
                        <div><strong class="text-green-700">Status:</strong> 
                            <span class="px-2 py-1 text-xs font-semibold rounded-full ${getStatusBadgeClass(survey.status)}">
                                ${survey.status}
                            </span>
                        </div>
                        <div><strong class="text-green-700">Kategori:</strong> 
                            <span class="px-2 py-1 text-xs font-semibold rounded-full ${getPovertyBadgeClass(survey.poverty_level)}">
                                ${survey.poverty_level}
                            </span>
                        </div>
                        <div><strong class="text-green-700">Skor:</strong> <span class="text-green-900">${survey.poverty_score}/25</span></div>
                        <div><strong class="text-green-700">Tanggal:</strong> <span class="text-green-900">${survey.created_at}</span></div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-green-200">
                        <a href="/petugas/surveys/${survey.id}" 
                           style="display: block; width: 100%; background: linear-gradient(to right, #16a34a, #15803d); color: #ffffff !important; text-align: center; padding: 8px 12px; border-radius: 6px; font-size: 14px; font-weight: 500; text-decoration: none; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
                           onmouseover="this.style.background='linear-gradient(to right, #15803d, #166534)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.15)'"
                           onmouseout="this.style.background='linear-gradient(to right, #16a34a, #15803d)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">
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

    // Load public facilities
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
                <div class="p-3 min-w-48">
                    <h4 class="font-bold text-green-900 mb-2">${facility.name}</h4>
                    <div class="space-y-1 text-sm">
                        <div><strong class="text-green-700">Jenis:</strong> <span class="text-green-900">${facility.type.replace('_', ' ')}</span></div>
                        <div><strong class="text-green-700">Desa:</strong> <span class="text-green-900">${facility.village}</span></div>
                        <div><strong class="text-green-700">Kondisi:</strong> 
                            <span class="px-2 py-1 text-xs font-semibold rounded-full ${facility.condition === 'baik' ? 'bg-green-100 text-green-800' : facility.condition === 'sedang' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}">
                                ${facility.condition}
                            </span>
                        </div>
                        ${facility.address ? `<div><strong class="text-green-700">Alamat:</strong> <span class="text-green-900">${facility.address}</span></div>` : ''}
                    </div>
                </div>
            `;

            marker.bindPopup(popupContent);
            facilitiesLayer.addLayer(marker);
        });
    }

    // Load main roads
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
                const coordinates = typeof road.coordinates === 'string' ?
                    JSON.parse(road.coordinates) :
                    road.coordinates;

                if (!Array.isArray(coordinates) || coordinates.length < 2) {
                    console.warn('Invalid road coordinates:', road);
                    return;
                }

                const polyline = L.polyline(coordinates, {
                    color: getRoadColor(road.condition),
                    weight: 4,
                    opacity: 0.8
                });

                const popupContent = `
                    <div class="p-3 min-w-48">
                        <h4 class="font-bold text-green-900 mb-2">${road.name}</h4>
                        <div class="space-y-1 text-sm">
                            <div><strong class="text-green-700">Jenis:</strong> <span class="text-green-900">${road.type.replace('_', ' ')}</span></div>
                            <div><strong class="text-green-700">Kondisi:</strong> 
                                <span class="px-2 py-1 text-xs font-semibold rounded-full ${road.condition === 'baik' ? 'bg-green-100 text-green-800' : road.condition === 'sedang' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}">
                                    ${road.condition}
                                </span>
                            </div>
                            <div><strong class="text-green-700">Desa:</strong> <span class="text-green-900">${road.village}</span></div>
                            ${road.width ? `<div><strong class="text-green-700">Lebar:</strong> <span class="text-green-900">${road.width}m</span></div>` : ''}
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

    // Helper functions
    function getPovertyColor(level) {
        switch (level) {
            case 'Sangat Miskin': return '#EF4444';
            case 'Miskin': return '#F97316';
            case 'Rentan Miskin': return '#EAB308';
            case 'Tidak Miskin': return '#22C55E';
            default: return '#6B7280';
        }
    }

    function getStatusStyle(status) {
        switch (status) {
            case 'draft': return { color: '#6B7280', weight: 2, fillOpacity: 0.5 };
            case 'submitted': return { color: '#F59E0B', weight: 3, fillOpacity: 0.6 };
            case 'verified': return { color: '#10B981', weight: 2, fillOpacity: 0.8 };
            case 'rejected': return { color: '#EF4444', weight: 3, fillOpacity: 0.4 };
            default: return { color: '#6B7280', weight: 2, fillOpacity: 0.5 };
        }
    }

    function getPovertyBadgeClass(level) {
        switch (level) {
            case 'Sangat Miskin': return 'bg-red-100 text-red-800';
            case 'Miskin': return 'bg-orange-100 text-orange-800';
            case 'Rentan Miskin': return 'bg-yellow-100 text-yellow-800';
            case 'Tidak Miskin': return 'bg-green-100 text-green-800';
            default: return 'bg-gray-100 text-gray-800';
        }
    }

    function getStatusBadgeClass(status) {
        switch (status) {
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
        return `<div style="background: white; border-radius: 50%; padding: 4px; font-size: 18px; border: 2px solid #16a34a; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">${icons[type] || icons['lainnya']}</div>`;
    }

    function getRoadColor(condition) {
        switch (condition) {
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

        if (totalElement) totalElement.textContent = surveys.length;
        if (sangat) sangat.textContent = surveys.filter(s => s.poverty_level === 'Sangat Miskin').length;
        if (miskin) miskin.textContent = surveys.filter(s => s.poverty_level === 'Miskin').length;
        if (rentan) rentan.textContent = surveys.filter(s => s.poverty_level === 'Rentan Miskin').length;
    }

    // Event listeners for toggles
    const showSurveys = document.getElementById('show-my-surveys');
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

    const statusFilter = document.getElementById('status-filter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value;

            if (selectedStatus === '') {
                currentSurveys = allSurveys;
            } else {
                currentSurveys = allSurveys.filter(survey => survey.status === selectedStatus);
            }

            loadSurveys(currentSurveys);
        });
    }

    // Initial load
    loadSurveys();

    // Center map on user's surveys if available
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
</script>
@endpush

</x-layouts.petugas>