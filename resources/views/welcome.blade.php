<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Singkat URL - Unlimited URL Shortener - Shorten and manage your URLs with ease.</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">

    <!-- Recaptcha Script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Singkat URL - Unlimited URL Shortener - Shorten and manage your URLs with ease.">
    <meta name="keywords" content="Singkat URL, URL Shortener, Short URL, SEO">
    <meta name="author" content="Ri-zuta">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Singkat URL">
    <meta property="og:description" content="Unlimited URL Shortener - Shorten and manage your URLs with ease.">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('path/to/your/image.jpg') }}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Singkat URL">
    <meta name="twitter:description" content="Unlimited URL Shortener - Shorten and manage your URLs with ease.">
    <meta name="twitter:image" content="{{ asset('path/to/your/image.jpg') }}">

    <script>
        // const existingCustomCodes = {!! json_encode($existingCustomCodes) !!};

        document.addEventListener("DOMContentLoaded", function() {
            const customCodeInput = document.querySelector('input[name="custom_code"]');
            const shortenForm = document.querySelector('form');

            shortenForm.addEventListener('submit', function(event) {
                const customCode = customCodeInput.value.trim();
                const recaptchaResponse = grecaptcha.getResponse();

                if (!recaptchaResponse) {
                    event.preventDefault(); // Hentikan pengiriman formulir
                    alert('Harap verifikasi bahwa Anda bukan robot.');
                    return;
                }
            });

            const shortUrlElement = document.getElementById('urlcontent');

            shortUrlElement.addEventListener('click', function() {
                const urlToCopy = shortUrlElement.textContent;
                navigator.clipboard.writeText(urlToCopy);
                alert('URL berhasil disalin: ' + urlToCopy);
            });
        });
    </script>
</head>
<body class="bg-gray-200 flex items-center justify-center h-screen">
    <div class="container mx-auto w-96 p-8 bg-white rounded shadow-md text-center">
        <form method="post" action="/shorten" class="flex flex-col items-center">
            @csrf
            <input placeholder="URL Asli" type="url" name="original_url" required class="p-2 text-lg border border-gray-300 rounded mb-6 w-full">
            <input placeholder="Kustom (Opsional)" type="text" name="custom_code" class="p-2 text-lg border border-gray-300 rounded mb-6 w-full">
            <div class="g-recaptcha mb-6" data-sitekey="6LdHTU4pAAAAAHQpIOL_loBUr6exCEW8J_0Rlj3g"></div>
            <button type="submit" class="bg-green-500 text-white p-3 rounded text-lg cursor-pointer">Singkatkan URL</button>
        </form>

        @if(session('message'))
            <p class="message text-lg">{{ session('message') }}</p>
        @elseif(session('shortUrl'))
            <p class="text-lg m-4 text-gray-900">Hasil: </p>
            <button id="urlcontent" class="text-blue-500 font-bold cursor-pointer"><span id="baseUrl">{{ url('/') }}</span>/{{ session('shortUrl') }}</button>
        @endif
    </div>
</body>
</html>
