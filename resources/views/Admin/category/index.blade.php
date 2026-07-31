@extends('admin.layout.app')
@push('css')
    <style>
        .row-checkbox {
            width: 18px;
            height: 18px;
        }

        .dropdown .dropdown-menu {
            padding: 0;
            border: 1px solid #ddd;
            box-shadow: 0px 0px 15px #00000030 !important;
        }

        .dropdown .dropdown-menu .dropdown-item {
            font-size: 16px;
            padding-block: 6px;
        }
        .dropdown .dropdown-menu li{
            border-bottom: 2px solid #ddd;
        }
        .dropdown .dropdown-menu li:last-child{
            border-bottom: 0;
        }

        .table thead th {
            background: #eeeeee75;
        }
        .table>thead{
            border-bottom: 2px solid #dddddd80;
        }
        .table>thead>tr>th,
        .table>tbody>tr>td
        {
            padding: 10px 15px !important;
        }

    </style>
@endpush

@section('content')
    <div class="card p-3">
        <div class="text-end mb-3">
            <button class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Add Category</button>
        </div>
        <table class="table table-bordered table-hover align-middle mb-0" id="categoryTable">
            <thead>
                <tr>
                    <th><input type="checkbox" class="form-check-input row-checkbox" data-id="1"></th>
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
                            <input type="checkbox" class="form-check-input row-checkbox" data-id="1">
                        </td>
                        <td>
                            <p class="mb-0">{{ $cate?->name }}</p>
                            <sub class="d-block text-muted small pt-1 pb-3">{{ '/' . $cate?->slug }}</sub>
                        </td>
                        <td>
                            {{ $cate?->parent_name }}
                        </td>
                        <td>
                            <input class="form-check-input switch switch-md" type="checkbox" role="switch"
                                {{ $cate?->is_active ? 'checked' : '' }}>
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="text-decoration-underline">None</a>
                            {{-- //TODO - Add a count of product --}}
                        </td>
                        <td>
                            IN hold
                        </td>
                        <td>
                            {{ format_date($cate?->updated_at, 'jS F Y') }}
                        </td>
                        <td>
                            <div class="dropdown text-center">
                                <button class="btn btn-sm btn-outline-secondary border-0" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                    <i class="fa-solid fa-ellipsis-vertical fs-6"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end"
                                    style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 31px);">
                                    <li>
                                        <a class="dropdown-item edit-action text-primary" href="#" data-id="1">
                                            <i class="fa-solid fa-pen me-2"></i> Edit
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <hr class="dropdown-divider">
                                    </li> --}}
                                    <li>
                                        <a class="dropdown-item text-danger delete-action" href="#" data-id="1">
                                            <i class="fa-solid fa-trash me-2"></i> Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
                {{-- <tr>
                    <td>
                        <input type="checkbox" class="form-check-input row-checkbox" data-id="1">
                    </td>
                    <td>
                        Name
                        <span class="d-block">Slug</span>
                    </td>
                    <td>P-Name</td>
                    <td>
                        <input class="form-check-input switch switch-md" type="checkbox" role="switch"
                            id="switchCheckDefault">
                    </td>
                    <td><a href="javascript:void(0)" class="">10</a></td>
                    <td>Ranking</td>
                    <td>date</td>
                    <td class="text-end">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary border-0" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end fs-3">
                                <li><a class="dropdown-item edit-action" href="#" data-id="1">
                                        <i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                <li>
                                    <a class="dropdown-item add-sub-action" href="#" data-id="1">
                                        <i class="fa-solid fa-plus me-2"></i>Add subcategory</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger delete-action" href="#" data-id="1">
                                        <i class="fa-solid fa-trash me-2"></i>
                                        Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr> --}}

            </tbody>
        </table>
    </div>
@endsection


@push('js')
@endpush
