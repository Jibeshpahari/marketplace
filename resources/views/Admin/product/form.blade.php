@extends('admin.layout.app')
@push('css')
    <style>
        .card {
            box-shadow: 1px 4px 15px 0px rgb(0 0 0 / 15%);
        }
    </style>
@endpush


@section('content')
    <div class="card p-4">
        <div class="row">
            <div class="col-8">
                <div class="card p-4 mb-3">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="name" class="form-label"> Product Name </label>
                            <input type="text" class="form-control" name="name" value="{{ '' }}"
                                id="name" placeholder="">
                            @error('name')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-12">
                            <label for="description" class="form-label"> Description </label>
                            <textarea class="form-control" id="description" name="description" rows="3">
                            </textarea>
                            @error('description')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-4">
                            <label class="field-label text-ink-3" for="priceInput">Price</label>
                            <div class="input-group">
                                <span class="input-group-text" aria-hidden="true">$</span>
                                <input type="number" name="priceInput" id="priceInput" class="form-control" min="0"
                                    step="0.01" value="1200.00" inputmode="decimal">
                            </div>
                        </div>

                        <div class="form-group col-4">
                            <label class="field-label text-ink-3" for="compareAtInput">Compare at</label>
                            <div class="input-group">
                                <span class="input-group-text" aria-hidden="true">$</span>
                                <input type="number" name="compareAtInput" id="compareAtInput" class="form-control"
                                    min="0" step="0.01" value="1200.00" inputmode="decimal">
                            </div>
                        </div>

                        <div class="form-group col-4">
                            <label class="field-label text-ink-3" for="priceInput">Cost per item</label>
                            <div class="input-group">
                                <span class="input-group-text" aria-hidden="true">$</span>
                                <input type="number" name="costInput" id="costInput" class="form-control" min="0"
                                    step="0.01" value="1200.00" inputmode="decimal">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input switch switch-md" type="checkbox" id="chargeTax" checked>
                                <label class="form-check-label" for="chargeTax">Charge tax for this product</label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card p-4">
                    <p class="fs-6 fw-semibold">Stock</p>
                    <div class="row">
                        <div class="form-group col-12">
                            <label class="field-label" for="onHandStockInput">On hand stock</label>
                            <input type="number" class="form-control" name="onHandStockInput" min="0" value="{{ '' }}"
                                id="onHandStockInput" placeholder="">
                            <button type="button" class="btn-outline-soft" id="reorderBtn" style="white-space:nowrap;">Reorder</button>
                            @error('onHandStockInput')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-2"></div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card p-3">
                    Total sales

                    $840.00
                    1.34% vs last month
                </div>
                <div class="card p-3">
                    <div class="card-header px-3 py-2">
                        <h5 class="m-0"> Product Organization </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="form-group">
                            <label for="sku" class="form-label">SKU </label>
                            <input type="text" class="form-control" name="sku" value="{{ '' }}"
                                id="sku" placeholder="">
                            @error('sku')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category" class="form-label">Category </label>
                            <select name="category" id="category" class="form-select">
                                <option value=""></option>
                            </select>
                            @error('category')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type" class="form-label">Type </label>
                            <select name="type" id="type" class="form-select" disabled>
                                <option value=""></option>
                            </select>
                            @error('type')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="vendor" class="form-label">Vendor </label>
                            <select name="vendor" id="vendor" class="form-select">
                                <option value=""></option>
                            </select>
                            @error('vendor')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- Row END -->
    </div> <!-- Master Card END -->
@endsection


@push('js')
@endpush
