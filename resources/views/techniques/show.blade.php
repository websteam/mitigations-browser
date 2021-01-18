@extends('layouts.app')

@section('title', 'Technique ' . $technique->external_id)

@section('content')
    <div class="pull-right mb-2">
        @if ($technique->is_subtechnique)
            <a class="btn btn-primary" href="{{ route('techniques_show', [
            'external_id' => $technique->technique->external_id
            ]) }}" title="Go back"><i
                    class="fas fa-arrow-left"></i> Go back</a>
        @else
            <a class="btn btn-primary" href="{{ route('tactics_show', [
            'external_id' => $technique->tactics->first()->external_id
            ]) }}" title="Go back"><i
                    class="fas fa-arrow-left"></i> Go back</a>
        @endif
    </div>

    <h2>{{ $technique->name }}</h2>

    <div class="row">
        <div class="col-lg-8">
            @markdown($technique->description)
        </div>
        <div class="col-lg-4">
            <div class="border rounded p-3">
                <div class="form-group">
                    <strong>ID:</strong>
                    {{ $technique->external_id }}
                </div>
                @if (!$technique->is_subtechnique)
                    <div class="form-group">
                        <strong>Tactic:</strong>
                        {{ $technique->tactics->first()->external_id }}
                    </div>
                @endif
                <div class="form-group">
                    <strong>Created:</strong>
                    {{ $technique->created_at }}
                </div>
                <div class="form-group">
                    <strong>Last Modified:</strong>
                    {{ $technique->updated_at }}
                </div>

                @if ($technique->is_subtechnique)
                    <div class="form-group">
                        <strong>Subtechnique of:</strong>
                        <a href="{{ route('techniques_show', [
                            'external_id' => $technique->technique->external_id
                        ]) }}">
                            {{ $technique->technique->external_id }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if (!$technique->is_subtechnique && count($technique->subtechniques))
        <div class="row">
            <div class="col-lg-12 pt-4">
                <div class="d-flex justify-content-between align-items-end">
                    <h2>Subtechniques</h2>
                    <div>
                        <p><strong>Subtechniques:</strong> {{ count($technique->subtechniques) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card rounded overflow-hidden">
            <div class="table-responsive">
                <table class="table table-light table-bordered mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th colspan="2" scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                    </tr>
                    </thead>
                    @foreach ($technique->subtechniques as $subtechnique)
                        <tr>
                            <td colspan="2">
                                <a href="{{ route('techniques_show', ['external_id' => $subtechnique->external_id]) }}">
                                    {{ $subtechnique->external_id }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('techniques_show', ['external_id' => $subtechnique->external_id]) }}">
                                    {{ $subtechnique->name }}
                                </a>
                            </td>
                            <td>@markdown($subtechnique->excerpt)</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif

@endsection
