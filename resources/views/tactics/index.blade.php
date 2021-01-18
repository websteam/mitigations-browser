@extends('layouts.app')

@section('title', 'Tactics')

@section('content')
    <div class="d-flex justify-content-between align-items-end">
        <h2>Tactics</h2>
        <div>
            <p>Tactics: {{ count($tactics) }}</p>
        </div>
    </div>

    <table class="table table-light table-striped table-bordered table-responsive-lg">
        <thead class="table-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
        </tr>
        </thead>
        @foreach ($tactics as $tactic)
            <tr>
                <td>
                    <a href="{{ route('tactics_show', ['external_id' => $tactic->external_id]) }}">
                        {{ $tactic->external_id }}
                    </a>
                </td>
                <td>
                    <a href="{{ route('tactics_show', ['external_id' => $tactic->external_id]) }}">
                        {{ $tactic->name }}
                    </a>
                </td>
                <td>@markdown($tactic->excerpt)</td>
            </tr>
        @endforeach
    </table>
@endsection
