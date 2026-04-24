<?php

namespace App\Helpers;

class SeoHelper
{
    public static function schema(string $type, array $data): string
    {
        $schema = match ($type) {
            'organization' => self::organizationSchema($data),
            'product' => self::productSchema($data),
            'article' => self::articleSchema($data),
            'breadcrumb' => self::breadcrumbSchema($data),
            'webpage' => self::webpageSchema($data),
            'website' => self::websiteSchema($data),
            'localbusiness' => self::localBusinessSchema($data),
            default => [],
        };

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
    }

    private static function organizationSchema(array $data): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $data['name'] ?? 'Viam Semicon',
            'url' => $data['url'] ?? config('app.url'),
            'logo' => $data['logo'] ?? asset('images/logo.png'),
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => $data['phone'] ?? '0886160579',
                'contactType' => 'sales',
                'areaServed' => 'VN',
                'availableLanguage' => ['Vietnamese', 'English'],
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $data['address'] ?? 'Số 251 Đường Dục Tú',
                'addressLocality' => 'Đông Anh',
                'addressRegion' => 'Hà Nội',
                'addressCountry' => 'VN',
            ],
            'sameAs' => $data['social'] ?? [],
        ];
    }

    private static function productSchema(array $data): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $data['name'] ?? '',
            'image' => $data['image'] ?? '',
            'description' => $data['description'] ?? '',
            'brand' => [
                '@type' => 'Brand',
                'name' => 'Viam Semicon',
            ],
        ];

        if (!empty($data['price']) && $data['price'] !== '0') {
            $schema['offers'] = [
                '@type' => 'Offer',
                'availability' => 'https://schema.org/InStock',
                'priceCurrency' => 'VND',
                'price' => (string) $data['price'],
                'seller' => [
                    '@type' => 'Organization',
                    'name' => 'Viam Semicon',
                ],
            ];
        }

        return $schema;
    }

    private static function articleSchema(array $data): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $data['title'] ?? '',
            'image' => $data['image'] ?? '',
            'datePublished' => $data['published_at'] ?? '',
            'dateModified' => $data['updated_at'] ?? '',
            'author' => [
                '@type' => 'Organization',
                'name' => 'Viam Semicon',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Viam Semicon',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo.png'),
                ],
            ],
            'description' => $data['description'] ?? '',
        ];
    }

    private static function breadcrumbSchema(array $data): array
    {
        $items = [];
        foreach ($data['items'] ?? [] as $i => $item) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item['name'],
                'item' => $item['url'] ?? null,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }

    private static function webpageSchema(array $data): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'url' => $data['url'] ?? url()->current(),
        ];
    }

    private static function websiteSchema(array $data): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $data['name'] ?? config('site.name', 'Viam Semicon'),
            'url' => $data['url'] ?? config('app.url'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/san-pham') . '?search={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    private static function localBusinessSchema(array $data): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $data['name'] ?? config('site.name', 'Viam Semicon'),
            'image' => asset('images/logo.png'),
            'url' => config('app.url'),
            'telephone' => $data['phone'] ?? '0886160579',
            'email' => $data['email'] ?? 'sale@viamsemicon.com',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Số 251 Đường Dục Tú',
                'addressLocality' => 'Đông Anh',
                'addressRegion' => 'Hà Nội',
                'addressCountry' => 'VN',
            ],
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                    'opens' => '08:00',
                    'closes' => '18:00',
                ],
            ],
        ];
    }
}
