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

        .dropdown .dropdown-menu li {
            border-bottom: 2px solid #ddd;
        }

        .dropdown .dropdown-menu li:last-child {
            border-bottom: 0;
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
    </style>
@endpush

@section('content')
    <div class="card p-3">
        <form action="" class="">
            <div class="row">
                <div class="form-group col">
                    <label for="name" class="form-label"> Product Name </label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
            </div>
        </form>
    </div>
@endsection


@push('js')
@endpush
