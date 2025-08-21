@extends('layouts.app')

@section('title', 'TechCrunch Feed')

@section('content')
<div class="row row-cols-1 row-cols-md-3 g-4">
    @foreach($items as $item)
        <div class="col">
            <a href="{{ $item['link'] }}" target="_blank" class="text-decoration-none">
                <div class="card news-card h-100">
                    @if($item['image'])
                        <img src="{{ $item['image'] }}" class="card-img-top" alt="news image">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <small class="card-time text-muted mt-auto">{{ \Carbon\Carbon::parse($item->published_at)->toDayDateTimeString() }}</small>
                        <p class="card-text">{{ Str::limit($item->description, 120) }}</p>
                        
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
