@extends('admin.layout.app')

@push('css')
    <style>
        .row-checkbox {
            width: 18px;
            height: 18px;
        }

        .table thead th {
            background: #eeeeee75;
        }

        .table>thead {
            border-bottom: 2px solid #dddddd80;
        }

        .table>thead>tr>th,
        .table>tbody>tr>td {
            padding: 10px 12px !important;
        }

        .thumbnail-image {
            max-width: 52px;
            max-height: 52px;
            margin-right: 6px;
            align-self: center;
        }

        .product-name {
            font-size: 1.08rem;
            font-weight: 500;
            line-height: 1.55;
            margin: 0;
            max-width: 280px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-rating {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #222222;
            white-space: nowrap;
            padding: 1px 7px 0.5px 6px;
            border-radius: 25px;
            background: #ffc30035;
            border: 1px solid #ffc30080;
            display: inline-flex;
            align-items: center;
        }

        .product-rating i {
            color: #ffaa00;
            font-size: 10.5px;
            margin-right: 4px;
            text-shadow: 0px 0px 0px #000000;
        }

        .rating-divider {
            width: 100%;
            height: 1px;
            background: #d0d0d0;
            margin: 6px 0 2px;
            display: block;
        }

        .sku-txt {
            font-size: 13px;
            color: #777777;
            line-height: 2;
            font-weight: 600;
            max-width: 300px;
            white-space: wrap;
        }

        .category-badge {
            background: #e3f2fd;
            color: #1565c0;
            font-size: 12.5px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
            white-space: nowrap;
        }

        .variant-badge {
            background: #f3e5f5;
            color: #6a1b9a;
            font-size: 12.5px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
            white-space: nowrap;
        }

        .discount-chip {
            font-size: 12px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 5px;
            white-space: nowrap;
            background: #222222;
            color: #fff;
            display: inline-block;
            width: fit-content;
        }

        .price-val {
            font-size: 15.5px;
            font-weight: 700;
            white-space: nowrap;
        }

        .price-was {
            font-size: 12px;
            color: #454545;
            text-decoration: line-through;
            margin-left: 5px;
            font-weight: 500;
        }
    </style>
@endpush

@section('content')
    <div class="card p-3">

        <div class="card-header py-3 px-0 pt-0">
            <form action="" method="GET" class="" autocomplete="off">
                <div class="row">
                    <div class="col-2">
                        <select class="form-select" name="status" id="status">
                            <option value="" disabled selected hidden>Status</option>
                            <option value="approved">Approved</option>
                            <option value="pending_approval">Pending Approval</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <select class="form-select" name="date_sort" id="sort">
                            <option value="" disabled selected hidden>Sort By</option>
                            <option value="date_asc">Date (Oldest First)</option>
                            <option value="date_desc">Date (Newest First)</option>
                            <option value="name_asc">Name (A-Z)</option>
                            <option value="name_desc">Name (Z-A)</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <select class="form-select" name="category" id="category">
                            <option value="" disabled selected hidden>Category</option>
                            <option value="date_asc">Category 1</option>
                            <option value="date_desc">Category 2</option>
                            <option value="name_asc">Category 3</option>
                            <option value="name_desc">Category 4</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-secondary bg-secondary-gradient btn-sm">
                            <i class="fa-solid fa-filter me-1"></i>
                            Filter
                        </button>
                    </div>
                    <div class="col-2">

                    </div>
                    <div class="col-2">
                        <div class="text-end">
                            <a href="{{ route('admin.products.add') }}"
                                class="btn btn-primary bg-primary-gradient btn-sm">
                                <i class="fa-solid fa-plus me-1"></i>
                                Add Product
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body px-0 py-3">
            {{-- Bulk Select Bar --}}
            <div class="bg-dark text-white rounded-3 mb-3 bulk-bar d-flex justify-conent-between d-none" id="bulkBar">
                <div class="align-content-center">
                    <span class="me-auto fw-semibold bulk-count" id="bulkCount">9 selected</span>
                </div>
                <div class="btn-group ms-auto" role="group" aria-label="Bulk actions">
                    <button class="btn btn-sm btn-dark bulk-archive">
                        <i class="fa-solid fa-box-archive"></i> Archive
                    </button>
                    <button class="btn btn-sm btn-dark bulk-export">
                        <i class="fa-solid fa-file-export"></i> Export
                    </button>
                    <button class="btn btn-sm btn-danger bulk-delete">
                        <i class="fa-solid fa-trash"></i> Delete
                    </button>
                    <button class="btn btn-sm btn-link text-white text-decoration-underline" id="bulkClear"> Clear
                    </button>
                </div>

            </div>

            <table class="table table-hover align-middle mb-0" id="categoryTable">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="form-check-input row-checkbox" data-select-all=".row-checkbox">
                        </th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Rating</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="" data-id="Mac-5006">
                        <td>
                            <input type="checkbox" class="form-check-input row-checkbox">
                        </td>
                        <td>
                            <div class="d-flex align-items-start gap-2">
                                <img src="https://tse3.mm.bing.net/th/id/OIP.CvFx2otcDoNFsvaXMX1HWwHaHa?r=0&rs=1&pid=ImgDetMain&o=7&rm=3"
                                    alt="" class="thumbnail-image">

                                <div class="p-name-cell">
                                    <p class="product-name" title="Macbook Pro 14 Inch 512GB Space Grey">
                                        Macbook Pro 14 Inch 512GB Space Grey
                                    </p>
                                    <span class="sku-txt">SKU: Mac-5006006644</span>
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <span class="category-badge">Laptops</span>
                                        <span class="variant-badge">6 variants</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <div><span class="price-val">$220.00</span><span class="price-was">$249.00</span></div>
                                <span class="discount-chip">-12%</span>
                            </div>
                        </td>
                        <td>
                            <div class="stock-orders-cell d-flex flex-column gap-2">
                                <div class="d-flex flex-column gap-1">
                                    <span class="stock-info stock-high">210 in stock</span>
                                    <div class="stock-bar high"><i></i></div>
                                </div><span class="orders-line"><b>184</b> orders · 30d</span>
                            </div>
                        </td>
                        <td>
                            <span class="status-badge status-active d-inline-flex align-items-center gap-1"><span
                                    class="status-dot"></span>Active</span>
                        </td>
                        <td class="text-center">
                            <span class="product-rating"> <i class="fa-solid fa-star"></i> 4.8 </span>
                            <span class="rating-divider"></span>
                            <span class="review-count">1020</span>
                        </td>
                        <td>12 Jun 2025</td>
                        <td>
                            <div class="dropdown-options dropdown text-center">
                                <button class="do-kebab-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end do-menu">
                                    <li>
                                        <a class="do-item do-item--edit edit-action" href="{{ '' }}"
                                            data-id="1">
                                            <span class="do-badge do-badge--edit"><i class="fa-solid fa-pen"></i></span>
                                            <span>Edit</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="do-item do-item--amber flag-action" href="{{ '' }}">
                                            <span class="do-badge do-badge--amber"><i class="fa-solid fa-flag"></i></span>
                                            <span>Flag</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="do-divider"></div>
                                    </li>
                                    <li>
                                        <a class="do-item do-item--delete delete-action" href="{{ '' }}"
                                            data-id="1">
                                            <span class="do-badge do-badge--delete"><i
                                                    class="fa-solid fa-trash"></i></span>
                                            <span>Delete</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="card-footer py-3">
            @include('admin.layout.components.pagination', ['items' => $products])
        </div>
    </div>

    {{-- <div class="modal fade" id="subModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalParentName">Subcategories</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="w-100 table table-bordered table-hover align-middle mb-0" id="subTable"
                        data-edit-url-template="{{ route('admin.categories.edit', ':slug') }}">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th style="width:140px;">Products</th>
                                <th style="width:100px;">Status</th>
                                <th style="width:90px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="subTableBody">
                            <!-- spinner injected here on open, replaced once data arrives -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

{{-- 
@push('js')
    <script>
        $(document).on('click', '.sub-category-badge', function() {
            const slug = $(this).data('slug');
            const name = $(this).data('name');

            $('#modalParentName').text(name + ' — Subcategories');

            // show Bootstrap spinner while fetching
            $('#subTableBody').html(`
                <tr>
                    <td colspan="4" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </td>
                </tr>
            `);

            $.ajax({
                url: "{{ route('admin.categories.subcategories', ':slug') }}".replace(':slug', slug),
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    const $body = $('#subTableBody');
                    const editUrlTemplate = $('#subTable').data('edit-url-template');

                    if (!data.subcategories.length) {
                        $body.html(
                            `<tr><td colspan="4" class="text-center text-muted py-3">No subcategories found</td></tr>`
                        );
                        return;
                    }

                    const rows = data.subcategories.map(item => {
                        const editUrl = editUrlTemplate.replace(':slug', item.slug);

                        return `
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.products_count > 0 ? item.products_count + ' products' : '<span class="text-muted">None</span>'}</td>
                        <td>
                            <input class="form-check-input switch switch-sm" type="checkbox" role="switch"
                                data-bs-toggle="status" data-slug="${item.slug}"
                                ${item.is_active ? 'checked' : ''}>
                        </td>
                        <td class="text-center">
                            <a class="do-item do-item--edit edit-action" href="${editUrl}" data-slug="${item.slug}">
                                <span class="do-badge do-badge--edit"><i class="fa-solid fa-pen"></i></span>
                            </a>
                        </td>
                    </tr>
                `;
                    }).join('');

                    $body.html(rows);
                },
                error: function() {
                    $('#subTableBody').html(
                        `<tr><td colspan="4" class="text-center text-danger py-3">Failed to load subcategories</td></tr>`
                    );
                }
            });
        });

        $(document).on('change', '[data-bs-toggle="status"]', function() {
            let status = $(this).is(':checked') ? 1 : 0;
            let slug = $(this).data('slug');

            $.ajax({
                url: "{{ route('admin.categories.toggleStatus') }}",
                method: 'POST',
                dataType: 'json',
                data: {
                    slug,
                    status
                },
                success: function(data) {
                    if (data.success) {
                        notify('success', data.message, 'toast');
                    } else {
                        $toggle.prop('checked', !$toggle.is(':checked'));
                        notify('error', data.message, 'toast');
                    }
                },
                error: function(error) {
                    $toggle.prop('checked', !$toggle.is(':checked'));
                    notify('error', error.responseJSON?.message || 'Failed to update', 'toast');
                }
            });
        });

        $(function() {
            $('[data-select-all]').each(function() {
                const $master = $(this);
                const targetSelector = $master.data('select-all');
                const $scope = $master.closest('table').length ? $master.closest('table') : $(document);

                function updateState() {
                    const $rows = $scope.find(targetSelector);
                    const checkedCount = $rows.filter(':checked').length;

                    $master.prop('checked', $rows.length > 0 && checkedCount === $rows.length);
                    $master.prop('indeterminate', checkedCount > 0 && checkedCount < $rows.length);
                }

                $master.on('change', function() {
                    $scope.find(targetSelector).prop('checked', $master.is(':checked'));
                    updateState();
                });

                $scope.on('change', targetSelector, updateState);

                updateState();
            });
        });
    </script>
@endpush --}}


@push('css')
    <style>
        :root {
            --bg: #f3f3f4;
            --panel: #ffffff;
            --line: #e7e7e9;
            --text: #111113;
            --muted: #8b8b90;
            --ink: #111113;
            --ink-soft: #3a3a3d;
            --green: #1c9a63;
            --green-bg: #eaf6f0;
            --red: #c23b3b;
            --red-bg: rgba(194, 59, 59, 0.07);
            --red-soft: rgba(194, 59, 59, 0.55);
            --radius: 14px;
            --text: #111113;
            --muted: #8b8b90;
            --line: #e7e7e9;
            --bg: #f3f3f4;
            --green: #1c9a63;
        }

        .p-check {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: var(--ink);
        }

        .p-thumb {
            width: 38px;
            height: 38px;
            border-radius: 9px;
            background: #f2f2f3;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            font-size: 15px;
            flex-shrink: 0;
            overflow: hidden;
        }

        .p-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .p-rating-none {
            font-size: 11px;
            color: var(--muted);
            font-weight: 500;
            white-space: nowrap;
        }


        .meta-dot {
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: var(--line);
        }

        .cat-chip {
            background: #f3f3f4;
            color: #4b5563;
            font-size: 12px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
            white-space: nowrap;
        }

        .status-badge {
            font-weight: 600;
            font-size: 11.5px;
            white-space: nowrap;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-active {
            color: var(--green);
        }

        .status-active .status-dot {
            background: var(--green);
        }

        .status-draft {
            color: var(--muted);
        }

        .status-draft .status-dot {
            background: #9ca3af;
        }

        .status-archived {
            color: var(--red-soft);
        }

        .status-archived .status-dot {
            background: var(--red-soft);
        }

        .status-scheduled {
            color: #918ac5;
        }

        .status-scheduled .status-dot {
            background: #918ac5;
        }


        .stock-orders-cell {
            min-width: 110px;
        }

        .stock-info {
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .stock-high {
            color: var(--green);
        }

        .stock-low {
            color: #a6791f;
        }

        .stock-out {
            color: var(--red-soft);
        }

        .stock-bar {
            height: 4px;
            border-radius: 3px;
            background: var(--line);
            width: 80px;
            overflow: hidden;
        }

        .stock-bar i {
            display: block;
            height: 100%;
        }

        .stock-bar.high i {
            background: var(--green);
            width: 80%;
        }

        .stock-bar.low i {
            background: #c99a3d;
            width: 22%;
        }

        .stock-bar.out i {
            background: var(--red-soft);
            width: 100%;
            opacity: .5;
        }

        .orders-line {
            font-size: 11px;
            color: var(--muted);
            font-weight: 500;
            white-space: nowrap;
        }

        .orders-line b {
            color: var(--text);
            font-weight: 700;
        }

        .btn-view {
            border: 1px solid var(--line);
            background: #fff;
            color: var(--text);
            font-size: 12px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 7px;
        }

        .btn-view:hover {
            background: var(--text);
            color: #fff;
            border-color: var(--text);
        }

        .menu-wrap {
            position: relative;
        }

        .p-menu-btn {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            border: 1px solid var(--line);
            background: #fff;
            color: #4b5563;
            cursor: pointer;
        }

        .p-menu-btn:hover {
            background: var(--bg);
        }

        .p-menu-dd {
            display: none;
            position: absolute;
            right: 0;
            top: 34px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 10px;
            box-shadow: 0 10px 28px rgba(0, 0, 0, .10);
            min-width: 160px;
            z-index: 10;
            padding: 6px;
        }

        .p-menu-dd.show {
            display: block;
        }

        .p-menu-dd a {
            padding: 8px 10px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            text-decoration: none;
        }

        .p-menu-dd a:hover {
            background: var(--bg);
            color: var(--text);
        }

        .p-menu-dd a.danger {
            color: var(--red-soft);
        }

        .p-menu-dd a.danger:hover {
            background: var(--red-bg);
        }

        .p-menu-dd hr {
            margin: 5px 2px;
            border-color: var(--line);
        }

        .p-name-cell {
            /* max-width: 280px; */
        }


        .meta-dot {
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: var(--line);
        }


        .status-badge {
            font-weight: 600;
            font-size: 11.5px;
            white-space: nowrap;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-active {
            color: var(--green);
        }

        .status-active .status-dot {
            background: var(--green);
        }

        .status-draft {
            color: var(--muted);
        }

        .status-draft .status-dot {
            background: #9ca3af;
        }

        .status-scheduled {
            color: #918ac5;
        }

        .status-scheduled .status-dot {
            background: #918ac5;
        }

        .status-archived {
            color: var(--red-soft);
        }

        .status-archived .status-dot {
            background: var(--red-soft);
        }
    </style>
@endpush
