@extends('admin.layout.app')
@push('css')
    <!-- Select2 (only needed if KaiAdmin doesn't already bundle it — remove if it does) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css">

    <style>
        /* ---------- Shared with categories page ---------- */
        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #dee2e6;
            border-radius: .375rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
            padding-left: 12px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
        }

        .select2-results__option {
            padding: 10px 16px !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #5ea3e4 !important;
        }

        .status-toggle-button {
            padding: 0.745rem 0.875rem;
            border-radius: 0;
            width: 110px;
        }

        .status-toggle {
            border-radius: 0.375rem;
            overflow: auto;
            padding: 0;
            gap: 0;
            display: flex;
        }

        /* ---------- Product-specific ---------- */
        .stat-row {
            display: flex;
            gap: 16px;
            margin-top: 14px;
            flex-wrap: wrap;
        }

        .stat-box {
            flex: 1;
            min-width: 140px;
            background: #f8f9fe;
            border: 1px solid #edf0f7;
            border-radius: .5rem;
            padding: 12px 14px;
        }

        .stat-box .label {
            font-size: 11.5px;
            font-weight: 600;
            color: #8898aa;
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        .stat-box .value {
            font-size: 18px;
            font-weight: 700;
            color: #172b4d;
            margin-top: 2px;
        }

        .field-hint {
            font-size: 11.5px;
            color: #8898aa;
            margin-top: 4px;
        }

        .field-hint.warn {
            color: #f5365c;
            display: none;
        }

        .field-hint.warn.show {
            display: block;
        }

        /* Gallery */
        .gallery-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .gallery-thumb {
            position: relative;
            width: 96px;
            height: 96px;
            border-radius: .5rem;
            overflow: hidden;
            border: 1px solid #dee2e6;
        }

        .gallery-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .gallery-thumb .remove-thumb {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 22px;
            height: 22px;
            border: none;
            border-radius: 50%;
            background: rgba(23, 43, 77, .75);
            color: #fff;
            font-size: 12px;
            line-height: 1;
            cursor: pointer;
        }

        .gallery-add {
            width: 96px;
            height: 96px;
            border: 1.5px dashed #dee2e6;
            border-radius: .5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            color: #8898aa;
            cursor: pointer;
            background: transparent;
        }

        .gallery-add:hover {
            border-color: #5ea3e4;
            color: #5ea3e4;
        }

        /* Variant blocks (inside modal) */
        .variant-block {
            border: 1px solid #edf0f7;
            border-radius: .5rem;
            padding: 16px;
            margin-bottom: 14px;
            position: relative;
        }

        .variant-block.duplicate-type {
            border-color: #f5365c;
            background: rgba(245, 54, 92, .04);
        }

        .vb-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .vb-head h6 {
            margin: 0;
            font-size: 13px;
            font-weight: 700;
        }

        .vb-remove {
            border: none;
            background: transparent;
            color: #f5365c;
            font-size: 13px;
        }

        .tag-input {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            border: 1px solid #dee2e6;
            border-radius: .375rem;
            padding: 6px 8px;
            min-height: 38px;
            align-items: center;
        }

        .tag-input input {
            border: none;
            outline: none;
            flex: 1;
            min-width: 120px;
            font-size: 13px;
        }

        .tag-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eef1fb;
            color: #344767;
            font-size: 12.5px;
            font-weight: 600;
            padding: 4px 6px 4px 10px;
            border-radius: 20px;
        }

        .tag-chip .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .tag-chip button {
            border: none;
            background: transparent;
            font-size: 10px;
            color: #8898aa;
            cursor: pointer;
        }

        .tag-chip button:hover {
            color: #f5365c;
        }

        .variant-image-cell {
            width: 64px;
            display: inline-block;
            text-align: center;
            margin-right: 10px;
            font-size: 11px;
            color: #8898aa;
        }

        .variant-image-cell img,
        .variant-image-cell .vic-placeholder {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: .375rem;
            border: 1px solid #dee2e6;
            display: block;
            margin: 0 auto 4px;
            cursor: pointer;
        }

        .vic-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
            background: #f8f9fe;
        }

        .variant-table th,
        .variant-table td {
            vertical-align: middle;
            font-size: 12.5px;
        }

        .vt-thumb {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: .375rem;
        }

        .swatch-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
            vertical-align: middle;
        }

        .vt-bulk-bar {
            display: none;
            align-items: center;
            justify-content: space-between;
            background: #eef4ff;
            border: 1px solid #c3d4fb;
            border-radius: .5rem;
            padding: 9px 14px;
            margin-bottom: 10px;
            font-size: 12.5px;
            font-weight: 600;
            color: #5e72e4;
        }

        .vt-bulk-bar.visible {
            display: flex;
        }

        .vt-bulk-bar button {
            border: none;
            background: transparent;
            color: #f5365c;
            font-weight: 700;
        }

        .variant-summary-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #edf0f7;
        }

        .sr-only {
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
    </style>
@endpush

@section('content')
    <div class="card p-4">
        <form action="{{ route('admin.products.save', $product ?? null) }}" method="POST" enctype="multipart/form-data"
            id="productForm">
            @csrf
            @if (isset($product))
                @method('PUT')
            @endif

            <div class="row">
                {{-- Name --}}
                <div class="form-group col-6">
                    <label for="name" class="form-label">
                        <i class="fa-solid fa-tag me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Enter a clear, customer-facing product name"></i>
                        Product Name
                    </label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Ex: Macbook Pro 14 Inch"
                        value="{{ old('name', $product?->name ?? '') }}">
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Slug --}}
                <div class="form-group col-6">
                    <label for="slug" class="form-label">
                        <i class="fa-solid fa-link me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="URL-friendly version of the product name"></i>
                        Slug
                    </label>
                    <input type="text" class="form-control" name="slug" id="slug" placeholder="macbook-pro-14-inch"
                        value="{{ old('slug', $product?->slug ?? '') }}">
                    @error('slug')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="form-group col-12">
                    <label for="description" class="form-label">
                        <i class="fa-solid fa-align-left me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Shown on the product detail page"></i>
                        Description
                    </label>
                    <textarea class="form-control" name="description" id="description" rows="4">{{ old('description', $product?->description ?? '') }}</textarea>
                    @error('description')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Pricing --}}
                <div class="form-group col-4">
                    <label for="price" class="form-label">
                        <i class="fa-solid fa-dollar-sign me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="The price customers pay"></i>
                        Price
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" min="0" class="form-control" name="price" id="price"
                            value="{{ old('price', $product?->price ?? '') }}">
                    </div>
                    @error('price')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-4">
                    <label for="compare_price" class="form-label">
                        <i class="fa-solid fa-tags me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Original price shown crossed out, to highlight a discount. Should be higher than Price."></i>
                        Compare at
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" min="0" class="form-control" name="compare_price"
                            id="compare_price" value="{{ old('compare_price', $product?->compare_price ?? '') }}">
                    </div>
                    <div class="field-hint warn" id="comparePriceWarning">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i>Compare-at is lower than Price
                    </div>
                    @error('compare_price')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-4">
                    <label for="cost_price" class="form-label">
                        <i class="fa-solid fa-coins me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="What this item costs you — used to calculate profit and margin"></i>
                        Cost per item
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" min="0" class="form-control" name="cost_price"
                            id="cost_price" value="{{ old('cost_price', $product?->cost_price ?? '') }}">
                    </div>
                    @error('cost_price')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="charge_tax" id="charge_tax" value="1"
                            {{ old('charge_tax', $product?->charge_tax ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="charge_tax">Charge tax for this product</label>
                    </div>

                    <div class="stat-row">
                        <div class="stat-box">
                            <div class="label">Sales price</div>
                            <div class="value" id="statSalesPrice">$0.00</div>
                        </div>
                        <div class="stat-box">
                            <div class="label">Profit</div>
                            <div class="value" id="statProfit">$0.00</div>
                        </div>
                        <div class="stat-box">
                            <div class="label">Gross margin</div>
                            <div class="value" id="statMargin">0%</div>
                        </div>
                    </div>
                </div>

                {{-- SKU --}}
                <div class="form-group col-4 mt-2">
                    <label for="sku" class="form-label">
                        <i class="fa-solid fa-barcode me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Unique stock-keeping unit for this product"></i>
                        SKU
                    </label>
                    <input type="text" class="form-control" name="sku" id="sku" placeholder="MAC-09485"
                        value="{{ old('sku', $product?->sku ?? '') }}">
                    @error('sku')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Category --}}
                <div class="form-group col-4 mt-2">
                    <label for="category_id" class="form-label">
                        <i class="fa-solid fa-folder-tree me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Which category this product is listed under"></i>
                        Category
                    </label>
                    <select class="form-select" id="category_id" name="category_id">
                        <option value="" selected disabled>-- Select --</option>
                        @forelse ($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $product?->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @empty
                            <option value="" disabled>No categories available</option>
                        @endforelse
                    </select>
                    @error('category_id')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Vendor --}}
                <div class="form-group col-4 mt-2">
                    <label for="vendor_id" class="form-label">
                        <i class="fa-solid fa-shop me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="The vendor or supplier of this product"></i>
                        Vendor
                    </label>
                    <select class="form-select" id="vendor_id" name="vendor_id">
                        <option value="" selected disabled>-- Select --</option>
                        @forelse ($vendors as $vendor)
                            <option value="{{ $vendor->id }}"
                                {{ old('vendor_id', $product?->vendor_id ?? '') == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->name }}
                            </option>
                        @empty
                            <option value="" disabled>No vendors available</option>
                        @endforelse
                    </select>
                    @error('vendor_id')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Product Type --}}
                <div class="form-group col-4 mt-2">
                    <label for="product_type_id" class="form-label">
                        <i class="fa-solid fa-cubes me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Broad product type, used for reporting and filters"></i>
                        Type
                    </label>
                    <select class="form-select" id="product_type_id" name="product_type_id">
                        <option value="" selected disabled>-- Select --</option>
                        @forelse ($productTypes as $type)
                            <option value="{{ $type->id }}"
                                {{ old('product_type_id', $product?->product_type_id ?? '') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @empty
                            <option value="" disabled>No types available</option>
                        @endforelse
                    </select>
                    @error('product_type_id')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="form-group col-4 mt-2">
                    <label for="status" class="form-label">
                        <i class="fa-solid fa-clipboard me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Only Active products are visible in the storefront"></i>
                        Status
                    </label>
                    <div>
                        <div class="status-toggle" data-size="sm" role="radiogroup" aria-labelledby="caption-sm">
                            <label class="status-toggle-item">
                                <input type="radio" name="status" value="active" class="status-toggle-input"
                                    data-value="active"
                                    {{ old('status', $product?->status ?? 'active') == 'active' ? 'checked' : '' }}>
                                <span class="status-toggle-button"><i class="fa-solid fa-circle-check"
                                        aria-hidden="true"></i>Active</span>
                            </label>
                            <label class="status-toggle-item">
                                <input type="radio" name="status" value="inactive" class="status-toggle-input"
                                    data-value="inactive"
                                    {{ old('status', $product?->status ?? '') == 'inactive' ? 'checked' : '' }}>
                                <span class="status-toggle-button"><i class="fa-solid fa-circle-xmark"
                                        aria-hidden="true"></i>Inactive</span>
                            </label>
                        </div>
                    </div>
                    @error('status')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Gallery --}}
                <div class="form-group col-12 mt-3">
                    <label class="form-label">
                        <i class="fa-solid fa-images me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="First image is used as the main product photo"></i>
                        Product Images
                    </label>
                    <div class="gallery-wrap" id="galleryWrap">
                        @if (isset($product))
                            @foreach ($product->images as $img)
                                <div class="gallery-thumb" data-existing-id="{{ $img->id }}">
                                    <img src="{{ $img->url }}" alt="{{ $product->name }} image">
                                    <button type="button" class="remove-thumb" aria-label="Remove image">&times;</button>
                                    <input type="hidden" name="remove_images[]" value="" disabled
                                        class="removed-flag">
                                </div>
                            @endforeach
                        @endif
                        <button type="button" class="gallery-add" id="galleryAddBtn">
                            <i class="fa-solid fa-plus"></i>
                            Add
                        </button>
                    </div>
                    <input type="file" name="gallery_images[]" id="galleryFileInput" accept="image/*" multiple
                        class="d-none">
                    <div class="field-hint">JPG or PNG, up to 5MB each. First image is the main photo.</div>
                </div>

                {{-- Variants --}}
                <div class="form-group col-12 mt-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <label class="form-label mb-0">
                            <i class="fa-solid fa-layer-group me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Options like Color or Size that generate purchasable combinations"></i>
                            Variants
                        </label>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#variantModal">
                            <i class="fa-solid fa-plus me-1"></i>Add / Edit variants
                        </button>
                    </div>

                    <div id="variantEmptyState" class="field-hint mt-2">
                        No variants yet. Use "Add / Edit variants" if this product comes in multiple options
                        (e.g. Color, Size).
                    </div>
                    <div id="variantSummaryWrap" class="mt-2 d-none">
                        <div id="variantSummaryList"></div>
                    </div>

                    {{-- Serialized variant data, submitted with the form and read on the backend --}}
                    <input type="hidden" name="variants_json" id="variantsJsonInput"
                        value="{{ old('variants_json', $product?->variants_json ?? '') }}">
                </div>
            </div>

            <div class="card-footer mt-3">
                <div class="mt-3 text-center">
                    <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                </div>
            </div>
        </form>
    </div>

    {{-- ===================== VARIANTS MODAL ===================== --}}
    <div class="modal fade" id="variantModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Product Variants</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="mb-0">Variant options</h6>
                        <button type="button" class="btn btn-sm btn-link" id="addVariantBtn">
                            <i class="fa-solid fa-plus me-1"></i>Add option
                        </button>
                    </div>

                    <div id="variantBlocks"></div>

                    <template id="variantBlockTemplate">
                        <div class="variant-block" data-variant-index="">
                            <div class="vb-head">
                                <h6>Option <span class="vb-number"></span></h6>
                                <button type="button" class="vb-remove"><i class="fa-solid fa-trash"></i></button>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Option name</label>
                                    <select class="form-select variant-type-select">
                                        <option value="Color">Color</option>
                                        <option value="Size">Size</option>
                                        <option value="Material">Material</option>
                                        <option value="RAM">RAM</option>
                                        <option value="SSD Size">SSD Size</option>
                                    </select>
                                    <div class="field-hint warn show-if-duplicate">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i>This option is already
                                        used above
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Values</label>
                                    <div class="tag-input value-tag-input">
                                        <label class="sr-only">Type a value and press Enter</label>
                                        <input type="text" placeholder="Type a value and press Enter">
                                    </div>
                                </div>
                            </div>

                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input use-image-toggle" type="checkbox" role="switch">
                                <label class="form-check-label">Use image for this option</label>
                            </div>

                            <div class="variant-images d-none mt-2"></div>
                        </div>
                    </template>

                    <div id="variantTableSection" class="d-none mt-4">
                        <h6>Variant table</h6>
                        <div class="vt-bulk-bar" id="vtBulkBar">
                            <span id="vtBulkCount">0 selected</span>
                            <button type="button" id="vtBulkDelete"><i class="fa-solid fa-trash me-1"></i>Delete
                                selected</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table variant-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th style="width:34px;"><input type="checkbox" class="form-check-input"
                                                id="variantTableSelectAll" aria-label="Select all variants"></th>
                                        <th style="width:56px;">Image</th>
                                        <th id="variantTableLabelHeader">Variant</th>
                                        <th style="width:140px;">Price</th>
                                        <th style="width:110px;">Stock</th>
                                    </tr>
                                </thead>
                                <tbody id="variantTableBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex align-items-center justify-content-between">
                    <span></span>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="saveVariantBtn">Save Variants</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Shared image picker (used by variant "Use image" cells) --}}
    <input type="file" id="variantImageFileInput" accept="image/*" class="d-none">
