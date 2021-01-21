<form action="{{ route('search') }}" method="GET" class="mb-0">
    <div class="input-group mb-0">
        <input type="search" name="query" class="form-control" placeholder="Search..." aria-label="Search input" minlength="3">
        <div class="input-group-append">
            <button class="btn btn-outline-dark" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</form>
