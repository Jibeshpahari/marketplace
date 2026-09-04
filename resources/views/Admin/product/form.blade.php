@extends('admin.layout.app')



@section('content')
    <div class="row g-3">
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

                    <div class="form-group col-6">
                        <label class="field-label text-ink-3" for="priceInput">Price</label>
                        <div class="input-group">
                            <span class="input-group-text" aria-hidden="true">$</span>
                            <input type="number" name="priceInput" id="priceInput" class="form-control" min="0"
                                step="0.01" value="1200.00" inputmode="decimal">
                        </div>
                    </div>

                    <div class="form-group col-6">
                        <label class="field-label text-ink-3" for="compareAtInput">Compare at</label>
                        <div class="input-group">
                            <span class="input-group-text" aria-hidden="true">$</span>
                            <input type="number" name="compareAtInput" id="compareAtInput" class="form-control"
                                min="0" step="0.01" value="1200.00" inputmode="decimal">
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

            <div class="card p-4 mb-3">
                <p class="fs-6 fw-semibold ">Varients</p>
                <div class="row g-0 border p-3 rounded-3 align-items-center">

                    <!-- Image -->
                    <div class="col-2">
                        <button type="button" class="add-image img-picker-trigger" id="galleryAddImageBtn">
                            <i class="fa-regular fa-image" aria-hidden="true"></i>
                            <i class="lni lni-gallery"></i>
                        </button>
                    </div>

                    <!-- Variant Fields -->
                    <div class="col-9">
                        <div class="row">

                            <!-- Variant Type -->
                            <div class="col-md-4 form-group">
                                <label class="field-label" for="variantType-1">
                                    Variant type
                                </label>

                                <select class="form-select variant-type-select" id="variantType-1">
                                    <option value="Color">Color</option>
                                    <option value="SSD Size">SSD Size</option>
                                    <option value="RAM">RAM</option>
                                    <option value="Size">Size</option>
                                    <option value="Material">Material</option>
                                </select>
                            </div>

                            <!-- Variant Value -->
                            <div class="col-md-8 form-group">
                                <label class="field-label">
                                    Variant value
                                </label>

                                <select class="form-select" data-select="tag" id="my-multiselect">
                                    <option value="html">Variant value - 1</option>
                                    <option value="css">Variant value - 2</option>
                                    <option value="js">Variant value - 3</option>
                                    <option value="php">Variant value - 4</option>
                                    <option value="wp">Variant value - 5</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Button -->
                    <div class="col-1 pt-4 ps-4">
                        <button type="button" class="btn mt-2 btn-outline-danger d-flex py-2 px-1 align-content-center justify-content-center rounded-3" title="Delete variant" aria-label="Delete variant">
                            <i class="fa-solid fa-trash fs-5"></i>
                        </button>
                    </div>

                </div>
                <div class="btn btn-secondary col-md-12 mt-2">
                    <i class="fa-solid fa-plus"></i> Add Another Variation
                </div>
            </div>

            <div class="card p-4 mb-3">
                <p class="fs-6 fw-semibold ">Shipping</p>
                <div class="ship-type-row" role="radiogroup" aria-label="Product shipping type" id="shipTypeRow">
                    <input type="radio" name="ship_type" id="physicalProductBtn" value="physical"
                        class="ship-type-input" checked>
                    <label for="physicalProductBtn" class="ship-type-btn">
                        <i class="fa-solid fa-shirt" aria-hidden="true"></i>
                        <span>Physical product</span>
                    </label>

                    <input type="radio" name="ship_type" id="digitalProductBtn" value="digital"
                        class="ship-type-input">
                    <label for="digitalProductBtn" class="ship-type-btn">
                        <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                        <span>Digital product</span>
                    </label>
                </div>

                <div class="py-3 row mb-3" id="shippingDetailsBox">
                    <div class="form-group col-md-6">
                        <label class="field-label" for="weightInput">Weight</label>
                        <input type="number" min="0" step="0.1" inputmode="decimal" id="weightInput"
                            class="form-control" value="5">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="field-label" for="weightUnitSelect">Unit</label>
                        <select class="form-select" id="weightUnitSelect">
                            <option>Kilogram (kg)</option>
                            <option>Gram (g)</option>
                            <option>Pound (lb)</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="field-label text-ink-3" style="font-weight:500;" for="lengthInput">Length</label>
                        <input type="number" min="0" inputmode="decimal" id="lengthInput" class="form-control"
                            value="40">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="field-label text-ink-3" style="font-weight:500;" for="widthInput">Width</label>
                        <input type="number" min="0" inputmode="decimal" id="widthInput" class="form-control"
                            value="30">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="field-label text-ink-3" style="font-weight:500;" for="heightInput">Height</label>
                        <input type="number" min="0" inputmode="decimal" id="heightInput" class="form-control"
                            value="20">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="field-label text-ink-3" style="font-weight:500;"
                            for="dimensionUnitSelect">Unit</label>
                        <select class="form-select" id="dimensionUnitSelect">
                            <option>Centimeter (cm)</option>
                            <option>Meter (m)</option>
                            <option>Inch (in)</option>
                        </select>
                    </div>
                </div>

                <div class="alert alert-primary mt-2 p-3 d-none" id="digitalShippingFields">
                    Digital products don't need weight or dimensions — customers get access right after purchase, with
                    nothing to ship.
                </div>

            </div>

        </div>

        <div class="col-4">
            <div class="card p-4 mb-3 d-none">
                Total sales

                $840.00
                1.34% vs last month
            </div>

            <div class="card p-4 mb-3">
                <p class="fs-6 fw-semibold ">Stock</p>
                <div class="form-group col-12 px-0">
                    <label class="field-label" for="onHandStockInput">On hand stock</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="onHandStockInput" min="0"
                            value="" id="onHandStockInput" placeholder="">
                        <button type="button" class="btn btn-dark" id="reorderBtn"
                            style="white-space:nowrap;">Reorder</button>
                    </div>
                    <div class="form-check ps-0">
                        <input class="form-check-input check-black" type="checkbox" id="continueSellingCheck"
                            checked="">
                        <label class="form-check-label me-0" for="continueSellingCheck">Continue selling when out of
                            stock</label>
                    </div>
                </div>
            </div>

            <div class="card p-4">
                <p class="fs-6 fw-semibold ">Product Organization</p>
                <div class="card-body p-0">
                    <div class="form-group px-0">
                        <label for="sku" class="form-label">SKU </label>
                        <input type="text" class="form-control" name="sku" value="{{ '' }}"
                            id="sku" placeholder="">
                        @error('sku')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <span
                            class="ms-1 d-inline-flex align-items-center justify-content-center rounded-circle bg-dark text-white"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="custom made by me"
                            style="width: 16px; height: 16px; font-size: 11px; cursor: help;">i</span>

                    </div>
                    <div class="form-group px-0">
                        <label for="category" class="form-label">Category </label>
                        <select name="category" id="category" class="form-select">
                            <option value=""></option>
                        </select>
                        @error('category')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group px-0">
                        <label for="type" class="form-label">Type </label>
                        <select name="type" id="type" class="form-select" disabled>
                            <option value=""></option>
                        </select>
                        @error('type')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group px-0">
                        <label for="vendor" class="form-label">Vendor </label>
                        <select name="vendor" id="vendor" class="form-select">
                            <option value=""></option>
                        </select>
                        @error('vendor')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group px-0">
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

        <div class="col-md-12 mt-0">
            <div class="card p-4 mb-3 notes-card">
                <div id="summernote"></div>
                <div class="mt-3 text-end">
                    <button type="button" id="submitNoteBtn" class="btn btn-dark btn-sm">Submit</button>
                </div>
                <div id="summernote-result"></div>
            </div>
        </div>



        <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>

    </div> <!-- Row END -->
