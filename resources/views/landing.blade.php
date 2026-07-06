<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="text-center space-y-8 px-4">
        <h1 class="text-4xl font-bold text-gray-900">Welcome</h1>
        <p class="text-gray-600">Choose where you'd like to go</p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('shop.index') }}"
               class="px-8 py-4 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                Visit Shop
            </a>
            <a href="{{ route('blog.home') }}"
               class="px-8 py-4 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-900 transition">
                Read Blog
            </a>
        </div>
    </div>
</body>
</html>