<?php

namespace App\Enums;

enum SettingKey: string
{
    // Site Identity
    case SiteTitle = 'site_title';
    case SiteEmail = 'site_email';
    case SitePhone = 'site_phone';
    case SiteLogo = 'site_logo';
    case SiteFavicon = 'site_favicon';
    case SiteTimezone = 'site_timezone';
    case SiteLanguage = 'site_language';
    case SiteCurrency = 'site_currency';
    case SiteCurrencySymbol = 'site_currency_symbol';

    // Address
    case Address = 'address';
    case City = 'city';
    case State = 'state';
    case Country = 'country';
    case ZipCode = 'zip_code';

    // Social
    case SocialLinks = 'social_links';

    // Pagination
    case PaginationPerPage = 'pagination_per_page';
    case AdminPaginationPerPage = 'admin_pagination_per_page';

    // SEO
    case MetaTitle = 'meta_title';
    case MetaDescription = 'meta_description';
    case MetaKeywords = 'meta_keywords';
    case GoogleAnalyticsId = 'google_analytics_id';
    case GoogleTagManager = 'google_tag_manager';
    case FacebookPixel = 'facebook_pixel';

    // Maintenance
    case MaintenanceMode = 'maintenance_mode';
    case MaintenanceMessage = 'maintenance_message';

    public function default(): mixed
    {
        return match ($this) {
            self::SiteTimezone => 'UTC',
            self::SiteLanguage => 'en',
            self::SiteCurrency => 'USD',
            self::SiteCurrencySymbol => '$',
            self::PaginationPerPage, self::AdminPaginationPerPage => '20',
            self::MaintenanceMode => false,
            default => null,
        };
    }
}
