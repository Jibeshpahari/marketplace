@extends('admin.layout.app')


@section('content')
    <div class="row">
        <div class="col-9">
            <div class="card p-3">
                <div class="container">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="site-identity-tab" data-bs-toggle="tab"
                                data-bs-target="#site-identity" data-tab="site_identity" type="button" role="tab"
                                aria-controls="home" aria-selected="true">Site Identity</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address"
                                data-tab="address" type="button" role="tab" aria-controls="profile"
                                aria-selected="false">Address</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="social-links-tab" data-bs-toggle="tab"
                                data-bs-target="#social-links" data-tab="social_links" type="button" role="tab"
                                aria-controls="contact" aria-selected="false">Social Links</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo"
                                data-tab="seo" type="button" role="tab" aria-controls="contact"
                                aria-selected="false">SEO</button>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="myTabContent">
                        {{-- Site Identity --}}
                        <div class="tab-pane fade show active" id="site-identity" role="tabpanel"
                            aria-labelledby="site-identity">
                            {{-- Site Settings Identity --}}
                            <form action="{{ route('admin.setting.site-setting.store') }}" method="POST" id="site-identity"
                                enctype="multipart/form-data">
                                @csrf
                                {{-- Tab Name --}}
                                <input type="hidden" name="tab_name" value="site_identity" data-tab="site-identity">

                                {{-- Site Name --}}
                                <div class="form-group">
                                    <label for="site_title" class="required">Site Title</label>
                                    <input type="text" class="form-control" id="site_title" name="site_title"
                                        value="{{ old('site_title', setting('site_title')) }}">
                                    @error('site_title')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    {{-- Site Email --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="site_email">Site Email</label>
                                            <input type="email" class="form-control" id="site_email" name="site_email"
                                                value="{{ old('site_email', setting('site_email')) }}">
                                            @error('site_email')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Site Phone --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="site_phone">Site Phone</label>
                                            <input type="text" class="form-control" id="site_phone" name="site_phone"
                                                value="{{ old('site_phone', setting('site_phone')) }}">
                                            @error('site_phone')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        {{-- Site Logo --}}
                                        <div class="form-group">
                                            <label for="site_logo">Site Logo</label>
                                            @if (setting('site_logo'))
                                                <div class="mb-2">
                                                    <img src="{{ Storage::url(setting('site_logo')) }}" alt="Site Logo"
                                                        height="50">
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" id="site_logo" name="site_logo"
                                                accept="image/*">
                                            @error('site_logo')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col">
                                        {{-- Site Favicon --}}
                                        <div class="form-group">
                                            <label for="site_favicon">Site Favicon</label>
                                            @if (setting('site_favicon'))
                                                <div class="mb-2">
                                                    <img src="{{ Storage::url(setting('site_favicon')) }}"
                                                        alt="Site Favicon" height="32">
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" id="site_favicon"
                                                name="site_favicon" accept="image/*">
                                            @error('site_favicon')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        {{-- Site Timezone --}}
                                        <div class="form-group">
                                            <label for="site_timezone">Timezone </label>
                                            @php $currentTimezone = old('site_timezone', setting('site_timezone', 'UTC')); @endphp
                                            <select class="form-select" id="site_timezone" name="site_timezone">
                                                @foreach (timezone_identifiers_list() as $timezone)
                                                    <option value="{{ $timezone }}"
                                                        {{ $currentTimezone === $timezone ? 'selected' : '' }}>
                                                        {{ $timezone }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('site_timezone')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col">
                                        {{-- Site Language --}}
                                        <div class="form-group">
                                            <label for="site_language">Language</label>
                                            @php $currentLanguage = old('site_language', setting('site_language', 'en')); @endphp
                                            <select class="form-select" id="site_language" name="site_language">
                                                <option value="en" {{ $currentLanguage === 'en' ? 'selected' : '' }}>
                                                    English</option>
                                                <option value="fr" {{ $currentLanguage === 'fr' ? 'selected' : '' }}>
                                                    French</option>
                                                <option value="de" {{ $currentLanguage === 'de' ? 'selected' : '' }}>
                                                    German</option>
                                                <option value="es" {{ $currentLanguage === 'es' ? 'selected' : '' }}>
                                                    Spanish</option>
                                                <option value="ar" {{ $currentLanguage === 'ar' ? 'selected' : '' }}>
                                                    Arabic</option>
                                            </select>
                                            @error('site_language')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        {{-- Site Currency --}}
                                        <div class="form-group">
                                            <label for="site_currency">Currency </label>
                                            @php $currentCurrency = old('site_currency', setting('site_currency', 'USD')); @endphp
                                            <select class="form-select" id="site_currency" name="site_currency">
                                                <option value="USD" {{ $currentCurrency === 'USD' ? 'selected' : '' }}>
                                                    USD</option>
                                                <option value="EUR" {{ $currentCurrency === 'EUR' ? 'selected' : '' }}>
                                                    EUR</option>
                                                <option value="GBP" {{ $currentCurrency === 'GBP' ? 'selected' : '' }}>
                                                    GBP</option>
                                                <option value="AED" {{ $currentCurrency === 'AED' ? 'selected' : '' }}>
                                                    AED</option>
                                                <option value="SAR" {{ $currentCurrency === 'SAR' ? 'selected' : '' }}>
                                                    SAR</option>
                                            </select>
                                            @error('site_currency')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col">
                                        {{-- Site Currency Symbol --}}
                                        <div class="form-group">
                                            <label for="site_currency_symbol">Currency Symbol <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="site_currency_symbol"
                                                name="site_currency_symbol"
                                                value="{{ old('site_currency_symbol', setting('site_currency_symbol', '$')) }}">
                                            @error('site_currency_symbol')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </form>
                        </div>
                        {{-- Address --}}
                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address">
                            <form action="{{ route('admin.setting.site-setting.store') }}" method="POST"
                                id="site-address" enctype="multipart/form-data">
                                @csrf

                                {{-- Tab Name --}}
                                <input type="hidden" name="tab_name" value="address" data-tab="site-identity">
                                {{-- Address --}}
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ old('address', setting('address')) }}">
                                    @error('address')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    {{-- City --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                value="{{ old('city', setting('city')) }}">
                                            @error('city')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- State --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control" id="state" name="state"
                                                value="{{ old('state', setting('state')) }}">
                                            @error('state')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Country --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <input type="text" class="form-control" id="country" name="country"
                                                value="{{ old('country', setting('country')) }}">
                                            @error('country')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Zip Code --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="zip_code">Zip Code</label>
                                            <input type="text" class="form-control" id="zip_code" name="zip_code"
                                                value="{{ old('zip_code', setting('zip_code')) }}">
                                            @error('zip_code')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </form>
                        </div>
                        {{-- Social-links --}}
                        <div class="tab-pane fade" id="social-links" role="tabpanel" aria-labelledby="social-links">
                            {{-- <form action="{{ '' }}" method="POST" id="site-links"
                                enctype="multipart/form-data">
                                @csrf
                                Social Links
                                <div class="form-group">
                                    <label>Social Links</label>

                                    <div id="social_links_wrapper">
                                        @if ($s?->social_links)
                                            @foreach (json_decode($s->social_links, true) as $index => $social)
                                                <div class="row social-link-row mb-2">
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control"
                                                            name="social_links[{{ $index }}][name]"
                                                            placeholder="e.g. Facebook"
                                                            value="{{ $social['name'] ?? '' }}">
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="url" class="form-control"
                                                            name="social_links[{{ $index }}][link]"
                                                            placeholder="e.g. https://facebook.com/"
                                                            value="{{ $social['link'] ?? '' }}">
                                                    </div>
                                                    <div class="col-md-1 align-content-center">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-social-link">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2"
                                        id="add_social_link">
                                        <i class="fa fa-plus"></i> Add Social Link
                                    </button>

                                    @error('social_links')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </form> --}}
                        </div>
                        {{-- SEO --}}
                        <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo">
                            {{-- <form action="{{ '' }}" method="POST" id="site-links"
                                enctype="multipart/form-data">
                                @csrf
                                SEO
                                <div class="form-group">
                                    <label for="meta_title">Meta Title</label>
                                    <input type="text" class="form-control" id="meta_title" name="meta_title"
                                        value="{{ $s?->meta_title ?? '' }}">
                                    @error('meta_title')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3">{{ $s?->meta_description ?? '' }}</textarea>
                                    @error('meta_description')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="meta_keywords">Meta Keywords</label>
                                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                        value="{{ $s?->meta_keywords ?? '' }}"
                                        placeholder="e.g. keyword1, keyword2, keyword3">
                                    @error('meta_keywords')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    Google Analytics
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="google_analytics_id">Google Analytics ID</label>
                                            <input type="text" class="form-control" id="google_analytics_id"
                                                name="google_analytics_id" value="{{ $s?->google_analytics_id ?? '' }}"
                                                placeholder="e.g. G-XXXXXXXXXX">
                                            @error('google_analytics_id')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    Google Tag Manager
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="google_tag_manager">Google Tag Manager</label>
                                            <textarea class="form-control" id="google_tag_manager" name="google_tag_manager" rows="3"
                                                placeholder="Paste GTM script here">{{ $s?->google_tag_manager ?? '' }}</textarea>
                                            @error('google_tag_manager')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="facebook_pixel">Facebook Pixel</label>
                                    <textarea class="form-control" id="facebook_pixel" name="facebook_pixel" rows="3"
                                        placeholder="Paste Facebook Pixel script here">{{ $s?->facebook_pixel ?? '' }}</textarea>
                                    @error('facebook_pixel')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>

                                Maintenance
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="maintenance_mode">Maintenance Mode</label>
                                            <select class="form-select" id="maintenance_mode" name="maintenance_mode">
                                                <option value="0"
                                                    {{ ($s?->maintenance_mode ?? false) == false ? 'selected' : '' }}>
                                                    Disabled</option>
                                                <option value="1"
                                                    {{ ($s?->maintenance_mode ?? false) == true ? 'selected' : '' }}>
                                                    Enabled</option>
                                            </select>
                                            @error('maintenance_mode')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="maintenance_message">Maintenance Message</label>
                                            <textarea class="form-control" id="maintenance_message" name="maintenance_message" rows="3"
                                                placeholder="e.g. We are currently down for maintenance. Please check back soon.">{{ $s?->maintenance_message ?? '' }}</textarea>
                                            @error('maintenance_message')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card p-3">
                <h5 class="card-title mb-3">Useful settings</h5>
                <div class="form-group">
                    <label for="city">User Pagination Per Page</label>
                    <input type="number" class="form-control" id="city" name="city" min="1"
                        step="1" value="{{ $s?->city ?? '' }}">
                    @error('city')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="city">Admin Pagination Per Page</label>
                    <input type="number" class="form-control" id="city" name="city" min="1"
                        step="1" value="{{ $s?->city ?? '' }}">
                    @error('city')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="switchCheckDefault">Default switch checkbox input</label>
                        <input class="form-check-input switch switch-lg" type="checkbox" role="switch"
                            id="switchCheckDefault">
                        <span class="error d-block mt-1"> </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')

    @if (session('active_tab'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tabTrigger = document.querySelector(
                    '#myTab [data-tab="{{ session('active_tab') }}"]'
                );
                if (tabTrigger) {
                    bootstrap.Tab.getOrCreateInstance(tabTrigger).show();
                }
            });
        </script>
    @endif

    {{-- <script>
        let socialIndex = {{ $s?->social_links ? count(json_decode($s->social_links, true)) : 0 }};

        $('#add_social_link').on('click', function() {
            const row = `
            <div class="row social-link-row mb-2">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="social_links[${socialIndex}][name]"
                        placeholder="e.g. Facebook">
                </div>
                <div class="col-md-7">
                    <input type="url" class="form-control" name="social_links[${socialIndex}][link]"
                        placeholder="e.g. https://facebook.com/">
                </div>
                <div class="col-md-1 align-content-center">
                    <button type="button" class="btn btn-danger btn-sm remove-social-link">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
        `;

            $('#social_links_wrapper').append(row);
            socialIndex++;
        });

        $('#social_links_wrapper').on('click', '.remove-social-link', function() {
            $(this).closest('.social-link-row').remove();
        });
    </script> --}}  
@endpush
