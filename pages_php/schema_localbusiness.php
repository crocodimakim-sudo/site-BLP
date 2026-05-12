<?php
// 2026-04-20: LocalBusiness schema — inject on contacts.php page
// 2026-04-24: address corrected to physical warehouse (Одинцово, Неделина 6А)
//             sameAs corrected to external profiles; parentOrganization linked via @id
// 2026-05-11: переписано на PHP-массив для поддержки опционального areaServed
//             обратная совместимость сохранена: если $extra_area_served не задана — вывод идентичен оригиналу

$_extra_area_served = isset($extra_area_served) ? $extra_area_served : null;

$_lb = [
    '@context'           => 'https://schema.org',
    '@type'              => 'LocalBusiness',
    '@id'                => 'https://building-port.ru/#localbusiness',
    'parentOrganization' => ['@id' => 'https://building-port.ru/#organization'],
    'name'               => 'BLP Board',
    'legalName'          => 'ООО «БИЛДИНГПОРТ»',
    'description'        => 'Поставщик фиброцементных панелей для вентилируемых фасадов. Серии NATURE, POLISHED, TEXTURE, WALYPAN.',
    'url'                => 'https://building-port.ru/',
    'telephone'          => '+74959849689',
    'email'              => 'info@building-port.ru',
    'image'              => 'https://building-port.ru/images-convert/shared/header/logo-3.svg',
    'address'            => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => 'ул. Неделина, д. 6А',
        'addressLocality' => 'Одинцово',
        'addressRegion'   => 'Московская область',
        'postalCode'      => '143003',
        'addressCountry'  => 'RU',
    ],
    'geo' => [
        '@type'     => 'GeoCoordinates',
        'latitude'  => '55.6789',
        'longitude' => '37.2725',
    ],
    'openingHoursSpecification' => [
        [
            '@type'      => 'OpeningHoursSpecification',
            'dayOfWeek'  => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            'opens'      => '09:00',
            'closes'     => '18:00',
        ],
    ],
    'priceRange'         => '$$',
    'currenciesAccepted' => 'RUB',
    'paymentAccepted'    => 'Безналичный расчёт, счёт',
    'taxID'              => '7708427307',
];

if ($_extra_area_served) {
    $_lb['areaServed'] = $_extra_area_served;
}

echo '<script type="application/ld+json">' . json_encode($_lb, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";

unset($_lb, $_extra_area_served);
