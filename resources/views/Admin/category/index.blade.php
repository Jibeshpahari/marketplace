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
            padding: 10px 15px !important;
        }

        .sub-category-badge {
            margin-left: auto;
            line-height: 1;
            padding: 4px 7px;
            vertical-align: middle;
            font-weight: 500;
            font-size: 11px;
            height: fit-content !important;
            border-radius: 50rem;
            background: #cfe2ff;
            color: #052c65;
            border: 1px solid #9ec5fe;
            margin-left: 8px;
            cursor: pointer;
        }

        .sub-category-badge:hover {
            background: #b6d4fe;
            border-color: #6ea8fe;
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
                        <input type="date" class="form-control datepicker" value="{{ request()->start_date }}"
                            name="start_date" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="Added From (Start Date)">
                    </div>
                    <div class="col-2">
                        <input type="date" class="form-control datepicker" value="{{ request()->end_date }}"
                            name="end_date" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="Added To (End Date)">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-secondary bg-secondary-gradient btn-sm">
                            <i class="fa-solid fa-filter me-1"></i>
                            Filter
                        </button>
                    </div>
                    <div class="col-2">
                        <div class="text-end">
                            <a href="{{ route('admin.categories.add') }}"
                                class="btn btn-primary bg-primary-gradient btn-sm">
                                <i class="fa-solid fa-plus me-1"></i>
                                Add Category
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body px-0 py-3">
            <div class="bg-dark text-white rounded-3 mb-3 bulk-bar d-flex justify-conent-between d-none" id="bulkBar">
                <div class="align-content-center">
                    <span class="me-auto fw-semibold" id="bulkCount">9 selected</span>
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

            <table class="table table-bordered table-hover align-middle mb-0" id="categoryTable">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="form-check-input row-checkbox" data-select-all=".row-checkbox">
                        </th>
                        <th>Category</th>
                        <th>Parent</th>
                        <th>Status</th>
                        <th>Products</th>
                        <th>Order</th>
                        <th>Modified At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $cate)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input row-checkbox">
                            </td>
                            <td>
                                <p class="mb-0">
                                    {{ $cate?->name }}
                                    @if (!$cate?->parent_name)
                                        <span class="sub-category-badge" data-bs-toggle="modal" data-bs-target="#subModal"
                                            data-slug="{{ $cate->slug }}" data-name="{{ $cate->name }}">
                                            <i class="fa fa-layer-group"></i> {{ count($cate->children) }}
                                        </span>
                                    @endif
                                </p>
                                <sub class="d-block text-muted small pt-1 pb-3">{{ '/' . $cate?->slug }}</sub>
                            </td>
                            <td>
                                {{ $cate?->parent_name ?? '--' }}
                            </td>
                            <td>
                                <input class="form-check-input switch switch-md" type="checkbox" role="switch"
                                    data-bs-toggle="status" data-slug="{{ $cate?->slug ?? '' }}"
                                    {{ $cate?->is_active ? 'checked' : '' }}>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="text-decoration-underline">None</a>
                                {{-- //TODO - Add a count of product --}}
                            </td>
                            <td>
                                In hold
                            </td>
                            <td>
                                {{ format_date($cate?->updated_at, 'jS F Y') }}
                            </td>
                            <td>
                                <div class="dropdown-options dropdown text-center">
                                    <button class="do-kebab-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end do-menu">
                                        <li>
                                            <a class="do-item do-item--edit edit-action"
                                                href="{{ route('admin.categories.edit', $cate) }}" data-id="1">
                                                <span class="do-badge do-badge--edit"><i class="fa-solid fa-pen"></i></span>
                                                <span>Edit</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="do-item edit-action" href="#" data-id="1">
                                                <span class="do-badge do-badge--edit"><i
                                                        class="fa-solid fa-pen"></i></span>
                                                <span>Edit</span>
                                                {{-- #eff4ff --}}
                                            </a>
                                        </li>
                                        <li>
                                            <div class="do-divider"></div>
                                        </li>
                                        <li>
                                            <a class="do-item do-item--delete delete-action"
                                                href="{{ route('admin.categories.delete', $cate) }}" data-id="1">
                                                <span class="do-badge do-badge--delete"><i
                                                        class="fa-solid fa-trash"></i></span>
                                                <span>Delete</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer py-3">
            @include('admin.layout.components.pagination', ['items' => $categories])
        </div>
    </div>

    <div class="modal fade" id="subModal" tabindex="-1" aria-hidden="true">
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
    </div>
@endsection


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
                const $bulkBar = $('#bulkBar');

                function updateState() {
                    const $rows = $scope.find(targetSelector);
                    const checkedCount = $rows.filter(':checked').length;

                    $master.prop('checked', $rows.length > 0 && checkedCount === $rows.length);
                    $master.prop('indeterminate', checkedCount > 0 && checkedCount < $rows.length);

                    // Show bulkBar if at least one row is checked, hide if none
                    $bulkBar.toggleClass('d-none', checkedCount === 0);
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
@endpush
