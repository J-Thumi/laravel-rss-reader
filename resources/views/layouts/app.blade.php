<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'OmniFeed')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-brand { font-weight: 700; }
        .news-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); }
        .card-img-top { width: 100%; height: 180px; object-fit: cover; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('techcrunch') }}">OmniFeed</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('techcrunch')) active @endif" href="{{ route('techcrunch') }}">TechCrunch</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if(request()->routeIs('google-news')) active @endif" href="#" role="button" data-bs-toggle="dropdown">
                            Google News
                        </a>
                        <ul class="dropdown-menu">
                            @php
                                $topics = ['Technology', 'Science', 'Business', 'Health', 'Sports'];
                            @endphp
                            @foreach($topics as $topic)
                                <li>
                                    <a class="dropdown-item @if(request()->input('query') == $topic) active @endif"
                                        href="{{ route('google-news', ['query' => $topic]) }}">
                                        {{ $topic }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
