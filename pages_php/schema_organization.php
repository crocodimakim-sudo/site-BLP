<?php
// 2026-04-20: Organization + WebSite schema for global injection via template.php
// Inject on every page — place in <head> via template.php
?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "https://building-port.ru/blp/#organization",
      "name": "BLP Board",
      "legalName": "ООО «БИЛДИНГПОРТ»",
      "url": "https://building-port.ru/blp/",
      "logo": {
        "@type": "ImageObject",
        "url": "https://building-port.ru/blp/images-convert/shared/header/logo-3.svg",
        "width": 200,
        "height": 60
      },
      "description": "Производитель и поставщик фиброцементных панелей для вентилируемых фасадов. Серии NATURE, POLISHED, TEXTURE, WALYPAN. Негорючие, 0% асбеста, крупноформатные.",
      "telephone": "+74959849689",
      "email": "info@building-port.ru",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "ул. Неделина, 6А",
        "addressLocality": "Одинцово",
        "addressRegion": "Московская область",
        "addressCountry": "RU"
      },
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+74959849689",
        "contactType": "customer service",
        "availableLanguage": "Russian"
      },
      "areaServed": {
        "@type": "Country",
        "name": "Russia"
      },
      "knowsAbout": [
        "Фиброцементные панели",
        "Вентилируемые фасады",
        "Фасадные системы",
        "Строительные материалы"
      ],
      "taxID": "7708427307",
      "identifier": [
        {"@type": "PropertyValue", "name": "ИНН", "value": "7708427307"},
        {"@type": "PropertyValue", "name": "ОГРН", "value": "1237700843390"}
      ]
    },
    {
      "@type": "WebSite",
      "@id": "https://building-port.ru/blp/#website",
      "url": "https://building-port.ru/blp/",
      "name": "BLP Board — Фиброцементные панели",
      "description": "Фиброцементные плиты для вентилируемых фасадов",
      "publisher": {
        "@id": "https://building-port.ru/blp/#organization"
      },
      "inLanguage": "ru-RU",
      "potentialAction": {
        "@type": "SearchAction",
        "target": {
          "@type": "EntryPoint",
          "urlTemplate": "https://building-port.ru/blp/catalog?q={search_term_string}"
        },
        "query-input": "required name=search_term_string"
      }
    }
  ]
}
</script>
