@extends('admin.layout.app')
@push('css')
    <!-- Select2 (only needed if KaiAdmin doesn't already bundle it — remove if it does) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css">

    <style>
        /* Status label — reflects the toggle's current state, no JS involved */
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
            padding: 12px 16px !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #5e72e4 !important;
        }

        
    </style>
@endpush

@section('content')
    <div class="card p-4">
        <form action="" class="">
            <div class="row">
                <div class="form-group col-6">
                    <label for="name" class="form-label">
                        <i class="fa-solid fa-tag me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Enter a unique name for this category"></i>
                        Category Name
                    </label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Ex: Fashion">
                </div>
                <div class="form-group col-3">
                    <label class="form-label">
                        <i class="fa-solid fa-sitemap me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Choose whether this is a Parent or Child category"></i>
                        Category Type
                    </label>
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="type" value="1" class="selectgroup-input" checked="">
                            <span class="selectgroup-button"><i class="fa-solid fa-layer-group me-1"></i>Parent</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="type" value="0" class="selectgroup-input">
                            <span class="selectgroup-button"><i class="fa-solid fa-code-branch me-1"></i>Child</span>
                        </label>
                    </div>
                </div>
                <div class="form-group col-3 d-none par-cate-select">
                    <label for="parent_category" class="form-label">
                        <i class="fa-solid fa-diagram-project me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Select the parent this category belongs to"></i>
                        Choose A Parent Categoty
                    </label>
                    <select class="form-select" id="parent_category">
                        <option selected> -- Select -- </option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="form-group col-6">
                    <label for="slug" class="form-label">
                        <i class="fa-solid fa-link me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="URL-friendly version of the category name"></i>
                        Slug
                    </label>
                    <input type="text" class="form-control" name="slug" id="slug">
                </div>
                <div class="form-group col-6">
                    <label for="status" class="form-label">
                        <i class="fa-solid fa-clipboard me-1" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Turn this category on or off"></i>
                        Status
                    </label>
                    <div class="status-toggle-wrap">
                        <input class="form-check-input switch switch-lg" type="checkbox" role="switch" name="status"
                            id="status" value="1" checked="">
                        <span class="status-label"></span>
                    </div>
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
                if (selectedValue == '1') {
                    $('.par-cate-select').addClass('d-none');
                } else {
                    $('.par-cate-select').removeClass('d-none');
                }
            });

            // Initialize Bootstrap tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Initialize Select2 on the parent-category dropdown
            $('#parent_category').select2({
                width: '100%',
                placeholder: '-- Select --',
                minimumResultsForSearch: Infinity // hides the search box — remove this line if you'd rather keep search
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