@extends('admin.layout.app')
@push('css')
    <style>
        .card {
            box-shadow: 1px 4px 15px 0px rgb(0 0 0 / 15%);
            border-radius: 5px;
        }

        .check-black[type=checkbox],
        .check-black[type=checkbox] {
            border-color: #bbb;
            background-color: #efefef;
            width: 1.22rem;
            height: 1.22rem;
            letter-spacing: 0px;
            word-spacing: 0px;
            /* margin-top: 2px; */
        }

        .check-black[type="checkbox"]:checked,
        .check-black[type="checkbox"]:indeterminate {
            background-color: #111111;
            border-color: #111111;
        }
    </style>
@endpush


@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card p-4 mb-3">
                <p class="fs-6 fw-semibold">Product Details</p>
                <div class="row">
                    <div class="form-group col-12">
                        <label for="name" class="form-label"> Product Name </label>
                        <input type="text" class="form-control" name="name" value="{{ '' }}" id="name"
                            placeholder="">
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
                        <div class="form-check ps-0">
                            <input class="form-check-input check-black" type="checkbox" id="chargeTax" checked>
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
                        <div class="input-group">
                            <input type="number" class="form-control" name="onHandStockInput" min="0"
                                value="{{ '' }}" id="onHandStockInput" placeholder="">
                            <button type="button" class="btn btn-dark" id="reorderBtn"
                                style="white-space:nowrap;">Reorder</button>
                        </div>
                        <div class="form-check ps-0">
                            <input class="form-check-input check-black" type="checkbox" id="continueSellingCheck"
                                checked="">
                            <label class="form-check-label" for="continueSellingCheck">Continue selling when out of
                                stock</label>
                        </div>
                        @error('onHandStockInput')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card p-4">
                <p class="fs-6 fw-semibold ">Varients</p>
                <div class="row">
                    <div class="col-md-4">
                        <label class="field-label" for="variantType-1">Variant type</label>
                        <select class="form-select variant-type-select" id="variantType-1">
                            <option value="Color">Color</option>
                            <option value="SSD Size">SSD Size</option>
                            <option value="RAM">RAM</option>
                            <option value="Size">Size</option>
                            <option value="Material">Material</option>
                        </select>
                    </div>
                    <div class="col-8">
                        <label class="field-label">Variant value</label>
                        <select class="form-select" data-select="tag" id="my-multiselect" multiple="multiple">
                            <option value="html">HTML</option>
                            <option value="css">CSS</option>
                            <option value="js">JavaScript</option>
                            <option value="php">PHP</option>
                            <option value="wp">WordPress</option>
                        </select>
                    </div>
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
@endsection

@push('css')
    <style>
        /* === Improved Select2 multi-select tags, remove button on the right (B&W theme v2) === */

        .select2-container--default .select2-selection--multiple .select2-selection__choice.select2-selection__choice {
            display: inline-flex;
            align-items: center;
            background-color: #1a1a1a;
            border: 1px solid #1a1a1a;
            border-radius: 6px;
            padding: 0;
            padding-left: 5px;
            /* text side */
            padding-right: 0;
            /* remove button sits here instead */
            margin: 4px 0 0 6px;
            font-size: 14px;
            font-weight: 500;
            line-height: 24px;
            color: #fff;
            transition: background-color 0.15s ease, border-color 0.15s ease;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice.select2-selection__choice:hover {
            background-color: #333;
            border-color: #333;
        }

        /* Text label */
        .select2-container--default .select2-selection--multiple .select2-selection__choice__display.select2-selection__choice__display {
            padding-left: 4px;
            padding-right: 6px;
            color: inherit;
            font-weight: 500;
        }

        /* Remove button — moved to the right */
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove.select2-selection__choice__remove {
            position: static;
            /* cancel the original absolute/left:0 positioning */
            left: auto;
            order: 2;
            /* push after the text in the flex row */
            border: none;
            border-left: 1px solid rgba(255, 255, 255, 0.25);
            border-right: none;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
            padding: 0 5px;
            color: #fff;
            background-color: transparent;
            font-weight: 500;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove.select2-selection__choice__remove:hover,
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove.select2-selection__choice__remove:focus {
            background-color: #fff;
            color: #000;
            outline: none;
        }

        /* RTL override was flipping things back — cancel it so LTR right-side stays right */
        .select2-container--default[dir=rtl] .select2-selection--multiple .select2-selection__choice.select2-selection__choice {
            padding-left: 10px;
            padding-right: 0;
            margin-left: 6px;
            margin-right: 0;
        }
        .select2-container--default .select2-selection--multiple.select2-selection--clearable{
            
        }
    </style>
@endpush
@push('js')
    <script>
        jQuery(document).ready(function($) {
            $('[data-select="tag"]').each(function() {
                var $el = $(this);
                if ($el.hasClass('select2-hidden-accessible')) {
                    $el.select2('destroy');
                }
            }).select2({
                allowClear: true,
                width: '100%',
                placeholder: 'Select options'
            });
        });
    </script>
@endpush