@endsection


@push('js')
    <!-- Select2 (only needed if KaiAdmin doesn't already bundle it — remove if it does) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            $('#category_id, #vendor_id, #product_type_id').select2({
                width: '100%',
                placeholder: '-- Select --'
            });
        });

        // Slug auto-generation from Name — same behaviour as the categories page,
        // but only while the admin hasn't hand-edited the slug themselves.
        $(document).ready(function() {
            var slugTouched = $('#slug').val().length > 0;
            $('#slug').on('input', function() {
                slugTouched = true;
            });
            $('#name').on('keyup', function() {
                if (slugTouched) return;
                var slug = $(this).val()
                    .toString()
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                $('#slug').val(slug);
            });
        });
    </script>

    <script>
        // ---------- Live pricing calculation ----------
        (function() {
            var priceInput = document.getElementById('price');
            var compareInput = document.getElementById('compare_price');
            var costInput = document.getElementById('cost_price');
            var warning = document.getElementById('comparePriceWarning');

            function recalc() {
                var price = parseFloat(priceInput.value) || 0;
                var compare = parseFloat(compareInput.value) || 0;
                var cost = parseFloat(costInput.value) || 0;
                var profit = price - cost;
                var margin = price > 0 ? (profit / price) * 100 : 0;

                document.getElementById('statSalesPrice').textContent = '$' + price.toFixed(2);
                document.getElementById('statProfit').textContent =
                    (profit < 0 ? '-' : '') + '$' + Math.abs(profit).toFixed(2);
                document.getElementById('statMargin').textContent = margin.toFixed(1) + '%';

                warning.classList.toggle('show', compare > 0 && compare < price);
            }
            [priceInput, compareInput, costInput].forEach(function(el) {
                el.addEventListener('input', recalc);
            });
            recalc();
        })();
    </script>

    <script>
        // ---------- Gallery: add / preview / remove, keeping the file input in sync ----------
        (function() {
            var galleryWrap = document.getElementById('galleryWrap');
            var galleryAddBtn = document.getElementById('galleryAddBtn');
            var galleryFileInput = document.getElementById('galleryFileInput');
            var selectedFiles = []; // File objects currently queued for upload

            galleryAddBtn.addEventListener('click', function() {
                galleryFileInput.click();
            });

            galleryFileInput.addEventListener('change', function() {
                Array.prototype.forEach.call(galleryFileInput.files, function(file) {
                    if (!file.type.startsWith('image/')) return;
                    selectedFiles.push(file);
                    addThumb(file);
                });
                syncFileInput();
            });

            function addThumb(file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var thumb = document.createElement('div');
                    thumb.className = 'gallery-thumb';
                    thumb.innerHTML =
                        '<img src="' + e.target.result + '" alt="">' +
                        '<button type="button" class="remove-thumb" aria-label="Remove image">&times;</button>';
                    thumb.querySelector('.remove-thumb').addEventListener('click', function() {
                        var idx = selectedFiles.indexOf(file);
                        if (idx > -1) selectedFiles.splice(idx, 1);
                        thumb.remove();
                        syncFileInput();
                    });
                    galleryWrap.insertBefore(thumb, galleryAddBtn);
                };
                reader.readAsDataURL(file);
            }

            // Existing (already-uploaded) images: wire up their remove buttons to flag
            // deletion via a hidden input, rather than trying to touch the file list.
            galleryWrap.querySelectorAll('.gallery-thumb[data-existing-id]').forEach(function(thumb) {
                thumb.querySelector('.remove-thumb').addEventListener('click', function() {
                    var flag = thumb.querySelector('.removed-flag');
                    flag.disabled = false;
                    flag.value = thumb.dataset.existingId;
                    thumb.remove();
                });
            });

            // Rebuild the actual <input type="file"> from selectedFiles using DataTransfer,
            // since FileList items can't be removed directly.
            function syncFileInput() {
                var dt = new DataTransfer();
                selectedFiles.forEach(function(f) {
                    dt.items.add(f);
                });
                galleryFileInput.files = dt.files;
            }
        })();
    </script>

    <script>
        // ---------- Variant builder ----------
        (function() {
            var COLOR_MAP = {
                'midnight': '#1d1d1f',
                'silver': '#e3e4e6',
                'starlight': '#f0e6d8',
                'space gray': '#535150',
                'gold': '#f5e1c8',
                'black': '#111111',
                'white': '#ffffff',
                'red': '#e0393e',
                'blue': '#3a6ea5'
            };

            var variantBlocks = document.getElementById('variantBlocks');
            var template = document.getElementById('variantBlockTemplate');
            var variantCount = 0;
            var assignedImages = {}; // value (lowercase) -> data URL
            var variantRowData = {}; // combo label -> {price, stock, checked, excluded}

            function escapeHtml(str) {
                var d = document.createElement('div');
                d.textContent = str == null ? '' : str;
                return d.innerHTML;
            }

            function cartesian(arrays) {
                return arrays.reduce(function(acc, arr) {
                    var out = [];
                    acc.forEach(function(a) {
                        arr.forEach(function(v) {
                            out.push(a.concat([v]));
                        });
                    });
                    return out;
                }, [
                    []
                ]);
            }

            function addVariantBlock() {
                variantCount++;
                var node = template.content.cloneNode(true);
                var block = node.querySelector('.variant-block');
                block.dataset.variantIndex = variantCount;
                node.querySelector('.vb-number').textContent = variantCount;

                var typeSelect = node.querySelector('.variant-type-select');
                var tagInput = node.querySelector('.value-tag-input');
                var input = tagInput.querySelector('input');
                var toggle = node.querySelector('.use-image-toggle');
                var imagesWrap = node.querySelector('.variant-images');

                node.querySelector('.vb-remove').addEventListener('click', function() {
                    block.remove();
                    checkDuplicateTypes();
                    renderVariantTable();
                });

                input.addEventListener('keydown', function(e) {
                    if ((e.key === 'Enter' || e.key === ',') && input.value.trim()) {
                        e.preventDefault();
                        addTagChip(tagInput, input.value.trim(), typeSelect.value);
                        input.value = '';
                        refreshImagesIfNeeded(block);
                        renderVariantTable();
                    } else if (e.key === 'Backspace' && !input.value) {
                        var chips = tagInput.querySelectorAll('.tag-chip');
                        if (chips.length) chips[chips.length - 1].remove();
                        refreshImagesIfNeeded(block);
                        renderVariantTable();
                    }
                });
                tagInput.addEventListener('click', function() {
                    input.focus();
                });

                typeSelect.addEventListener('change', function() {
                    tagInput.querySelectorAll('.tag-chip').forEach(function(c) {
                        c.remove();
                    });
                    refreshImagesIfNeeded(block);
                    checkDuplicateTypes();
                    renderVariantTable();
                });

                toggle.addEventListener('change', function() {
                    if (toggle.checked) {
                        // Only one option can drive the Image column at a time
                        variantBlocks.querySelectorAll('.variant-block').forEach(function(other) {
                            if (other === block) return;
                            var otherToggle = other.querySelector('.use-image-toggle');
                            if (otherToggle.checked) {
                                otherToggle.checked = false;
                                other.querySelector('.variant-images').classList.add('d-none');
                            }
                        });
                    }
                    imagesWrap.classList.toggle('d-none', !toggle.checked);
                    if (toggle.checked) refreshImagesIfNeeded(block);
                    renderVariantTable();
                });

                variantBlocks.appendChild(node);
                checkDuplicateTypes();
                return block;
            }

            function checkDuplicateTypes() {
                var blocks = Array.prototype.slice.call(variantBlocks.querySelectorAll('.variant-block'));
                var counts = {};
                blocks.forEach(function(b) {
                    var t = b.querySelector('.variant-type-select').value;
                    counts[t] = (counts[t] || 0) + 1;
                });
                blocks.forEach(function(b) {
                    var t = b.querySelector('.variant-type-select').value;
                    var isDup = counts[t] > 1;
                    b.classList.toggle('duplicate-type', isDup);
                    var warn = b.querySelector('.show-if-duplicate');
                    if (warn) warn.classList.toggle('show', isDup);
                });
                var saveBtn = document.getElementById('saveVariantBtn');
                if (saveBtn) saveBtn.disabled = blocks.some(function(b) {
                    return b.classList.contains('duplicate-type');
                });
            }

            function addTagChip(tagInput, value, type) {
                var existing = Array.prototype.map.call(tagInput.querySelectorAll('.tag-chip'), function(c) {
                    return c.dataset.value.toLowerCase();
                });
                if (existing.indexOf(value.toLowerCase()) > -1) return;

                var chip = document.createElement('span');
                chip.className = 'tag-chip';
                chip.dataset.value = value;
                var dotHtml = '';
                if (type === 'Color') {
                    var color = COLOR_MAP[value.toLowerCase()] || '#b9bcc6';
                    dotHtml = '<span class="dot" style="background:' + color + ';"></span>';
                }
                chip.innerHTML = dotHtml + '<span>' + escapeHtml(value) + '</span>' +
                    '<button type="button" aria-label="Remove ' + escapeHtml(value) + '">&times;</button>';
                chip.querySelector('button').addEventListener('click', function() {
                    var block = chip.closest('.variant-block');
                    chip.remove();
                    refreshImagesIfNeeded(block);
                    renderVariantTable();
                });
                tagInput.insertBefore(chip, tagInput.querySelector('input'));
            }

            function refreshImagesIfNeeded(block) {
                var toggle = block.querySelector('.use-image-toggle');
                var imagesWrap = block.querySelector('.variant-images');
                if (!toggle.checked) {
                    imagesWrap.classList.add('d-none');
                    return;
                }
                var values = Array.prototype.map.call(block.querySelectorAll('.tag-chip'), function(c) {
                    return c.dataset.value;
                });
                imagesWrap.innerHTML = '';
                if (!values.length) {
                    imagesWrap.classList.add('d-none');
                    return;
                }
                imagesWrap.classList.remove('d-none');
                values.forEach(function(val) {
                    var key = val.toLowerCase();
                    var cell = document.createElement('div');
                    cell.className = 'variant-image-cell';
                    cell.innerHTML = (assignedImages[key] ?
                            '<img src="' + assignedImages[key] + '" alt="">' :
                            '<div class="vic-placeholder"><i class="fa-solid fa-image"></i></div>') +
                        '<div>' + escapeHtml(val) + '</div>';
                    cell.addEventListener('click', function() {
                        pickImageFor(key, function(dataUrl) {
                            assignedImages[key] = dataUrl;
                            refreshImagesIfNeeded(block);
                            renderVariantTable();
                        });
                    });
                    imagesWrap.appendChild(cell);
                });
            }

            // Simple native file picker (no fake stock-photo library — this points
            // straight at a real <input type=file> and reads the chosen image).
            var variantImageFileInput = document.getElementById('variantImageFileInput');
            var pendingCallback = null;
            variantImageFileInput.addEventListener('change', function() {
                var file = variantImageFileInput.files[0];
                if (!file || !pendingCallback) return;
                var reader = new FileReader();
                reader.onload = function(e) {
                    pendingCallback(e.target.result);
                    pendingCallback = null;
                };
                reader.readAsDataURL(file);
                variantImageFileInput.value = '';
            });

            function pickImageFor(key, callback) {
                pendingCallback = callback;
                variantImageFileInput.click();
            }

            function renderVariantTable() {
                var blocks = Array.prototype.map.call(variantBlocks.querySelectorAll('.variant-block'), function(
                    b) {
                    return {
                        type: b.querySelector('.variant-type-select').value,
                        isImage: b.querySelector('.use-image-toggle').checked,
                        values: Array.prototype.map.call(b.querySelectorAll('.tag-chip'), function(c) {
                            return c.dataset.value;
                        })
                    };
                }).filter(function(b) {
                    return b.values.length;
                });

                var section = document.getElementById('variantTableSection');
                var body = document.getElementById('variantTableBody');
                var labelHeader = document.getElementById('variantTableLabelHeader');

                if (!blocks.length) {
                    section.classList.add('d-none');
                    body.innerHTML = '';
                    updateBulkBar();
                    return;
                }

                section.classList.remove('d-none');
                labelHeader.textContent = blocks.length === 1 ? blocks[0].type : 'Variant';

                var imageBlockIndex = blocks.findIndex ? blocks.findIndex(function(b) {
                    return b.isImage;
                }) : -1;
                var combos = cartesian(blocks.map(function(b) {
                    return b.values;
                }));
                var defaultPrice = document.getElementById('price').value || '0';

                body.innerHTML = '';
                combos.forEach(function(combo, i) {
                    var label = combo.join(' / ');
                    var isColorOnly = blocks.length === 1 && blocks[0].type === 'Color';
                    var imgValue = imageBlockIndex >= 0 ? combo[imageBlockIndex] : null;
                    var imgKey = imgValue ? imgValue.toLowerCase() : null;
                    var imgUrl = imgKey ? assignedImages[imgKey] : null;

                    if (!variantRowData[label]) {
                        variantRowData[label] = {
                            price: Number(defaultPrice).toFixed(2),
                            stock: 10,
                            checked: false,
                            excluded: false
                        };
                    }
                    var rowState = variantRowData[label];
                    if (rowState.excluded) return;
                    var rowId = 'vtrow-' + i;

                    var tr = document.createElement('tr');
                    tr.dataset.label = label;
                    tr.innerHTML =
                        '<td><input type="checkbox" class="form-check-input vt-row-check" id="' + rowId +
                        '-check" aria-label="Select ' + escapeHtml(label) + '" ' + (rowState.checked ?
                            'checked' : '') + '></td>' +
                        '<td>' + (imgValue ?
                            (imgUrl ?
                                '<img class="vt-thumb" src="' + imgUrl + '" alt="" data-key="' + escapeHtml(
                                    imgKey) + '" style="cursor:pointer;">' :
                                '<button type="button" class="vt-thumb-empty btn btn-sm btn-light" data-key="' +
                                escapeHtml(imgKey) + '"><i class="fa-solid fa-image"></i></button>') :
                            '') + '</td>' +
                        '<td>' + (isColorOnly ?
                            '<span class="swatch-dot" style="background:' + (COLOR_MAP[combo[0].toLowerCase()] ||
                                '#b9bcc6') + '"></span>' : '') +
                        '<label for="' + rowId + '-check">' + escapeHtml(label) + '</label></td>' +
                        '<td><div class="input-group input-group-sm"><span class="input-group-text">$</span>' +
                        '<input type="number" min="0" step="0.01" class="form-control vt-price" value="' +
                        rowState.price + '"></div></td>' +
                        '<td><input type="number" min="0" step="1" class="form-control vt-stock" value="' +
                        rowState.stock + '"></td>';

                    tr.querySelector('.vt-row-check').addEventListener('change', function(e) {
                        rowState.checked = e.target.checked;
                        updateBulkBar();
                    });
                    tr.querySelector('.vt-price').addEventListener('input', function(e) {
                        rowState.price = e.target.value;
                    });
                    tr.querySelector('.vt-stock').addEventListener('input', function(e) {
                        rowState.stock = e.target.value;
                    });

                    var thumbEl = tr.querySelector('.vt-thumb, .vt-thumb-empty');
                    if (thumbEl) {
                        thumbEl.addEventListener('click', function() {
                            var key = thumbEl.dataset.key;
                            pickImageFor(key, function(dataUrl) {
                                assignedImages[key] = dataUrl;
                                renderVariantTable();
                            });
                        });
                    }

                    body.appendChild(tr);
                });

                var currentLabels = {};
                combos.forEach(function(c) {
                    currentLabels[c.join(' / ')] = true;
                });
                Object.keys(variantRowData).forEach(function(k) {
                    if (!currentLabels[k]) delete variantRowData[k];
                });

                updateBulkBar();
            }

            function updateBulkBar() {
                var bar = document.getElementById('vtBulkBar');
                var count = Object.keys(variantRowData).filter(function(k) {
                    return variantRowData[k].checked;
                }).length;
                document.getElementById('vtBulkCount').textContent = count + ' selected';
                bar.classList.toggle('visible', count > 0);
            }

            document.getElementById('variantTableSelectAll').addEventListener('change', function(e) {
                document.querySelectorAll('.vt-row-check').forEach(function(cb) {
                    cb.checked = e.target.checked;
                });
                Object.keys(variantRowData).forEach(function(k) {
                    variantRowData[k].checked = e.target.checked;
                });
                updateBulkBar();
            });

            document.getElementById('vtBulkDelete').addEventListener('click', function() {
                var toDelete = Object.keys(variantRowData).filter(function(k) {
                    return variantRowData[k].checked;
                });
                toDelete.forEach(function(k) {
                    variantRowData[k].excluded = true;
                    variantRowData[k].checked = false;
                });
                renderVariantTable();
            });

            document.getElementById('addVariantBtn').addEventListener('click', function() {
                addVariantBlock();
            });

            document.getElementById('saveVariantBtn').addEventListener('click', function() {
                var blocks = Array.prototype.slice.call(variantBlocks.querySelectorAll('.variant-block'));
                if (blocks.some(function(b) {
                        return b.classList.contains('duplicate-type');
                    })) {
                    return; // duplicate warning already visible inline
                }

                var emptyState = document.getElementById('variantEmptyState');
                var summaryWrap = document.getElementById('variantSummaryWrap');
                var summaryList = document.getElementById('variantSummaryList');

                var payload = {
                    options: blocks.map(function(b) {
                        return {
                            type: b.querySelector('.variant-type-select').value,
                            values: Array.prototype.map.call(b.querySelectorAll('.tag-chip'), function(c) {
                                return c.dataset.value;
                            }),
                            uses_image: b.querySelector('.use-image-toggle').checked
                        };
                    }),
                    rows: Object.keys(variantRowData)
                        .filter(function(k) {
                            return !variantRowData[k].excluded;
                        })
                        .map(function(k) {
                            return {
                                label: k,
                                price: variantRowData[k].price,
                                stock: variantRowData[k].stock
                            };
                        })
                };
                document.getElementById('variantsJsonInput').value = JSON.stringify(payload);

                if (!blocks.length || !payload.rows.length) {
                    emptyState.classList.remove('d-none');
                    summaryWrap.classList.add('d-none');
                } else {
                    emptyState.classList.add('d-none');
                    summaryWrap.classList.remove('d-none');
                    summaryList.innerHTML = '';
                    payload.options.forEach(function(opt) {
                        var row = document.createElement('div');
                        row.className = 'variant-summary-row';
                        row.innerHTML =
                            '<div><strong>' + escapeHtml(opt.type) + '</strong><br>' +
                            '<span class="field-hint">' + opt.values.map(escapeHtml).join(', ') + '</span></div>';
                        summaryList.appendChild(row);
                    });
                    var totalStock = payload.rows.reduce(function(sum, r) {
                        return sum + (Number(r.stock) || 0);
                    }, 0);
                    var totalRow = document.createElement('div');
                    totalRow.className = 'field-hint mt-2';
                    totalRow.textContent = payload.rows.length + ' variant combinations · ' + totalStock +
                        ' in stock';
                    summaryList.appendChild(totalRow);
                }

                var modalEl = document.getElementById('variantModal');
                var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.hide();
            });

            // If editing an existing product, rehydrate the builder from variants_json
            document.addEventListener('DOMContentLoaded', function() {
                var raw = document.getElementById('variantsJsonInput').value;
                if (!raw) return;
                try {
                    var data = JSON.parse(raw);
                    (data.options || []).forEach(function(opt) {
                        var block = addVariantBlock();
                        var typeSelect = block.querySelector('.variant-type-select');
                        typeSelect.value = opt.type;
                        var tagInput = block.querySelector('.value-tag-input');
                        opt.values.forEach(function(v) {
                            addTagChip(tagInput, v, opt.type);
                        });
                        if (opt.uses_image) {
                            var toggle = block.querySelector('.use-image-toggle');
                            toggle.checked = true;
                            toggle.dispatchEvent(new Event('change'));
                        }
                    });
                    (data.rows || []).forEach(function(r) {
                        variantRowData[r.label] = {
                            price: r.price,
                            stock: r.stock,
                            checked: false,
                            excluded: false
                        };
                    });
                    renderVariantTable();
                    document.getElementById('variantEmptyState').classList.add('d-none');
                    document.getElementById('variantSummaryWrap').classList.remove('d-none');
                } catch (e) {
                    console.warn('Could not parse existing variants_json', e);
                }
            });
        })();
    </script>
@endpush