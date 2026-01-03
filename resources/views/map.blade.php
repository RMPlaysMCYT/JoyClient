@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">📍 Our Store Locations</h4>
        </div>
        <div class="card-body p-0">
            <div id="map" style="width: 100%; height: 600px;"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Center the map (e.g., Manila)
        var map = L.map('map').setView([14.5995, 120.9842], 13);

        // 2. Add the Tile Layer (The map styling)
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        // 3. Add some decorative markers
        var locations = [
            { "name": "Main Branch", "lat": 14.5995, "lng": 120.9842 },
            { "name": "Warehouse",   "lat": 14.5547, "lng": 121.0244 }, // Makati area example
            { "name": "Outlet Store","lat": 14.6091, "lng": 121.0223 }  // QC area example
        ];

        locations.forEach(function(loc) {
            L.marker([loc.lat, loc.lng])
             .addTo(map)
             .bindPopup("<b>" + loc.name + "</b><br>Open 9AM - 9PM");
        });
    });
</script>
@endpush