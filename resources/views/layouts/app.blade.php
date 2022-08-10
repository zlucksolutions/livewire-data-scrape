<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    @livewireStyles
</head>
<body>
    <div class="container mx-auto">
        
        <header class="bg-gray-400 flex justify-start pt-4 pb-4 space-x-4 shadow mb-4">
            <a href="{{ url('/product') }}" class="ml-4 bg-red-700 p-2 rounded hover:bg-black">All Products</a>
            <a href="{{ url('/scrape') }}" class="bg-green-800 p-2 rounded hover:bg-black">Scrape</a>
        </header>
        
        {{ $slot }}
    </div>
    @livewireScripts
</body>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

    
</html>