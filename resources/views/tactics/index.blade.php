@extends('layouts.app')

@section('title', 'Tactics')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tactics</h2>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
        </tr>
        @foreach ($tactics as $tactic)
            <tr>
                <td>{{ $tactic->external_id }}</td>
                <td>{{ $tactic->name }}</td>
                <td>{{ $tactic->description }}</td>
            </tr>
        @endforeach
    </table>

@endsection
