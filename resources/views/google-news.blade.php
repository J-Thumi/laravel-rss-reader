@extends('layouts.app')

@section('title', ucfirst($category) . ' - Google News')

@section('content')

<div class="mb-4 d-flex justify-content-between align-items-center">
    <form method="GET" class="d-flex align-items-center">
        <label class="me-2">Show news from last:</label>
        <input type="number" name="days" value="{{ $daysAgo }}" class="form-control me-2" style="width: 80px;">
        <input type="hidden" name="category" value="{{ $category }}">
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <div>
        <label>Category:</label>
        <select onchange="location = this.value;" class="form-select">
            @php $topics = ['technology','science','business','health','sports']; @endphp
            @foreach($topics as $topic)
                <option value="{{ route('google-news', ['category' => $topic, 'days' => $daysAgo]) }}" @if($topic==$category) selected @endif>
                    {{ ucfirst($topic) }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @foreach($items as $item)
        <div class="col">
            <a href="{{ $item['link'] }}" target="_blank" class="text-decoration-none">
                <div class="card news-card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $item['title'] }}</h5>
                        <!-- <p>{{ $item['description']}}</p> -->
                        <small class="text-muted mt-auto">{{ $item['published_at']->toDayDateTimeString() }}</small>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

<div class="mt-4">
    {{ $items->links('pagination::bootstrap-5') }}
</div>

@endsection
