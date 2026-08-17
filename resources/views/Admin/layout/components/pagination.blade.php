@php
    $currentPage = $items->currentPage();
    $lastPage = $items->lastPage();
    $elements = [];

    if ($lastPage < 6) {
        for ($p = 1; $p <= $lastPage; $p++) {
            $elements[] = ['type' => 'page', 'page' => $p, 'active' => $p === $currentPage];
        }
    } else {
        $pageCutLow = $currentPage - 1;
        $pageCutHigh = $currentPage + 1;

        if ($currentPage > 2) {
            $elements[] = ['type' => 'page', 'page' => 1, 'active' => false];
            if ($currentPage > 3) {
                $elements[] = ['type' => 'ellipsis'];
            }
        }

        if ($currentPage === 1) {
            $pageCutHigh += 2;
        } elseif ($currentPage === 2) {
            $pageCutHigh += 1;
        }

        if ($currentPage === $lastPage) {
            $pageCutLow -= 2;
        } elseif ($currentPage === $lastPage - 1) {
            $pageCutLow -= 1;
        }

        for ($p = $pageCutLow; $p <= $pageCutHigh; $p++) {
            if ($p < 1 || $p > $lastPage) {
                continue;
            }
            $elements[] = ['type' => 'page', 'page' => $p, 'active' => $p === $currentPage];
        }

        if ($currentPage < $lastPage - 1) {
            if ($currentPage < $lastPage - 2) {
                $elements[] = ['type' => 'ellipsis'];
            }
            $elements[] = ['type' => 'page', 'page' => $lastPage, 'active' => false];
        }
    }

    $queryParams = request()->except('page');
@endphp

@if ($lastPage > 1)
    <div class="row align-items-center pagination-wrap">
        <div class="col-md-3">
            <p class="mb-0 small">
                Total: {{ $items->total() }} |
                Showing: {{ $items->firstItem() }} &ndash; {{ $items->lastItem() }}
            </p>
        </div>

        <div class="col-md-7">
            <nav class="page-navigation" aria-label="Page navigation">
                <div class="pagination-row">
                    @if ($items->onFirstPage())
                        <button class="pagination-btn pagination-nav-btn" disabled aria-label="Previous page">
                            <i class="fas fa-chevron-left"></i>&nbsp;Back
                        </button>
                    @else
                        <a href="{{ $items->appends($queryParams)->previousPageUrl() }}"
                           class="pagination-btn pagination-nav-btn" rel="prev" aria-label="Previous page">
                            <i class="fas fa-chevron-left"></i>&nbsp;Back
                        </a>
                    @endif

                    @foreach ($elements as $item)
                        @if ($item['type'] === 'ellipsis')
                            <span class="pagination-ellipsis">&bull;&bull;&bull;</span>
                        @elseif ($item['active'])
                            <button class="pagination-btn active" aria-current="page">{{ $item['page'] }}</button>
                        @else
                            <a href="{{ $items->appends($queryParams)->url($item['page']) }}"
                               class="pagination-btn">{{ $item['page'] }}</a>
                        @endif
                    @endforeach

                    @if ($items->hasMorePages())
                        <a href="{{ $items->appends($queryParams)->nextPageUrl() }}"
                           class="pagination-btn pagination-nav-btn" rel="next" aria-label="Next page">
                            Next&nbsp;<i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <button class="pagination-btn pagination-nav-btn" disabled aria-label="Next page">
                            Next&nbsp;<i class="fas fa-chevron-right"></i>
                        </button>
                    @endif
                </div>
            </nav>
        </div>

        <div class="col-md-2 text-end">
            <label for="per_page" class="form-label small mb-0">Per Page</label>
            <select id="per_page" class="form-select form-select-sm d-inline-block w-auto" onchange="pgChangePerPage(this)">
                @foreach ([5, 10, 20, 25, 50] as $option)
                    <option value="{{ $option }}" @selected($items->perPage() == $option)>{{ $option }}</option>
                @endforeach
            </select>
        </div>
    </div>
@endif

@once
    <script>
        function pgChangePerPage(selectEl) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', selectEl.value);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }
    </script>
@endonce