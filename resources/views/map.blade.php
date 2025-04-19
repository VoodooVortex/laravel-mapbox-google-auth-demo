<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Custom Mapbox with Laravel & Livewire</title>

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>

<body class="bg-gray-100">
    <div class="container mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold mb-6">Custom Mapbox Viewer</h1>

        @livewire('map-location')
    </div>

    @livewireScripts
</body>

</html>
