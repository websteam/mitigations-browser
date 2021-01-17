@extends('layouts.app')

@section('title', 'Techniques')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Techniques</h2>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
        </tr>
        @foreach ($techniques as $techniques)
            <tr>
                <td>{{ $techniques->external_id }}</td>
                <td>{{ $techniques->name }}</td>
                <td>{!! $techniques->excerpt !!}</td>
            </tr>
        @endforeach
    </table>

@endsection
