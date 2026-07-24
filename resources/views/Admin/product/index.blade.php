@extends('admin.layout.app')

@section('content')
<div class="card p-3">

    <style>
        #productTable{ border-collapse: separate; border-spacing: 0; }
        #productTable td{ white-space: nowrap; vertical-align: middle; padding: 8px 10px; }
        #productTable td.cell-image{ text-align: center; }
        #productTable thead th{ position: sticky; top: 0; z-index: 4; background: #f8f9fa; padding: 0; }

        .col-pinned{ position: sticky; z-index: 3; background: #fff; }
        #productTable thead th.col-pinned{ z-index: 7; background: #eef1f4; }
        .col-pinned.col-pinned-last::after{
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            right: -6px;
            width: 6px;
            background: linear-gradient(to right, rgba(0,0,0,0.18), rgba(0,0,0,0));
            pointer-events: none;
        }

        .th-inner{ position: relative; display: flex; align-items: center; min-height: 38px; padding: 8px 30px; white-space: nowrap; }
        .col-name{ flex: 1; min-width: 0; }
        .no-sort .sort-btn{ display: none; }
        .no-sort .th-inner{ padding-right: 8px; }

        .pin-btn, .sort-btn{
            position: absolute; top: 50%; transform: translateY(-50%);
            width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;
            border: none; background: transparent; cursor: pointer; padding: 0; border-radius: 5px;
        }
        .pin-btn{ left: 3px; } .sort-btn{ right: 3px; }
        .pin-btn svg, .sort-btn svg{ width: 15px; height: 15px; display: block; }
        .pin-btn{ color: #adb5bd; }
        .pin-btn:hover{ color:#495057; background: rgba(0,0,0,.06); }
        .pin-btn.active{ color:#fd7e14; }
        .pin-btn.active svg{ fill: currentColor; fill-opacity: 0.18; }

        .pin-badge{
            position: absolute; top: -3px; right: -3px; min-width: 13px; height: 13px; padding: 0 2px;
            border-radius: 50%; background: #fd7e14; color: #fff; font-size: 9px; font-weight: 700;
            display: flex; align-items: center; justify-content: center; line-height: 1;
        }

        .sort-btn{ color: #c7cbd1; }
        .sort-btn:hover{ color: #495057; background: rgba(0,0,0,.06); }
        .sort-btn .arrow-up path, .sort-btn .arrow-down path{ stroke: currentColor; }
        .sort-btn.asc .arrow-up path{ stroke: #1a1d20; stroke-width: 2.4; }
        .sort-btn.asc .arrow-down path{ stroke: #c7cbd1; }
        .sort-btn.desc .arrow-down path{ stroke: #1a1d20; stroke-width: 2.4; }
        .sort-btn.desc .arrow-up path{ stroke: #c7cbd1; }

        .prod-avatar{
            width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 13px; margin: 0 auto;
        }
        .price-strike{ text-decoration: line-through; color: #9aa0a6; font-size: 12.5px; }
        .discount-value{ color: #1e7d34; font-weight: 600; }
        .discount-none{ color: #adb5bd; }
        .status-badge{ display: inline-block; padding: 2px 9px; border-radius: 999px; font-size: 11.5px; font-weight: 600; }
        .status-in-stock{ background: #e6f4ea; color: #1e7d34; }
        .status-low-stock{ background: #fff4e0; color: #b06b00; }
        .status-out-of-stock{ background: #fdecec; color: #c62828; }
        .status-discontinued{ background: #eceef0; color: #5f6368; }

        .date-badge{
            display: inline-block; margin-left: 6px; padding: 1px 7px; border-radius: 999px;
            font-size: 10.5px; font-weight: 700; vertical-align: middle; white-space: nowrap;
        }
        .badge-today{ background: #fdecec; color: #c62828; }
        .badge-yesterday{ background: #fff4e0; color: #b06b00; }
        .badge-thisweek{ background: #e7f0ff; color: #1a56db; }
        .badge-lastweek{ background: #eceef0; color: #5f6368; }
        .badge-thismonth{ background: #eef2ff; color: #4338ca; }
        .rating-value::after{ content: ' ★'; color: #f1a512; font-weight: 400; }
    </style>

    <h1>Products</h1>

    <div class="toolbar d-flex align-items-center gap-2 mb-2 flex-wrap">
        <button id="resetBtn" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-counterclockwise"></i> Reset pins
        </button>
        <span class="hint text-muted small ms-auto" id="colCountHint"></span>
    </div>

    {{--
        No JS-injected markup for headers anymore — the pin/sort buttons are
        real HTML below, rendered once via the loop over $columns.
        - Want a column NOT sortable? set 'sortable' => false (adds the
          no-sort class, which hides the sort button via CSS).
        - Want a cell to sort by something other than its visible text
          (e.g. a badge, "—", or a formatted price)? add data-sort="value" on the <td>.
        Column labels/order still just come from $columns — reorder that array
        to reorder columns, or add a row to add one.
    --}}
    @php
        $columns = [
            ['label' => 'Image',        'sortable' => false],
            ['label' => 'Product name', 'sortable' => true],
            ['label' => 'SKU',          'sortable' => true],
            ['label' => 'Category',     'sortable' => true],
            ['label' => 'Actual price', 'sortable' => true],
            ['label' => 'Discount',     'sortable' => true],
            ['label' => 'Price',        'sortable' => true],
            ['label' => 'Stock',        'sortable' => true],
            ['label' => 'Status',       'sortable' => true],
            ['label' => 'Launch date',  'sortable' => true],
            ['label' => 'Rating',       'sortable' => true],
        ];
    @endphp
    <div class="table-responsive" style="max-height:560px; overflow-y:auto;">
        <table class="table table-bordered table-hover align-middle mb-0" id="productTable">
            <thead>
                <tr>
                    @foreach ($columns as $col)
                        <th class="{{ $col['sortable'] ? '' : 'no-sort' }}">
                            <div class="th-inner">
                                <button type="button" class="pin-btn" title="Pin column">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="12" y1="17" x2="12" y2="22"></line>
                                        <path d="M5 17h14l-1.6-2.1a3 3 0 0 1-.6-1.8V9a5 5 0 0 0-10 0v4.1a3 3 0 0 1-.6 1.8L5 17z"></path>
                                    </svg>
                                </button>
                                <span class="col-name">{{ $col['label'] }}</span>
                                <button type="button" class="sort-btn" title="Sort">
                                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <g class="arrow-up"><path d="M7 20V4"></path><path d="M4 7l3-3 3 3"></path></g>
                                        <g class="arrow-down"><path d="M17 4v16"></path><path d="M20 17l-3 3-3-3"></path></g>
                                    </svg>
                                </button>
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php
                    $avatarColors = ['#6C5CE7','#00B894','#0984E3','#E17055','#D63031','#00998a','#e84393','#636e72','#0fb9b1','#eb4d4b'];
                    $products = [
                        ['name' => 'Aurora Backpack',     'sku' => 'SKU-A1B2C', 'category' => 'Outdoor',     'actual_price' => 89.99,  'discount' => 20, 'stock' => 142, 'status' => 'In stock',       'launch_date' => '2026-7-22', 'rating' => 4.6],
                        ['name' => 'Nimbus Water Bottle',  'sku' => 'SKU-D3E4F', 'category' => 'Accessories', 'actual_price' => 24.50,  'discount' => 0,  'stock' => 8,   'status' => 'Low stock',      'launch_date' => '2025-06-14', 'rating' => 4.2],
                        ['name' => 'Cobalt Desk Lamp',     'sku' => 'SKU-G5H6J', 'category' => 'Home',        'actual_price' => 54.00,  'discount' => 15, 'stock' => 0,   'status' => 'Out of stock',   'launch_date' => '2024-09-30', 'rating' => 3.9],
                        ['name' => 'Solstice Sneakers',    'sku' => 'SKU-K7L8M', 'category' => 'Apparel',      'actual_price' => 129.99, 'discount' => 30, 'stock' => 76,  'status' => 'In stock',       'launch_date' => '2026-01-18', 'rating' => 4.8],
                        ['name' => 'Voyager Duffel Bag',   'sku' => 'SKU-N9P1Q', 'category' => 'Outdoor',     'actual_price' => 74.25,  'discount' => 0,  'stock' => 220, 'status' => 'In stock',       'launch_date' => '2025-03-05', 'rating' => 4.1],
                        ['name' => 'Halcyon Headphones',   'sku' => 'SKU-R2S3T', 'category' => 'Electronics', 'actual_price' => 199.00, 'discount' => 25, 'stock' => 15,  'status' => 'Low stock',      'launch_date' => '2025-08-21', 'rating' => 4.7],
                        ['name' => 'Ember Camping Stove',  'sku' => 'SKU-U4V5W', 'category' => 'Outdoor',     'actual_price' => 63.40,  'discount' => 0,  'stock' => 5,   'status' => 'Discontinued',   'launch_date' => '2023-12-11', 'rating' => 3.5],
                        ['name' => 'Marble Notebook',      'sku' => 'SKU-X6Y7Z', 'category' => 'Home',        'actual_price' => 12.99,  'discount' => 10, 'stock' => 300, 'status' => 'In stock',       'launch_date' => '2025-10-09', 'rating' => 4.0],
                        ['name' => 'Drift Wireless Mouse', 'sku' => 'SKU-A8B9C', 'category' => 'Electronics', 'actual_price' => 39.99,  'discount' => 40, 'stock' => 60,  'status' => 'In stock',       'launch_date' => '2025-02-27', 'rating' => 4.4],
                        ['name' => 'Lumen Desk Fan',       'sku' => 'SKU-D1E2F', 'category' => 'Home',        'actual_price' => 45.00,  'discount' => 0,  'stock' => 0,   'status' => 'Out of stock',   'launch_date' => '2024-07-16', 'rating' => 3.8],
                        ['name' => 'Terra Ceramic Mug',    'sku' => 'SKU-G3H4J', 'category' => 'Home',        'actual_price' => 18.75,  'discount' => 0,  'stock' => 190, 'status' => 'In stock',       'launch_date' => '2026-02-01', 'rating' => 4.3],
                        ['name' => 'Zephyr Rain Jacket',   'sku' => 'SKU-K5L6M', 'category' => 'Apparel',      'actual_price' => 110.00, 'discount' => 20, 'stock' => 34,  'status' => 'In stock',       'launch_date' => '2025-05-19', 'rating' => 4.5],
                    ];
                    $statusClass = fn ($l) => 'status-' . strtolower(str_replace(' ', '-', $l));

                    // Short recency badge for a date. Returns null (no badge) once
                    // the date is older than the current month.
                    $dateBadge = function ($dateStr) {
                        $date  = \Carbon\Carbon::parse($dateStr)->startOfDay();
                        $today = \Carbon\Carbon::today();

                        if ($date->gt($today))                                  return null;
                        if ($date->eq($today))                                  return ['label' => 'Today',     'class' => 'badge-today'];
                        if ($date->eq($today->copy()->subDay()))                return ['label' => 'Yesterday', 'class' => 'badge-yesterday'];
                        if ($date->isSameWeek($today))                          return ['label' => 'This wk',   'class' => 'badge-thisweek'];
                        if ($date->isSameWeek($today->copy()->subWeek()))       return ['label' => 'Last wk',   'class' => 'badge-lastweek'];
                        if ($date->isSameMonth($today))                         return ['label' => 'This mo',   'class' => 'badge-thismonth'];

                        return null; // older than this month — no badge
                    };
                @endphp

                @foreach ($products as $i => $p)
                    @php
                        $discount = (int) $p['discount'];
                        $price = round($p['actual_price'] * (1 - $discount / 100), 2);
                    @endphp
                    <tr>
                        <td class="cell-image">
                            <div class="prod-avatar" style="background:{{ $avatarColors[$i % count($avatarColors)] }}">
                                {{ mb_substr($p['name'], 0, 1) }}
                            </div>
                        </td>
                        <td>{{ $p['name'] }}</td>
                        <td>{{ $p['sku'] }}</td>
                        <td>{{ $p['category'] }}</td>
                        <td>
                            @if ($discount > 0)
                                <span class="price-strike">${{ number_format($p['actual_price'], 2) }}</span>
                            @else
                                ${{ number_format($p['actual_price'], 2) }}
                            @endif
                        </td>
                        <td data-sort="{{ $discount }}">
                            @if ($discount > 0)
                                <span class="discount-value">-{{ $discount }}%</span>
                            @else
                                <span class="discount-none">—</span>
                            @endif
                        </td>
                        <td>${{ number_format($price, 2) }}</td>
                        <td>{{ $p['stock'] }}</td>
                        <td data-sort="{{ $p['status'] }}">
                            <span class="status-badge {{ $statusClass($p['status']) }}">{{ $p['status'] }}</span>
                        </td>
                        <td data-sort="{{ $p['launch_date'] }}">
                            {{ $p['launch_date'] }}
                            @if ($badge = $dateBadge($p['launch_date']))
                                <span class="date-badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="rating-value">{{ number_format($p['rating'], 1) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
$(function () {

    // =====================================================================
    // 1. CONFIG / STATE
    //    Everything the table "remembers" lives here. Nothing else in the
    //    file keeps its own copy of this data.
    // =====================================================================
    var $table  = $('#productTable');
    var pinned  = [];     // array of column indexes, in the order they were pinned
    var sortIdx = null;   // column index currently sorted, or null
    var sortAsc = true;   // sort direction for sortIdx


    // =====================================================================
    // 2. SETUP (runs once)
    //    Labels every <th>/<td> with a stable data-idx so all other
    //    functions can find "this column" reliably, even after reordering.
    //    The pin/sort buttons are already real HTML — nothing to inject.
    // =====================================================================
    function setup() {
        $table.find('thead th').each(function (i) {
            $(this).attr('data-idx', i);
            $table.find('tbody tr').each(function () { $(this).find('td').eq(i).attr('data-idx', i); });
        });
    }


    // =====================================================================
    // 3. COLUMN ORDER
    //    Works out what order the columns should be in: pinned columns
    //    first (in the order they were pinned), then everything else in
    //    its ORIGINAL order — this is what makes unpin/reset snap columns
    //    back to where they started.
    // =====================================================================
    function getColumnOrder() {
        var allIdx = $table.find('thead th').map(function () { return +$(this).data('idx'); }).get();
        var unpinned = allIdx
            .filter(function (i) { return pinned.indexOf(i) === -1; })
            .sort(function (a, b) { return a - b; });

        return pinned.concat(unpinned);
    }


    // =====================================================================
    // 4. RENDER
    //    Applies the current order + pin state to the DOM. Called after
    //    every pin toggle, sort, or reset. Split into small steps so each
    //    piece can be changed independently.
    // =====================================================================
    function render() {
        var order = getColumnOrder();
        moveColumnsIntoOrder(order);
        applyPinnedStyling(order);
        updatePinBadges();
        updateHint();
    }

    function moveColumnsIntoOrder(order) {
        order.forEach(function (idx) {
            $table.find('thead tr th[data-idx="' + idx + '"]').appendTo($table.find('thead tr'));
        });
        $table.find('tbody tr').each(function () {
            var $row = $(this);
            order.forEach(function (idx) {
                $row.find('td[data-idx="' + idx + '"]').appendTo($row);
            });
        });
    }

    function applyPinnedStyling(order) {
        $table.find('[data-idx]').removeClass('col-pinned col-pinned-last').css('left', '');

        var leftOffset = 0;
        order.forEach(function (idx, position) {
            if (position >= pinned.length) return; // not pinned, nothing to do

            $table.find('[data-idx="' + idx + '"]').addClass('col-pinned').css('left', leftOffset);
            leftOffset += $table.find('thead th[data-idx="' + idx + '"]').outerWidth();
        });

        if (pinned.length) {
            var lastPinnedIdx = order[pinned.length - 1];
            $table.find('[data-idx="' + lastPinnedIdx + '"]').addClass('col-pinned-last');
        }
    }

    function updatePinBadges() {
        $table.find('.pin-btn .pin-badge').remove();
        pinned.forEach(function (idx, position) {
            $table.find('th[data-idx="' + idx + '"] .pin-btn')
                  .append('<span class="pin-badge">' + (position + 1) + '</span>');
        });
    }

    function updateHint() {
        var count = $table.find('tbody tr').length;
        $('#colCountHint').text(count + ' products · ' + pinned.length + ' pinned');
    }


    // =====================================================================
    // 5. PIN
    // =====================================================================
    function togglePin($btn) {
        var idx = +$btn.closest('th').data('idx');
        var position = pinned.indexOf(idx);

        if (position === -1) pinned.push(idx);
        else pinned.splice(position, 1);

        $btn.toggleClass('active');
        render();
    }

    function resetPins() {
        pinned = [];
        $table.find('.pin-btn').removeClass('active');
        render();
    }


    // =====================================================================
    // 6. SORT
    //    getSortValue() decides what to compare for a cell (data-sort
    //    attribute wins, otherwise visible text). columnIsNumeric() checks
    //    every cell in a column to decide number vs text comparison.
    //    Change either of these if you need custom sorting logic.
    // =====================================================================
    function getSortValue(td) {
        return td.dataset.sort !== undefined ? td.dataset.sort : td.textContent.trim();
    }

    function toNumber(value) {
        return parseFloat(String(value).replace(/[$,%]/g, ''));
    }

    function columnIsNumeric(idx) {
        var cells = $table.find('tbody tr td[data-idx="' + idx + '"]').toArray();
        return cells.every(function (td) {
            var v = getSortValue(td);
            return v !== '' && !isNaN(toNumber(v));
        });
    }

    function sortByColumn(idx) {
        sortAsc = (sortIdx === idx) ? !sortAsc : true;
        sortIdx = idx;

        var numeric = columnIsNumeric(idx);
        var rows = $table.find('tbody tr').get().sort(function (rowA, rowB) {
            var cellA = $(rowA).find('td[data-idx="' + idx + '"]')[0];
            var cellB = $(rowB).find('td[data-idx="' + idx + '"]')[0];
            var a = getSortValue(cellA), b = getSortValue(cellB);
            var cmp = numeric ? (toNumber(a) - toNumber(b)) : a.localeCompare(b);
            return sortAsc ? cmp : -cmp;
        });

        $table.find('tbody').append(rows);
    }

    function updateSortButtonStyle($btn) {
        $table.find('.sort-btn').removeClass('asc desc');
        $btn.addClass(sortAsc ? 'asc' : 'desc');
    }


    // =====================================================================
    // 7. EVENTS
    // =====================================================================
    function bindEvents() {
        $table.on('click', '.pin-btn', function () { togglePin($(this)); });

        $table.on('click', '.sort-btn', function () {
            var idx = +$(this).closest('th').data('idx');
            sortByColumn(idx);
            updateSortButtonStyle($(this));
            render();
        });

        $('#resetBtn').on('click', resetPins);
    }


    // =====================================================================
    // 8. INIT
    // =====================================================================
    setup();
    bindEvents();
    render();
});
</script>
@endsection