@extends('admin.layout.app')

@push('css')
    <style>
        .form-select-lg {
            padding-top: .6rem;
            padding-bottom: .6rem;
            padding-left: 1rem;
            font-size: 1rem;
            border-width: 2px;
            border-radius: var(--bs-border-radius-lg);
            border-color: #ebedf2;
        }
    </style>
@endpush

@section('content')
    <div class="card p-3">
        <div class="card-header"></div>
        <div class="card-body">

            <form action="">

                <p class="fs-4">
                    Basic information
                    <i class="bi bi-info-circle text-dark fs-6" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Shared across every variant of this product.">
                    </i>
                </p>

                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name" class="form-label"> Product Name </label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="slug" class="form-label"> Slug </label>
                            <input type="text" class="form-control" name="slug" id="slug">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="brand" class="form-label"> Brand </label>
                            <select class="form-select form-select-lg" aria-label="Default select example" id="brand">
                                <option selected>Choose Brand</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                Description
                            </label>
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category" class="form-label"> Category </label>
                            <select class="form-select form-select-lg" id="category">
                                <option selected>Choose Brand</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="weight" class="form-label"> Weight </label>
                            <input type="text" class="form-control" name="weight" id="weight">
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
