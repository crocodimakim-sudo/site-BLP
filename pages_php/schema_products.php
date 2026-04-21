<?php
// 2026-04-20: ProductGroup + 4 Product schemas for catalog.php
// Inject inside catalog.php before </body>
?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ProductGroup",
  "@id": "https://building-port.ru/blp/catalog#productgroup",
  "name": "Фиброцементные панели BLP Board",
  "description": "Архитектурные фиброцементные панели для вентилируемых фасадов, окрашенные в массе. Четыре серии: NATURE, POLISHED, TEXTURE, WALYPAN.",
  "url": "https://building-port.ru/blp/catalog",
  "brand": {
    "@type": "Brand",
    "name": "BLP Board"
  },
  "manufacturer": {
    "@id": "https://building-port.ru/blp/#organization"
  },
  "hasVariant": [
    {
      "@type": "Product",
      "@id": "https://building-port.ru/blp/catalog#nature",
      "name": "Фиброцементные панели BLP Board — серия NATURE",
      "description": "Натуральные фиброцементные панели с фактурой под бетон. Индустриальная эстетика, неповторимый рисунок каждой панели.",
      "image": "https://building-port.ru/blp/images-convert/pages/catalog/1.jpg",
      "url": "https://building-port.ru/blp/catalog#nature",
      "brand": {
        "@type": "Brand",
        "name": "BLP Board"
      },
      "manufacturer": {
        "@id": "https://building-port.ru/blp/#organization"
      },
      "material": "Фиброцемент",
      "color": "Белый, Бежевый, Серый, Графит, Терракота, Коричневый",
      "additionalProperty": [
        {
          "@type": "PropertyValue",
          "name": "Толщина",
          "value": "8, 9, 10, 12, 15 мм"
        },
        {
          "@type": "PropertyValue",
          "name": "Длина",
          "value": "2440, 3050 мм"
        },
        {
          "@type": "PropertyValue",
          "name": "Ширина",
          "value": "1220 мм"
        },
        {
          "@type": "PropertyValue",
          "name": "Класс горючести",
          "value": "НГ (Негорючий)"
        },
        {
          "@type": "PropertyValue",
          "name": "Содержание асбеста",
          "value": "0%"
        }
      ],
      "offers": {
        "@type": "Offer",
        "priceCurrency": "RUB",
        "availability": "https://schema.org/InStock",
        "seller": {
          "@id": "https://building-port.ru/blp/#organization"
        },
        "url": "https://building-port.ru/blp/contacts"
      }
    },
    {
      "@type": "Product",
      "@id": "https://building-port.ru/blp/catalog#polished",
      "name": "Фиброцементные панели BLP Board — серия POLISHED",
      "description": "Полированные фиброцементные плиты в спокойных природных оттенках. Матовая поверхность, сдержанная классика.",
      "image": "https://building-port.ru/blp/images-convert/pages/catalog/2.png",
      "url": "https://building-port.ru/blp/catalog#polished",
      "brand": {
        "@type": "Brand",
        "name": "BLP Board"
      },
      "manufacturer": {
        "@id": "https://building-port.ru/blp/#organization"
      },
      "material": "Фиброцемент",
      "color": "Белый, Бежевый, Серый, Графит, Терракота, Коричневый",
      "additionalProperty": [
        {
          "@type": "PropertyValue",
          "name": "Толщина",
          "value": "8, 9, 10, 12, 15 мм"
        },
        {
          "@type": "PropertyValue",
          "name": "Длина",
          "value": "2440, 3050 мм"
        },
        {
          "@type": "PropertyValue",
          "name": "Ширина",
          "value": "1220 мм"
        },
        {
          "@type": "PropertyValue",
          "name": "Класс горючести",
          "value": "НГ (Негорючий)"
        }
      ],
      "offers": {
        "@type": "Offer",
        "priceCurrency": "RUB",
        "availability": "https://schema.org/InStock",
        "seller": {
          "@id": "https://building-port.ru/blp/#organization"
        },
        "url": "https://building-port.ru/blp/contacts"
      }
    },
    {
      "@type": "Product",
      "@id": "https://building-port.ru/blp/catalog#texture",
      "name": "Фиброцементные панели BLP Board — серия TEXTURE",
      "description": "Текстурированные фиброцементные плиты. Естественная палитра и слегка шлифованная поверхность для статусного фасада.",
      "image": "https://building-port.ru/blp/images-convert/pages/catalog/3.png",
      "url": "https://building-port.ru/blp/catalog#texture",
      "brand": {
        "@type": "Brand",
        "name": "BLP Board"
      },
      "manufacturer": {
        "@id": "https://building-port.ru/blp/#organization"
      },
      "material": "Фиброцемент",
      "color": "Белый, Бежевый, Серый, Графит, Терракота, Коричневый",
      "additionalProperty": [
        {
          "@type": "PropertyValue",
          "name": "Толщина",
          "value": "8, 9, 10, 12, 15 мм"
        },
        {
          "@type": "PropertyValue",
          "name": "Длина",
          "value": "2440, 3050 мм"
        },
        {
          "@type": "PropertyValue",
          "name": "Ширина",
          "value": "1220 мм"
        },
        {
          "@type": "PropertyValue",
          "name": "Класс горючести",
          "value": "НГ (Негорючий)"
        }
      ],
      "offers": {
        "@type": "Offer",
        "priceCurrency": "RUB",
        "availability": "https://schema.org/InStock",
        "seller": {
          "@id": "https://building-port.ru/blp/#organization"
        },
        "url": "https://building-port.ru/blp/contacts"
      }
    },
    {
      "@type": "Product",
      "@id": "https://building-port.ru/blp/catalog#walypan",
      "name": "Линеарные фиброцементные панели BLP Board — серия WALYPAN",
      "description": "Линеарные фиброцементные панели для сложных фасадных решений. Рельефная поверхность, геометрические рисунки, объёмный фасад.",
      "url": "https://building-port.ru/blp/catalog#walypan",
      "brand": {
        "@type": "Brand",
        "name": "BLP Board"
      },
      "manufacturer": {
        "@id": "https://building-port.ru/blp/#organization"
      },
      "material": "Фиброцемент",
      "additionalProperty": [
        {
          "@type": "PropertyValue",
          "name": "Толщина",
          "value": "10, 12, 15 мм"
        },
        {
          "@type": "PropertyValue",
          "name": "Длина",
          "value": "2440, 3050 мм"
        },
        {
          "@type": "PropertyValue",
          "name": "Ширина",
          "value": "1220 мм"
        },
        {
          "@type": "PropertyValue",
          "name": "Класс горючести",
          "value": "НГ (Негорючий)"
        }
      ],
      "offers": {
        "@type": "Offer",
        "priceCurrency": "RUB",
        "availability": "https://schema.org/InStock",
        "seller": {
          "@id": "https://building-port.ru/blp/#organization"
        },
        "url": "https://building-port.ru/blp/contacts"
      }
    }
  ]
}
</script>
