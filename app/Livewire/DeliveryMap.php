<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use Illuminate\Support\Facades\Cache;

class DeliveryMap extends Component
{
    public $bookings = [];
    public $routePoints = [];
    public $bookingIds = [];

    public $initialMatrix = [];
    public $distanceMatrix = [];
    public $dijkstraResult = [];
    public $totalDistance = 0;
    public $optimalRoute = [];
    public $matrixLabels = [];
    public $dijkstraSteps = [];
    public $nodeLabels = [];
    public $deliveryStatus = 'assigned';

    public $startPoint = [
        'lat' => -8.34796308854452,
        'long' => 114.14747779250621,
        'name' => 'Konter'
    ];

    public function mount()
    {
        $ids = request()->query('ids');

        if (!$ids) return;

        $bookingIds = explode(',', $ids);

        $this->bookingIds = $bookingIds;

        $this->bookings = Booking::whereIn('id', $bookingIds)
            ->whereNotNull('lat')
            ->whereNotNull('long')
            ->where('lat', '!=', 0)
            ->where('long', '!=', 0)
            ->get();

        $this->deliveryStatus = Booking::whereIn('id', $bookingIds)
            ->first()?->delivery_status ?? 'assigned';

        $this->buildDistanceMatrix();

        $this->routePoints = $this->runDijkstra();
    }

    private function buildDistanceMatrix()
    {
        $points = collect([$this->startPoint])->merge($this->bookings);

        foreach ($points as $i => $from) {

            $labelFrom = chr(65 + $i); // A, B, C, D...

            $this->matrixLabels[] = $labelFrom;

            $this->nodeLabels[$labelFrom] = $i === 0
                ? 'Base Delivery'
                : $from->customer_name;

            foreach ($points as $j => $to) {

                $labelTo = chr(65 + $j);

                if ($i === $j) {
                    $distance = 0;
                } else {
                    $distance = $this->getAlternativeRoutes($from, $to);
                }

                // Matrix awal (nilai asli)
                $this->initialMatrix[$labelFrom][$labelTo] = $distance;

                // Matrix hasil (nilai asli)
                $this->distanceMatrix[$labelFrom][$labelTo] = $distance;
            }
        }
    }

    private function getAlternativeRoutes($from, $to)
    {
        $url = "https://router.project-osrm.org/route/v1/driving/" .
            "{$from['long']},{$from['lat']};" .
            "{$to['long']},{$to['lat']}" .
            "?overview=false";

        $cacheKey = 'osrm_' . md5($url);

        $response = Cache::remember($cacheKey, 60 * 60 * 24, function () use ($url) {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 5 // penting biar tidak nge-hang
                ]
            ]);