@endsection

{{-- Tag CSS --}}
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

        .select2-container--default .select2-selection--multiple.select2-selection--clearable {}
    </style>
@endpush
@push('js')
    <script>
        $(function() {
            $('input[name="ship_type"]').on('change', function() {
                $('#shippingDetailsBox').toggleClass('d-none', this.value === 'digital');
                $('#digitalShippingFields').toggleClass('d-none', this.value === 'physical');
            }).filter(':checked').trigger('change');
        });

        $('#summernote').summernote({
            placeholder: 'Write Here',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['font', ['bold', 'italic', 'underline',
                    'clear'
                ]], // bold, italic, underline, remove formatting
                ['color', []], // text/background color
                ['insert', ['link', 'picture']], // link + image only (video removed)
                ['view', ['codeview']] // code view (fullscreen + help removed)
            ]
        });

        $('#submitNoteBtn').on('click', function() {
            if ($('#summernote').summernote('isEmpty')) {
                return;
            }

            let content = $('#summernote').summernote('code');
            const temp = $('<div>').html(content);

            temp.find('img').each(function() {
                const src = $(this).attr('src');
                const iconLink = $('<a>')
                    .attr('href', src)
                    .attr('target', '_blank')
                    .attr('rel', 'noopener noreferrer')
                    .addClass('text-secondary')
                    .html('<i class="fa-solid fa-image"></i> View image');

                $(this).replaceWith(iconLink);
            });

            content = temp.html();
            $('#summernote-result').html(content);

            $('#summernote').summernote('reset');
        });
    </script>
@endpush


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

        .form-select {
            padding: .6rem 1rem;
            border: 2px solid #dee2e6;
        }

        .ship-type-row {
            display: flex;
            gap: 5px;
            width: 400px;
            max-width: 100%;
            padding: 1px;
            background: #EFEFEF;
            border: 1px solid #dddddd;
            border-radius: 6px;
        }

        .ship-type-input {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .ship-type-btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px;
            border: 1px solid transparent;
            border-radius: 5px;
            background: transparent;
            color: #777d86;
            font: inherit;
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            cursor: pointer;
            transition: color .2s ease, background .2s ease, box-shadow .2s ease, border-color .2s ease;
        }

        .ship-type-btn i {
            font-size: 15px;
            color: #8b9097;
            transition: color .2s ease;
        }

        .ship-type-btn:hover {
            color: #353a42;
        }

        .ship-type-btn:hover i {
            color: #555b63;
        }

        .ship-type-input:checked+.ship-type-btn {
            background: #ffffff;
            color: #111;
            border-color: #d7d9db;
            box-shadow: 0 0px 6px rgb(0 0 0 / 20%);
        }

        .ship-type-input:checked+.ship-type-btn i {
            color: #2563eb;
        }

        .ship-type-input:focus-visible+.ship-type-btn {
            outline: 2px solid rgba(0, 0, 0, .18);
            outline-offset: 2px;
        }

        @media (max-width: 600px) {
            .ship-type-row {
                width: calc(100% - 30px);
            }

            .ship-type-btn {
                padding: 11px 8px;
                font-size: 13px;
            }
        }

        #summernote p {
            margin-bottom: 0;
        }

        button.add-image {
            font-family: 'Inter', sans-serif;
            width: 82px;
            height: 82px;
            border-radius: 8px;
            border: 1px dashed #454545;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            color: #454545;
            font-size: 25px;
            font-weight: 600;
            cursor: pointer;
            background: var(--accent-soft);
            transition: .15s;
        }

        button.add-image:hover {
            background: #f1f1f1;
        }

        button.add-image:focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
            border-radius: 8px;
        }
    </style>
@endpush
