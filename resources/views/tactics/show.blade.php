@extends('layouts.app')

@section('content')
    <div class="pull-right mb-2">
        <a class="btn btn-primary" href="{{ route('tactics_index') }}" title="Go back"><i
                class="fas fa-arrow-left"></i> Go back</a>
    </div>

    <h2>{{ $tactic->name }}</h2>

    <div class="row">
        <div class="col-lg-8">
            @markdown($tactic->description)
        </div>
        <div class="col-lg-4">
            <div class="border rounded p-3">
                <div class="form-group">
                    <strong>Name:</strong>
                    {{ $tactic->name }}
                </div>
                <div class="form-group">
                    <strong>Date Created:</strong>
                    {{ $tactic->created_at }}
                </div>
                <div class="form-group">
                    <strong>Date Modified:</strong>
                    {{ $tactic->updated_at }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 pt-4">
            <div class="d-flex justify-content-between align-items-end">
                <h2>Techniques</h2>
                <div>
                    <p><strong>Techniques:</strong> {{ count($tactic->techniques) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card rounded overflow-hidden">
        <div class="table-responsive">
            <table class="table table-light table-bordered">
                <thead class="table-dark">
                <tr>
                    <th colspan="2" scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                </tr>
                </thead>
                @foreach ($tactic->techniques as $technique)
                    <tr>
                        <td colspan="2">{{ $technique->external_id }}</td>
                        <td>{{ $technique->name }}</td>
                        <td>@markdown($technique->excerpt)</td>
                    </tr>
                    @foreach ($technique->subtechniques as $subtechnique)
                        <tr class="subtechnique">
                            <td></td>
                            <td>{{ $subtechnique->external_id }}</td>
                            <td>{{ $subtechnique->name }}</td>
                            <td>@markdown($subtechnique->excerpt)</td>
                        </tr>
                    @endforeach
                @endforeach
            </table>
        </div>
    </div>

@endsection