            return @file_get_contents($url, false, $context);
        });

        if (!$response) {
            return PHP_FLOAT_MAX; // fallback biar tidak crash
        }

        $data = json_decode($response, true);

        return round($data['routes'][0]['distance'] / 1000, 2);
    }

    private function runDijkstra()
    {
        // Daftar node (A = Base, B, C, D, dst.)
        $nodes = $this->matrixLabels;

        // Inisialisasi variabel Dijkstra
        $dist = [];      // Menyimpan jarak terpendek dari titik awal
        $prev = [];      // Menyimpan node sebelumnya
        $visited = [];   // Menandai node yang sudah diproses

        foreach ($nodes as $node) {
            $dist[$node] = PHP_FLOAT_MAX;
            $prev[$node] = null;
            $visited[$node] = false;
        }

        // Titik awal selalu A
        $dist['A'] = 0;

        $this->dijkstraSteps = [];
        $stepIndex = 1;

        // Selama masih ada node yang belum dikunjungi
        while (true) {

            // =====================================================
            // Pilih node yang belum dikunjungi
            // dengan nilai distance paling kecil
            // (Ini adalah inti algoritma Dijkstra)
            // =====================================================
            $u = null;

            foreach ($nodes as $node) {

                if ($visited[$node]) {
                    continue;
                }

                if ($u === null || $dist[$node] < $dist[$u]) {
                    $u = $node;
                }
            }

            // Semua node sudah diproses
            if ($u === null) {
                break;
            }

            // Jika node tidak dapat dijangkau
            if ($dist[$u] == PHP_FLOAT_MAX) {
                break;
            }

            // =====================================================
            // Relaxation
            // Hitung apakah jalur melalui node $u
            // lebih pendek dibanding jalur sebelumnya
            // =====================================================
            foreach ($nodes as $neighbor) {

                // Lewati node yang sudah diproses
                if ($visited[$neighbor]) {
                    continue;
                }

                // Lewati jika tidak ada edge
                if (!isset($this->distanceMatrix[$u][$neighbor])) {
                    continue;
                }

                // Hitung jarak alternatif
                $alt = $dist[$u] + $this->distanceMatrix[$u][$neighbor];

                // Update jika lebih pendek
                if ($alt < $dist[$neighbor]) {
                    $dist[$neighbor] = $alt;
                    $prev[$neighbor] = $u;
                }
            }

            // Tandai node telah diproses
            $visited[$u] = true;

            // Simpan proses iterasi untuk ditampilkan
            $this->dijkstraSteps[] = [
                'step' => $stepIndex++,
                'current' => $u,
                'visited' => array_keys(array_filter($visited)),
                'distances' => $dist
            ];
        }

        // =====================================================
        // Simpan hasil akhir Dijkstra
        // =====================================================
        foreach ($nodes as $node) {

            $this->dijkstraResult[$node] = [
                'distance' => $dist[$node] == PHP_FLOAT_MAX
                    ? null
                    : round($dist[$node], 2),
                'previous' => $prev[$node]
            ];
        }

        // =====================================================
        // Mengurutkan tujuan berdasarkan jarak dari titik awal
        // (Ini bukan bagian algoritma Dijkstra)
        // =====================================================
        $sortedNodes = collect($this->dijkstraResult)
            ->except('A')
            ->filter(fn($item) => $item['distance'] !== null)
            ->sortBy('distance');

        $route = [];
        $this->optimalRoute = [];
        $this->totalDistance = 0;

        $previousNode = 'A';

        foreach ($sortedNodes as $node => $result) {

            // Hitung total jarak sesuai urutan yang ditampilkan
            $this->totalDistance += $this->distanceMatrix[$previousNode][$node];

            $previousNode = $node;

            $index = ord($node) - 66;

            if (isset($this->bookings[$index])) {

                $booking = $this->bookings[$index];

                $this->optimalRoute[] = $booking->customer_name;

                $route[] = [
                    'lat' => (float) $booking->lat,
                    'long' => (float) $booking->long,
                    'customer_name' => $booking->customer_name,
                    'address' => $booking->address
                ];
            }
        }

        $this->totalDistance = round($this->totalDistance, 2);

        return $route;
    }

    public function render()
    {
        return view('livewire.delivery-map');
    }

    public function startDelivery()
    {

        //dd('LIVEWIRE WORKS');
        // update semua booking jadi in progress (atau sesuaikan logika kamu)
        Booking::whereIn('id', $this->bookingIds)
            ->update(['delivery_status' => 'on_delivery']);

        $this->deliveryStatus = 'on_delivery';
        $this->dispatch('$refresh');

        session()->flash('message', 'Perjalanan dimulai');
    }

    public function finishDelivery()
    {
        Booking::whereIn('id', $this->bookingIds)
            ->update(['delivery_status' => 'delivered']);

        $this->deliveryStatus = 'delivered';
        $this->dispatch('$refresh');

        session()->flash('message', 'Perjalanan selesai');
    }

    public function buildPath($node)
    {
        $path = [];

        while ($node !== null) {
            array_unshift($path, $node);
            $node = $this->dijkstraResult[$node]['previous'] ?? null;
        }

        return implode(' → ', $path);
    }

    public function backToDelivery()
    {
        return redirect()->route('booking.delivery');
    }
}
