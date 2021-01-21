@extends('layouts.app')

@section('title', 'Search results')

@section('content')
    <div>
        <h2>Search results</h2>
        <div>
            <p>Queried string: {{ $query }}</p>
        </div>
    </div>

    <div class="card rounded overflow-hidden p-3">
        @if(count($techniques) > 0)
            <ul class="list-group">
                @foreach($techniques as $technique)
                    <a href="{{ route('techniques_show', ['external_id' => $technique->external_id]) }}" class="list-group-item">
                        <h6>{{ $technique->external_id }}</h6>
                        <p class="mb-0">{{ $technique->name }}</p>
                    </a>
                @endforeach
            </ul>
        @else
            <p class="mb-0">No results found.</p>
        @endif
    </div>
@endsection
