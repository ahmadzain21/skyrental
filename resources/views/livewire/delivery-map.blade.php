<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">
        Delivery Route
    </h2>

    <div id="map" class="w-full h-[700px] rounded-xl shadow-lg" wire:ignore>
    </div>

    <div class="mt-8 space-y-8">

        <!-- Matriks Awal -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-4">Matriks Jarak Awal</h3>

            <table class="w-full border border-gray-300 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">Dari/Ke</th>
                        @foreach ($matrixLabels as $label)
                            <th class="border p-2">{{ $label }} ({{ $nodeLabels[$label] }})</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($initialMatrix as $from => $row)
                        <tr>
                            <td class="border p-2 font-semibold">{{ $from }} ({{ $nodeLabels[$from] }})</td>
                            @foreach ($row as $distance)
                                <td class="border p-2">{{ $distance . ' km' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-4">Matriks Jarak sesudah dijkstra</h3>

            <table class="w-full border border-gray-300 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">Dari/Ke</th>
                        @foreach ($matrixLabels as $label)
                            <th class="border p-2">{{ $label }} ({{ $nodeLabels[$label] }})</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($distanceMatrix as $from => $row)
                        <tr>
                            <td class="border p-2 font-semibold">{{ $from }} ({{ $nodeLabels[$from] }})</td>
                            @foreach ($row as $distance)
                                <td class="border p-2">{{ is_infinite($distance) ? '∞' : $distance . ' km' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-xl font-semibold mb-4">
        Proses Iterasi Dijkstra
    </h3>

    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2">Iterasi</th>
                <th class="border p-2">Node Aktif</th>
                <th class="border p-2">Jarak Tiap Node</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dijkstraSteps as $step)
                <tr>
                    <td class="border p-2">
                        {{ $step['step'] }}
                    </td>

                    <td class="border p-2 font-semibold">
                        {{ $step['current'] }} ({{ $nodeLabels[$step['current']] }})
                    </td>

                    <td class="border p-2">
                        @foreach($step['distances'] as $node => $distance)
                            <div>
                                {{ $node }} ({{ $nodeLabels[$node] }}):
                                {{ is_infinite($distance) ? '∞' : round($distance,4) }}
                            </div>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

        <!-- Hasil Dijkstra -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-4">Hasil Perhitungan Dijkstra</h3>

            <table class="w-full border border-gray-300 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">Node</th>
                        <th class="border p-2">Jarak Minimum</th>
                        <th class="border p-2">Node Sebelumnya</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dijkstraResult as $node => $result)
                        <tr>
                            <td class="border p-2">{{ $node }} ({{ $nodeLabels[$node] }})</td>
                            <td class="border p-2">{{ $result['distance'] }} km</td>
                            <td class="border p-2">{{ $result['previous']
    ? $result['previous'].' ('.$nodeLabels[$result['previous']].')'
    : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total Jarak -->
        <div class="bg-green-50 border border-green-300 p-6 rounded-xl">
            <h3 class="text-xl font-semibold text-green-700">
                Total Jarak Rute Optimal
            </h3>

            <p class="text-lg mt-2">
                <strong>{{ $totalDistance }} km</strong>
            </p>

            <p class="mt-2 text-gray-700">
                Rute:
                {{ implode(' → ', $optimalRoute) }}
            </p>
        </div>

    </div>
</div>



@push('scripts')
    <script>
        function initDeliveryMap() {
            const mapElement = document.getElementById('map');

            if (!mapElement) return;

            // Hindari inisialisasi ganda
            if (mapElement._leaflet_id) {
                mapElement._leaflet_id = null;
                mapElement.innerHTML = '';
            }

            const points = @json($routePoints);

            console.log('Route Points:', points);

            if (!points || points.length === 0 || !points[0]?.lat || !points[0]?.long) {
                console.error('Data routePoints invalid:', points);
                return;
            }

            const map = L.map('map').setView([
                points[0].lat,
                points[0].long
            ], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            const latlngs = [];

            // Titik awal
            latlngs.push([
                {{ $startPoint['lat'] }},
                {{ $startPoint['long'] }}
            ]);

            L.marker([
                    {{ $startPoint['lat'] }},
                    {{ $startPoint['long'] }}
                ])
                .addTo(map)
                .bindPopup('Titik Awal Delivery');

            // Titik customer
            points.forEach((point) => {
                latlngs.push([point.lat, point.long]);

                L.marker([point.lat, point.long])
                    .addTo(map)
                    .bindPopup(`
                    <b>${point.customer_name}</b><br>
                    ${point.address}
                `);
            });

            // Routing
            L.Routing.control({
                waypoints: latlngs.map(p => L.latLng(p[0], p[1])),
                routeWhileDragging: false,
                show: false,
                addWaypoints: false,
                draggableWaypoints: true,
                fitSelectedRoutes: true,

                lineOptions: {
                    styles: [{
                        weight: 6
                    }]
                },

                createMarker: function(i, wp) {
                    if (i === 0) {
                        return L.marker(wp.latLng)
                            .bindPopup('Titik Awal Delivery');
                    }

                    const customer = points[i - 1];

                    return L.marker(wp.latLng)
                        .bindPopup(`
                        <b>${customer.customer_name}</b><br>
                        ${customer.address}
                    `);
                }
            }).addTo(map);

            map.fitBounds(latlngs);

            setTimeout(() => {
                map.invalidateSize();
            }, 300);
        }

        // Saat halaman pertama kali load
        document.addEventListener('DOMContentLoaded', initDeliveryMap);

        // Saat Livewire navigasi
        document.addEventListener('livewire:navigated', initDeliveryMap);
    </script>
@endpush
