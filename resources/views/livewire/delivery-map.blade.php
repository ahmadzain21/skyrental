<div class="p-4 md:p-6 space-y-6">

    <h2 class="text-xl md:text-2xl font-bold">
        Delivery Route
    </h2>

    <!-- MAP -->
    <div id="map" class="w-full h-[350px] md:h-[500px] lg:h-[700px] rounded-xl shadow-lg" wire:ignore></div>

    <div class="space-y-8">

        <!-- MATRIX -->
        <div class="bg-white p-6 rounded-xl shadow overflow-x-auto">

            <h3 class="text-xl font-semibold mb-4">
                Matriks Bobot (OSRM)
            </h3>

            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">Dari / Ke</th>

                        @foreach ($matrixLabels as $label)
                            <th class="border p-2">
                                {{ $label }}
                                <br>
                                <span class="text-xs text-gray-500">
                                    {{ $nodeLabels[$label] }}
                                </span>
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>

                    @foreach ($distanceMatrix as $from => $row)
                        <tr>

                            <td class="border p-2 font-semibold">
                                {{ $from }}
                                <br>
                                <span class="text-xs text-gray-500">
                                    {{ $nodeLabels[$from] }}
                                </span>
                            </td>

                            @foreach ($row as $distance)
                                <td class="border p-2 text-center">

                                    @if ($distance >= PHP_FLOAT_MAX)
                                        ∞
                                    @else
                                        {{ number_format($distance, 2) }} km
                                    @endif

                                </td>
                            @endforeach

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

        <!-- DIJKSTRA -->
        <div class="bg-white p-6 rounded-xl shadow overflow-x-auto">

            <h3 class="text-xl font-semibold mb-4">
                Proses Iterasi Algoritma Dijkstra
            </h3>

            <table class="w-full border text-sm">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="border p-2">Iterasi</th>

                        <th class="border p-2">Node Aktif</th>

                        <th class="border p-2">Visited</th>

                        <th class="border p-2">Distance</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($dijkstraSteps as $step)
                        <tr>

                            <td class="border p-2 text-center">
                                {{ $step['step'] }}
                            </td>

                            <td class="border p-2">

                                {{ $step['current'] }}

                                <br>

                                <span class="text-xs text-gray-500">

                                    {{ $nodeLabels[$step['current']] }}

                                </span>

                            </td>

                            <td class="border p-2">

                                {{ implode(', ', $step['visited']) }}

                            </td>

                            <td class="border p-2">

                                @foreach ($step['distances'] as $node => $distance)
                                    <div>

                                        <strong>{{ $node }}</strong>

                                        :

                                        @if (in_array($node, $step['visited']))
                                            <span class="text-green-600 font-semibold">
                                                ✓ Selesai
                                            </span>
                                        @elseif ($distance >= PHP_FLOAT_MAX)
                                            ∞
                                        @else
                                            {{ number_format($distance, 2) }} km
                                        @endif

                                    </div>
                                @endforeach

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

        <!-- RESULT -->
        <div class="bg-white p-6 rounded-xl shadow overflow-x-auto">

            <h3 class="text-xl font-semibold mb-4">

                Hasil Perhitungan Dijkstra

            </h3>

            <table class="w-full border text-sm">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="border p-2">Node</th>

                        <th class="border p-2">Jarak Minimum</th>

                        <th class="border p-2">Previous</th>

                        <th class="border p-2">Lintasan</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($dijkstraResult as $node => $result)
                        <tr>

                            <td class="border p-2">

                                {{ $node }}

                                <br>

                                <span class="text-xs text-gray-500">

                                    {{ $nodeLabels[$node] }}

                                </span>

                            </td>

                            <td class="border p-2">

                                @if ($result['distance'] === null)
                                    ∞
                                @else
                                    {{ number_format($result['distance'], 2) }} km
                                @endif

                            </td>

                            <td class="border p-2">

                                {{ $result['previous'] ?? '-' }}

                            </td>

                            <td class="border p-2">

                                {{ $this->buildPath($node) }}

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

        <!-- SUMMARY -->
        <div class="bg-green-50 border border-green-300 rounded-xl p-6">

            <h3 class="text-xl font-semibold text-green-700">

                Ringkasan Rute

            </h3>

            <p class="mt-3">

                <strong>Total Jarak :</strong>

                {{ number_format($totalDistance, 2) }} km

            </p>

            <p class="mt-2">

                <strong>Urutan Tujuan :</strong>

                {{ implode(' → ', $optimalRoute) }}

            </p>

        </div>

        <!-- STATUS -->
        <div class="text-sm md:text-base">
            Delivery Status: <strong>{{ $deliveryStatus }}</strong>
        </div>

        <!-- BUTTONS -->
        <div class="flex flex-col sm:flex-row gap-2">
            <button wire:click="$refresh" class="bg-gray-500 text-white px-4 py-2 rounded w-full sm:w-auto">
                Refresh
            </button>

            @if ($deliveryStatus === 'assigned')
                <button wire:click="startDelivery" class="bg-green-600 text-white px-4 py-2 rounded w-full sm:w-auto">
                    Mulai Perjalanan
                </button>
            @endif

            @if ($deliveryStatus === 'on_delivery')
                <button wire:click="finishDelivery" class="bg-blue-600 text-white px-4 py-2 rounded w-full sm:w-auto">
                    Selesai Perjalanan
                </button>
            @endif

            @if ($deliveryStatus === 'delivered')
                <button wire:click="backToDelivery" class="bg-red-600 text-white px-4 py-2 rounded w-full sm:w-auto">
                    Kembali
                </button>
            @endif
        </div>

    </div>
