<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RSS Reader - TechCrunch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fa;
        }
        .news-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }
        .news-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #212529;
        }
        .news-date {
            font-size: 0.85rem;
            color: #6c757d;
        }
        .news-desc {
            font-size: 0.95rem;
            color: #495057;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4 text-center">📡 TechCrunch RSS Feed</h1>

        <div class="row g-4">
            @foreach($items as $item)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ $item['link'] }}" target="_blank" class="text-decoration-none">
                        <div class="card news-card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="news-title mb-2">{{ $item['title'] }}</h5>
                                <p class="news-date mb-2">{{ \Carbon\Carbon::parse($item['date'])->toDayDateTimeString() }}</p>
                                <p class="news-desc">{{ Str::limit(strip_tags($item['desc']), 120) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
