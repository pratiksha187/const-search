<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Website')</title>
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#f25c05">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
<link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
  <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-EM9F50FXF3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-EM9F50FXF3');
    </script>
    @stack('styles')
</head>

<body>

    <!-- ===================== HEADER ===================== -->
    @include('layouts.header')


    <!-- ===================== MAIN CONTENT ===================== -->
    <main class="py-4">
        @yield('content')
    </main>


    <!-- ===================== FOOTER ===================== -->
    @include('layouts.footer')


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
    <script>
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js')
    .then(function() {
        console.log('Service Worker Registered');
    });
}
</script>

<!-- Install Button -->
<button id="installBtn"
    style="
        display:none;
        position:fixed;
        top:15px;
        right:120px;
        background:#f25c05;
        color:#fff;
        border:none;
        padding:6px 14px;
        border-radius:20px;
        font-size:14px;
        z-index:9999;">
    Install App
</button>

<script>
let deferredPrompt;
const installBtn = document.getElementById('installBtn');

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    installBtn.style.display = 'block';
});

installBtn.addEventListener('click', async () => {
    if (deferredPrompt) {
        deferredPrompt.prompt();
        deferredPrompt = null;
        installBtn.style.display = 'none';
    }
});
</script>


</body>
</html>
