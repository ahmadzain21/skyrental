<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;

class DeliveryMap extends Component
{
    public $bookings = [];
    public $routePoints = [];

    public $initialMatrix = [];
    public $distanceMatrix = [];
    public $dijkstraResult = [];
    public $totalDistance = 0;
    public $optimalRoute = [];
    public $matrixLabels = [];
    public $dijkstraSteps = [];
    public $nodeLabels = [];

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

        $this->bookings = Booking::whereIn('id', $bookingIds)
            ->whereNotNull('lat')
            ->whereNotNull('long')
            ->where('lat', '!=', 0)
            ->where('long', '!=', 0)
            ->get();

        $this->buildDistanceMatrix();

        $this->routePoints = $this->runDijkstra();
    }

    private function buildDistanceMatrix()
{
    $points = collect([$this->startPoint])->merge($this->bookings);

    foreach ($points as $i => $from) {

        $labelFrom = $i === 0 ? 'A' : chr(65 + $i);

        $this->matrixLabels[] = $labelFrom;

        $this->nodeLabels[$labelFrom] = $i === 0
            ? 'Base Delivery'
            : $from->customer_name;

        foreach ($points as $j => $to) {

            $labelTo = $j === 0 ? 'A' : chr(65 + $j);

            // hasil jarak asli (hasil akhir / setelah Dijkstra)
            $realDistance = round(
                $this->distance(
                    $from['lat'],
                    $from['long'],
                    $to['lat'],
                    $to['long']
                ),
                2
            );

            $alternatives = $this->getAlternativeRoutes($from, $to);

            // MATRIX HASIL DIJKSTRA
            $this->distanceMatrix[$labelFrom][$labelTo] = min($alternatives);

            // MATRIX SEBELUM DIJKSTRA
            // simulasi bobot awal belum optimal
            if ($labelFrom === $labelTo) {

                $this->initialMatrix[$labelFrom][$labelTo] = 0;

            } else {

                // tambahkan penalti 10%-30%

                $this->initialMatrix[$labelFrom][$labelTo] = implode(
    ' / ',
    $alternatives
);
            }
        }
    }
}

private function getAlternativeRoutes($from, $to)
{
    $url = "https://router.project-osrm.org/route/v1/driving/" .
        "{$from['long']},{$from['lat']};" .
        "{$to['long']},{$to['lat']}" .
        "?alternatives=true&overview=false";

    $response = file_get_contents($url);

    $data = json_decode($response, true);

    return collect($data['routes'])
        ->pluck('distance')
        ->map(fn($d) => round($d / 1000, 2))
        ->toArray();
}

    private function runDijkstra()
    {
        $nodes = $this->matrixLabels;

        $dist = [];
        $prev = [];
        $visited = [];

        foreach ($nodes as $node) {
            $dist[$node] = INF;
            $prev[$node] = null;
            $visited[$node] = false;
        }

        $dist['A'] = 0;

        foreach ($nodes as $stepIndex => $nodeLoop) {
            $u = null;

            foreach ($nodes as $node) {
                if (!$visited[$node] && ($u === null || $dist[$node] < $dist[$u])) {
                    $u = $node;
                }
            }

            $visited[$u] = true;

            $this->dijkstraSteps[] = [
                'step' => $stepIndex + 1,
                'current' => $u,
                'distances' => $dist,
                'visited' => $visited
            ];

            foreach ($nodes as $neighbor) {
                if (!$visited[$neighbor]) {
                    $alt = $dist[$u] + $this->distanceMatrix[$u][$neighbor];

                    if ($alt < $dist[$neighbor]) {
                        $dist[$neighbor] = $alt;
                        $prev[$neighbor] = $u;

                        // update matrix hasil setelah Dijkstra
                        $this->distanceMatrix['A'][$neighbor] = round($alt, 2);
                    }
                }
            }
        }

        foreach ($nodes as $node) {
            $this->dijkstraResult[$node] = [
                'distance' => round($dist[$node], 4),
                'previous' => $prev[$node]
            ];
        }

        $this->totalDistance = array_sum($dist);

        $route = [];

        $sortedNodes = collect($this->dijkstraResult)
            ->except('A')
            ->sortBy('distance');

        foreach ($sortedNodes as $node => $result) {
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

        return $route;
    }

    private function distance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a =
            sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($dLon / 2) *
            sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 2);
    }

    public function render()
    {
        return view('livewire.delivery-map');
    }
}