</div>



@push('scripts')
    <script>
        function initDeliveryMap() {
            const mapElement = document.getElementById('map');
            if (!mapElement) return;

            // Hapus instance map sebelumnya (Livewire safe)
            if (window.deliveryMap) {
                window.deliveryMap.remove();
                window.deliveryMap = null;
            }

            if (window.routingControl) {
                window.routingControl.remove();
                window.routingControl = null;
            }

            const startIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            const customerIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            const points = @json($routePoints);
            const startPoint = @json($startPoint);

            console.log('Route Points:', points);

            if (!points || points.length === 0 || !startPoint) {
                console.error('Data routePoints / startPoint invalid');
                return;
            }

            const map = L.map('map').setView(
                [startPoint.lat, startPoint.long],
                13
            );

            window.deliveryMap = map;

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            const latlngs = [];

            // ===== START POINT =====
            latlngs.push([startPoint.lat, startPoint.long]);

            L.marker([startPoint.lat, startPoint.long], {
                    icon: startIcon
                })
                .addTo(map)
                .bindPopup('Titik Awal Delivery');

            // ===== CUSTOMER POINTS =====
            points.forEach((point) => {
                latlngs.push([point.lat, point.long]);

                L.marker([point.lat, point.long], {
                        icon: customerIcon
                    })
                    .addTo(map)
                    .bindPopup(`
                <b>${point.customer_name}</b><br>
                ${point.address}
            `);
            });

            // ===== ROUTING =====
            window.routingControl = L.Routing.control({
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
                        return L.marker(wp.latLng, {
                                icon: startIcon
                            })
                            .bindPopup('Titik Awal Delivery');
                    }

                    const customer = points[i - 1];

                    return L.marker(wp.latLng, {
                            icon: customerIcon
                        })
                        .bindPopup(`
                        <b>${customer.customer_name}</b><br>
                        ${customer.address}
                    `);
                }
            }).addTo(map);

            map.fitBounds(L.latLngBounds(latlngs));

            setTimeout(() => {
                map.invalidateSize();
            }, 300);
        }

        document.addEventListener('DOMContentLoaded', initDeliveryMap);
        document.addEventListener('livewire:navigated', initDeliveryMap);
    </script>
@endpush
