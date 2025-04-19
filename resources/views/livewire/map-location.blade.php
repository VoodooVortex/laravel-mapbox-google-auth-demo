<div>
    <div class="mb-4">
        <h2 class="text-xl font-bold mb-2">Map Style</h2>
        <div class="flex flex-wrap gap-2">
            <button wire:click="updateMapStyle('mapbox://styles/mapbox/streets-v11')"
                class="px-4 py-2 rounded-md {{ $mapStyle === 'mapbox://styles/mapbox/streets-v11' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                Streets
            </button>
            <button wire:click="updateMapStyle('mapbox://styles/mapbox/dark-v10')"
                class="px-4 py-2 rounded-md {{ $mapStyle === 'mapbox://styles/mapbox/dark-v10' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                Dark
            </button>
            <button wire:click="updateMapStyle('mapbox://styles/mapbox/light-v10')"
                class="px-4 py-2 rounded-md {{ $mapStyle === 'mapbox://styles/mapbox/light-v10' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                Light
            </button>
            <button wire:click="updateMapStyle('mapbox://styles/mapbox/satellite-v9')"
                class="px-4 py-2 rounded-md {{ $mapStyle === 'mapbox://styles/mapbox/satellite-v9' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                Satellite
            </button>
            <button wire:click="updateMapStyle('mapbox://styles/mapbox/satellite-streets-v11')"
                class="px-4 py-2 rounded-md {{ $mapStyle === 'mapbox://styles/mapbox/satellite-streets-v11' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                Satellite Streets
            </button>
        </div>
    </div>

    <div class="mb-4">
        <h2 class="text-xl font-bold mb-2">Color Scheme</h2>
        <div class="flex flex-wrap gap-2">
            <button wire:click="updateCustomColors('default')"
                class="px-4 py-2 rounded-md {{ $customColors === 'default' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                Default
            </button>
            <button wire:click="updateCustomColors('blue')"
                class="px-4 py-2 rounded-md {{ $customColors === 'blue' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                Blue Theme
            </button>
            <button wire:click="updateCustomColors('green')"
                class="px-4 py-2 rounded-md {{ $customColors === 'green' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                Green Theme
            </button>
            <button wire:click="updateCustomColors('purple')"
                class="px-4 py-2 rounded-md {{ $customColors === 'purple' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                Purple Theme
            </button>
            <button wire:click="updateCustomColors('monochrome')"
                class="px-4 py-2 rounded-md {{ $customColors === 'monochrome' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                Monochrome
            </button>
        </div>
    </div>

    <div class="mb-4">
        <h2 class="text-xl font-bold mb-2">Map Features</h2>
        <div class="flex flex-wrap gap-2">
            <button wire:click="togglePoi"
                class="px-4 py-2 rounded-md {{ $showPoi ? 'bg-green-600 text-white' : 'bg-red-600 text-white' }}">
                {{ $showPoi ? 'Hide Points of Interest' : 'Show Points of Interest' }}
            </button>
        </div>
    </div>

    <div id="map" class="w-full h-[500px] rounded-lg shadow-lg"></div>

    <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet" />

    <script>
        initMap();

        Livewire.on('mapStyleUpdated', function() {
            initMap();
        });

        function initMap() {
            const mapContainer = document.getElementById('map');
            if (mapContainer._mapboxgl) {
                mapContainer._mapboxgl.remove();
            }

            mapboxgl.accessToken = '{{ $mapboxToken }}';
            const map = new mapboxgl.Map({
                container: 'map',
                style: '{{ $mapStyle }}',
                center: [{{ $center[0] }}, {{ $center[1] }}],
                zoom: {{ $zoom }}
            });

            // Add navigation controls
            map.addControl(new mapboxgl.NavigationControl());

            // Store map instance for cleanup
            mapContainer._mapboxgl = map;

            // Add a marker at the center
            new mapboxgl.Marker()
                .setLngLat([{{ $center[0] }}, {{ $center[1] }}])
                .addTo(map);

            // Apply custom colors when the map is loaded
            map.on('load', function() {
                applyCustomColors(map, '{{ $customColors }}');
                togglePoiLayers(map, {{ $showPoi ? 'true' : 'false' }});
            });
        }

        function applyCustomColors(map, colorScheme) {
            if (colorScheme === 'default') {
                return; // Use default style
            }

            map.on('style.load', function() {
                // Wait for the style to load before modifying layers

                // Get all layers
                const layers = map.getStyle().layers;

                // Apply color scheme based on selection
                switch (colorScheme) {
                    case 'blue':
                        applyColorToWaterAndLand(map, '#0077be', '#e6f7ff', '#cceeff');
                        break;
                    case 'green':
                        applyColorToWaterAndLand(map, '#2e8b57', '#e6ffe6', '#ccffcc');
                        break;
                    case 'purple':
                        applyColorToWaterAndLand(map, '#800080', '#f5e6ff', '#e6ccff');
                        break;
                    case 'monochrome':
                        // Apply monochrome style to all layers
                        layers.forEach(function(layer) {
                            if (layer.type === 'fill') {
                                map.setPaintProperty(layer.id, 'fill-color', '#f0f0f0');
                            } else if (layer.type === 'line') {
                                map.setPaintProperty(layer.id, 'line-color', '#a0a0a0');
                            } else if (layer.type === 'symbol') {
                                map.setPaintProperty(layer.id, 'text-color', '#505050');
                            }
                        });
                        break;
                }
            });
        }

        function applyColorToWaterAndLand(map, waterColor, landColor, roadColor) {
            // Apply to water features
            const waterLayers = ['water', 'water-shadow'];
            waterLayers.forEach(function(layerId) {
                if (map.getLayer(layerId)) {
                    map.setPaintProperty(layerId, 'fill-color', waterColor);
                }
            });

            // Apply to land features
            const landLayers = ['land', 'landcover'];
            landLayers.forEach(function(layerId) {
                if (map.getLayer(layerId)) {
                    map.setPaintProperty(layerId, 'fill-color', landColor);
                }
            });

            // Apply to road features
            const roadLayers = map.getStyle().layers.filter(layer =>
                layer.id.includes('road') && layer.type === 'line'
            );
            roadLayers.forEach(function(layer) {
                map.setPaintProperty(layer.id, 'line-color', roadColor);
            });
        }

        function togglePoiLayers(map, showPoi) {
            map.on('style.load', function() {
                // Find all POI layers
                const poiLayers = map.getStyle().layers.filter(layer =>
                    (layer.id.includes('poi') ||
                        layer.id.includes('place') ||
                        layer.id.includes('label')) &&
                    layer.type === 'symbol'
                );

                // Set visibility for each POI layer
                poiLayers.forEach(function(layer) {
                    map.setLayoutProperty(
                        layer.id,
                        'visibility',
                        showPoi ? 'visible' : 'none'
                    );
                });
            });
        }

        // Listen for Livewire updates
        document.addEventListener('livewire:update', function() {
            initMap();
        });
    </script>
</div>
