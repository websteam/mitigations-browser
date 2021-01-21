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
        @if(count($data) > 0)
            <ul class="list-group">
                @foreach($data as $object)
                    <a href="{{ route($object->type . '_show', ['external_id' => $object->external_id]) }}" class="list-group-item">
                        <h6>{{ $object->external_id }}</h6>
                        <p class="mb-0">{{ $object->name }}</p>
                    </a>
                @endforeach
            </ul>
        @else
            <p class="mb-0">No results found.</p>
        @endif
    </div>
@endsection
