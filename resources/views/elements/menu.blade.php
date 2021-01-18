<div class="list-group">
    @foreach ($globalTactics as $globalTactic)
        <a href="{{ route('tactics_show', ['external_id' => $globalTactic->external_id]) }}"
           class="list-group-item list-group-item-action">
            {{ $globalTactic->name }}
        </a>
    @endforeach
</div>
