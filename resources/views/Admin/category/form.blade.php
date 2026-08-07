@extends('admin.layout.app')
@push('css')
    <!-- Select2 (only needed if KaiAdmin doesn't already bundle it — remove if it does) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css">

    <style>
        .status-toggle-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .status-label::before {
            content: "Inactive";
            display: inline-block;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .3px;
            color: #8898aa;
            background-color: rgba(136, 152, 170, .12);
        }

        #status:checked~.status-label::before {
            content: "Active";
            color: #2dce89;
            background-color: rgba(45, 206, 137, .12);
        }

        /* --- Select2 styling for #parent_category ---
                                                       Real <li> elements now, so padding/background/etc. all work normally. */
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
        }
    </style>
@endpush

@section('content')
    <div class="card p-4">
        <form action="{{ route('admin.categories.save') }}" class="" method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-6">
                    <label for="name" class="form-label">
                        <i class="fa-solid fa-tag me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Enter a unique name for this category"></i>
                        Category Name
                    </label>
                    <input type="text" class="form-control" name="name" value="{{ $category?->name ?? '' }}"
                        id="name" placeholder="Ex: Fashion">
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-3">
                    <label class="form-label">
                        <i class="fa-solid fa-sitemap me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Choose whether this is a Parent or Child category"></i>
                        Category Type
                    </label>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <!-- Fixed: Checked if parent_id is null/blank -->
                            <input type="radio" name="type" value="parent" class="selectgroup-input"
                                {{ !$category?->parent_id ? 'checked' : '' }}>
                            <span class="selectgroup-button"><i class="fa-solid fa-layer-group me-1"></i>Parent</span>
                        </label>
                        <label class="selectgroup-item">
                            <!-- Fixed: Checked if parent_id exists -->
                            <input type="radio" name="type" value="child" class="selectgroup-input"
                                {{ $category?->parent_id ? 'checked' : '' }}>
                            <span class="selectgroup-button"><i class="fa-solid fa-code-branch me-1"></i>Child</span>
                        </label>
                    </div>
                    @error('type')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group col-3 d-none par-cate-select">
                    <label for="parent_category" class="form-label">
                        <i class="fa-solid fa-diagram-project me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Select the parent this category belongs to"></i>
                        Choose A Parent Categoty
                    </label>
                    <select class="form-select" id="parent_category" name="parent_category">
                        @forelse ($par_categories as $par_cate)
                            @if ($loop->first)
                                <option value="" selected> -- Select -- </option>
                            @endif
                            <option value="{{ $par_cate?->id }}">{{ $par_cate?->name }}</option>
                        @empty
                            <option value="" selected>No categories available</option>
                        @endforelse
                    </select>
                    @error('parent_category')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-6">
                    <label for="slug" class="form-label">
                        <i class="fa-solid fa-link me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="URL-friendly version of the category name"></i>
                        Slug
                    </label>
                    <input type="text" class="form-control" name="slug" value="{{ $category?->slug ?? '' }}"
                        id="slug" placeholder="fashion">
                    @error('slug')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="status" class="form-label">
                        <i class="fa-solid fa-clipboard me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Turn this category on or off"></i>
                        Status
                    </label>
                    <div>
                        <div class="status-toggle" data-size="sm" role="radiogroup" aria-labelledby="caption-sm">
                            <label class="status-toggle-item">
                                <input type="radio" name="status" value="active" class="status-toggle-input"
                                    data-value="active" checked>
                                <span class="status-toggle-button"><i class="fa-solid fa-circle-check"
                                        aria-hidden="true"></i>Active</span>
                            </label>
                            <label class="status-toggle-item">
                                <input type="radio" name="status" value="inactive" class="status-toggle-input"
                                    data-value="inactive">
                                <span class="status-toggle-button"><i class="fa-solid fa-circle-xmark"
                                        aria-hidden="true"></i>Inactive</span>
                            </label>
                        </div>
                    </div>
                    @error('status')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="card-footer mt-3">
                <div class="mt-3 text-center">
                    <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                </div>
            </div>
        </form>
    </div>
@endsection


@push('js')
    <!-- Select2 (only needed if KaiAdmin doesn't already bundle it — remove if it does) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('input[name="type"]').on('change', function() {
                var selectedValue = $(this).val();
                if (selectedValue == 'child') {
                    $('.par-cate-select').removeClass('d-none');
                } else {
                    $('.par-cate-select').addClass('d-none');
                }
            });

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            $('#parent_category').select2({
                width: '100%',
                placeholder: '-- Select --'
            });
        });

        $(document).ready(function() {
            $('#name').on('keyup', function() {
                var slug = $(this).val()
                    .toString()
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g,
                        '') // strip anything that isn't a letter, number, space, or dash
                    .replace(/[\s_-]+/g, '-') // collapse spaces/underscores into a single dash
                    .replace(/^-+|-+$/g, ''); // trim leading/trailing dashes

                $('#slug').val(slug);
            });
        });
    </script>
@endpush
