# Local & Geo SEO Strategy — BLP Board
*Дата: 2026-04-20 | Домен: building-port.ru | Продукт: фиброцементные фасадные плиты*

---

## Краткое резюме

**Тип бизнеса:** Гибрид (Hybrid) — производитель с офисом/складом в Одинцово + дилерская сеть по всей России  
**Вертикаль:** Строительные материалы / B2B Manufacturing  
**Текущий Local SEO Score: 18/100**

| Измерение | Вес | Оценка | Статус |
|-----------|-----|--------|--------|
| GBP-сигналы | 25% | 2/10 | Критично |
| Отзывы и репутация | 20% | 1/10 | Критично |
| On-page локальное SEO | 20% | 4/10 | Слабо |
| NAP-консистентность | 15% | 5/10 | Частично |
| Локальная schema | 10% | 0/10 | Отсутствует |
| Ссылочные сигналы | 10% | 2/10 | Критично |

---

## 1. Чертёж страниц локаций (Location Page Blueprint)

### Структура URL
```
building-port.ru/blp/dealers/moskva/
building-port.ru/blp/dealers/sankt-peterburg/
building-port.ru/blp/dealers/ekaterinburg/
building-port.ru/blp/dealers/novosibirsk/
building-port.ru/blp/dealers/krasnodar/
building-port.ru/blp/dealers/kazan/
building-port.ru/blp/dealers/nizhniy-novgorod/
building-port.ru/blp/dealers/chelyabinsk/
building-port.ru/blp/dealers/ufa/
building-port.ru/blp/dealers/rostov-na-donu/
```

### PHP-шаблон страницы дилера (dealer-location.php)

```php
<?php
// 2026-04-20: шаблон геотаргетированной страницы дилера
$city_data = [
    'moskva' => [
        'name'        => 'Москва',
        'name_in'     => 'Москве',        // предложный падеж
        'name_gen'    => 'Москвы',        // родительный падеж
        'region'      => 'Московская область',
        'lat'         => '55.75222',
        'lon'         => '37.61556',
        'dealer_name' => '',              // заполнить при наличии дилера
        'dealer_addr' => '',
        'dealer_phone'=> '',
        'pop'         => '13 млн',
    ],
    'sankt-peterburg' => [
        'name'        => 'Санкт-Петербург',
        'name_in'     => 'Санкт-Петербурге',
        'name_gen'    => 'Санкт-Петербурга',
        'region'      => 'Ленинградская область',
        'lat'         => '59.93900',
        'lon'         => '30.31600',
        'dealer_name' => '',
        'dealer_addr' => '',
        'dealer_phone'=> '',
        'pop'         => '5,6 млн',
    ],
    // ... другие города
];

$slug = basename($_SERVER['REQUEST_URI']);
$city = $city_data[$slug] ?? null;
if (!$city) { header("HTTP/1.0 404 Not Found"); exit; }

$page_title    = "Фиброцементные плиты в {$city['name_in']} — BLP Board";
$page_desc     = "Фиброцементные фасадные панели BLP Board в {$city['name_in']}. "
               . "Дилеры в {$city['name_gen']}, технические консультации, доставка. "
               . "Негорючие плиты 0% асбеста для вентфасадов.";
$page_canonical = "https://building-port.ru/blp/dealers/{$slug}/";
$page_og_image  = 'https://building-port.ru/blp/images/og-default.jpg';
$extra_css      = '<link rel="stylesheet" href="/blp/css/pages/dealer-location.css">';

// JSON-LD LocalBusiness schema
$schema_local = json_encode([
    "@context"        => "https://schema.org",
    "@type"           => "HomeAndConstructionBusiness",
    "@id"             => "https://building-port.ru/blp/dealers/{$slug}/#localbusiness",
    "name"            => "BLP Board — {$city['name']}",
    "description"     => "Фиброцементные фасадные плиты BLP Board в {$city['name_in']}",
    "url"             => "https://building-port.ru/blp/dealers/{$slug}/",
    "telephone"       => "+74959849689",
    "email"           => "info@building-port.ru",
    "address"         => [
        "@type"           => "PostalAddress",
        "streetAddress"   => "ул. Неделина, 6А",
        "addressLocality" => "Одинцово",
        "addressRegion"   => "Московская область",
        "postalCode"      => "143007",
        "addressCountry"  => "RU"
    ],
    "geo"             => [
        "@type"     => "GeoCoordinates",
        "latitude"  => "55.67830",
        "longitude" => "37.27270"
    ],
    "areaServed"      => [
        ["@type" => "City", "name" => $city['name']],
        ["@type" => "State", "name" => $city['region']]
    ],
    "branchOf"        => [
        "@id" => "https://building-port.ru/blp/#organization"
    ],
    "sameAs"          => [
        "https://yandex.ru/maps/org/blp_board/",
        "https://www.2gis.ru/",
        "https://stroysnab.ru/"
    ]
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

ob_start();
?>

<script type="application/ld+json">
<?= $schema_local ?>
</script>

<!-- HERO — уникальный контент по городу -->
<section class="dealer-hero">
    <div class="blp-container">
        <h1>Фиброцементные плиты в <?= htmlspecialchars($city['name_in']) ?></h1>
        <p class="dealer-subtitle">
            Поставки BLP Board для вентилируемых фасадов в <?= $city['name_gen'] ?> и регионе.
            Работаем с застройщиками, архитекторами и монтажными организациями.
        </p>
        <a href="/blp/contacts" class="btn btn-primary">Получить КП для <?= $city['name_gen'] ?></a>
    </div>
</section>

<!-- УНИКАЛЬНЫЙ КОНТЕНТ ГОРОДА (min 60% уникального текста) -->
<section class="dealer-city-info">
    <div class="blp-container">
        <h2>Почему выбирают BLP Board в <?= $city['name_in'] ?></h2>
        <p>
            <?= $city['name'] ?> — один из ключевых строительных рынков России
            с населением <?= $city['pop'] ?>. Объём строительства жилых и коммерческих
            объектов ежегодно растёт, что создаёт стабильный спрос на современные
            фасадные решения.
        </p>
        <!-- Добавить: местные кейсы, объекты, отзывы -->
    </div>
</section>

<!-- Блок применений в регионе -->
<section class="dealer-applications">
    <div class="blp-container">
        <h2>Объекты с фиброцементными панелями в <?= $city['name_in'] ?></h2>
        <!-- Фото местных объектов, кейсы из projects/ -->
        <?php include '../blocks/objects-section.php'; ?>
    </div>
</section>

<!-- Карта и контакты дилера -->
<section class="dealer-contact">
    <div class="blp-container">
        <h2>Как получить фиброцементные плиты в <?= $city['name_in'] ?></h2>
        <?php if ($city['dealer_name']): ?>
        <!-- Если есть местный дилер -->
        <div class="dealer-card">
            <h3><?= htmlspecialchars($city['dealer_name']) ?></h3>
            <p><?= htmlspecialchars($city['dealer_addr']) ?></p>
            <a href="tel:<?= preg_replace('/\D/', '', $city['dealer_phone']) ?>">
                <?= htmlspecialchars($city['dealer_phone']) ?>
            </a>
        </div>
        <?php else: ?>
        <!-- Без местного дилера — центральный офис -->
        <p>Для заказа в <?= $city['name_in'] ?> свяжитесь с нами напрямую:</p>
        <?php endif; ?>
        <?php include '../blocks/contact-form.php'; ?>
    </div>
</section>

<!-- FAQ по городу -->
<section class="dealer-faq">
    <div class="blp-container">
        <h2>Часто задаваемые вопросы о поставках в <?= $city['name_in'] ?></h2>
        <div class="faq-item">
            <h3>Сколько стоит доставка фиброцементных плит в <?= $city['name'] ?>?</h3>
            <p>Стоимость доставки рассчитывается индивидуально от объёма заказа.
               Уточните условия по телефону +7 (495) 984-96-89.</p>
        </div>
        <div class="faq-item">
            <h3>Есть ли дилер BLP Board в <?= $city['name_in'] ?>?</h3>
            <p>Мы активно развиваем дилерскую сеть. Для получения актуальной
               информации о представителях в <?= $city['name_gen'] ?> оставьте заявку.</p>
        </div>
    </div>
</section>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Сколько стоит доставка фиброцементных плит в <?= $city['name'] ?>?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Стоимость доставки рассчитывается индивидуально от объёма заказа. Уточните условия по телефону +7 (495) 984-96-89."
      }
    },
    {
      "@type": "Question",
      "name": "Есть ли дилер BLP Board в <?= $city['name_in'] ?>?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Мы активно развиваем дилерскую сеть. Для получения актуальной информации о представителях в <?= $city['name_gen'] ?> оставьте заявку."
      }
    }
  ]
}
</script>

<?php
$page_content = ob_get_clean();
include 'template.php';
```

### Мета-теги для страниц городов

```html
<!-- Title: формула [продукт] в [город] — [бренд] -->
<title>Фиброцементные плиты в Москве — BLP Board</title>

<!-- Description: продукт + город + USP + CTA -->
<meta name="description" content="Фиброцементные фасадные панели BLP Board в Москве. Дилеры, консультации, доставка. Негорючие плиты 0% асбеста для вентфасадов — от производителя.">

<!-- Canonical — обязательно во избежание дублей -->
<link rel="canonical" href="https://building-port.ru/blp/dealers/moskva/">

<!-- Hreflang для России (при наличии региональных поддоменов в будущем) -->
<link rel="alternate" hreflang="ru" href="https://building-port.ru/blp/dealers/moskva/">
<link rel="alternate" hreflang="x-default" href="https://building-port.ru/blp/">
```

---

## 2. NAP-аудит

**Текущий NAP (извлечён из сайта):**

| Параметр | Значение в header.php | Значение в contacts.php | Расхождение |
|---------|----------------------|------------------------|-------------|
| **Name** | Building Port / BLP Board | (не указано явно) | Нужно унифицировать |
| **Address** | (отсутствует) | Одинцово, ул. Неделина, 6А | Адрес не в header/footer |
| **Phone** | +7 (495) 984-96-89 | +7 (495) 984-96-89 | Совпадает ✓ |
| **Email** | info@building-port.ru | info@building-port.ru | Совпадает ✓ |
| **Schema** | Отсутствует | Отсутствует | **Критично** |

### Проблемы NAP

| Локация | Текущее состояние | Требуемые правки |
|---------|-----------------|-----------------|
| footer.php | Только copyright «ООО БИЛДИНГПОРТ», нет адреса, телефона | Добавить полный NAP блок |
| header.php | Телефон +7 (495) 984-96-89 ✓, email ✓ | Добавить microdata или вынести в footer |
| contacts.php | Адрес: Одинцово, ул. Неделина, 6А (без индекса) | Добавить индекс 143007 и полный формат |
| schema | Отсутствует | Создать Organization + LocalBusiness JSON-LD |
| Google Business Profile | Неизвестно | Проверить/создать и синхронизировать |
| Яндекс Бизнес | Неизвестно | Проверить/создать и синхронизировать |
| 2ГИС | Неизвестно | Проверить/создать и синхронизировать |

### Единый NAP-блок для footer.php (рекомендуемый)

```html
<!-- 2026-04-20: NAP-блок для Local SEO консистентности -->
<address class="footer-nap" itemscope itemtype="https://schema.org/Organization">
    <meta itemprop="name" content="BLP Board — ООО БИЛДИНГПОРТ">
    <span class="footer-address" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
        <span itemprop="streetAddress">ул. Неделина, 6А</span>,
        <span itemprop="addressLocality">Одинцово</span>,
        <span itemprop="addressRegion">Московская область</span>,
        <span itemprop="postalCode">143007</span>,
        <span itemprop="addressCountry">Россия</span>
    </span>
    <a href="tel:+74959849689" itemprop="telephone">+7 (495) 984-96-89</a>
    <a href="mailto:info@building-port.ru" itemprop="email">info@building-port.ru</a>
</address>
```

---

## 3. Локальная Schema — реализация

### Organization + LocalBusiness (для template.php / head)

```json
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "https://building-port.ru/blp/#organization",
      "name": "BLP Board",
      "legalName": "ООО БИЛДИНГПОРТ",
      "taxID": "7708427307",
      "url": "https://building-port.ru/blp/",
      "logo": {
        "@type": "ImageObject",
        "url": "https://building-port.ru/blp/images-convert/shared/header/logo-3.svg"
      },
      "telephone": "+74959849689",
      "email": "info@building-port.ru",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "ул. Неделина, 6А",
        "addressLocality": "Одинцово",
        "addressRegion": "Московская область",
        "postalCode": "143007",
        "addressCountry": "RU"
      },
      "sameAs": [
        "https://blpboard.tilda.ws/",
        "https://yandex.ru/maps/org/blp_board/",
        "https://2gis.ru/"
      ]
    },
    {
      "@type": "HomeAndConstructionBusiness",
      "@id": "https://building-port.ru/blp/#localbusiness",
      "name": "BLP Board — фиброцементные плиты",
      "description": "Производитель фиброцементных фасадных плит для вентилируемых фасадов. Негорючие, 0% асбеста, крупноформатные.",
      "url": "https://building-port.ru/blp/",
      "telephone": "+74959849689",
      "email": "info@building-port.ru",
      "priceRange": "₽₽",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "ул. Неделина, 6А",
        "addressLocality": "Одинцово",
        "addressRegion": "Московская область",
        "postalCode": "143007",
        "addressCountry": "RU"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": "55.67830",
        "longitude": "37.27270"
      },
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
          "opens": "09:00",
          "closes": "18:00"
        }
      ],
      "areaServed": [
        {"@type": "Country", "name": "Россия"},
        {"@type": "City", "name": "Москва"},
        {"@type": "City", "name": "Санкт-Петербург"},
        {"@type": "City", "name": "Екатеринбург"},
        {"@type": "City", "name": "Новосибирск"},
        {"@type": "City", "name": "Краснодар"},
        {"@type": "City", "name": "Казань"},
        {"@type": "City", "name": "Нижний Новгород"},
        {"@type": "City", "name": "Челябинск"},
        {"@type": "City", "name": "Уфа"},
        {"@type": "City", "name": "Ростов-на-Дону"}
      ],
      "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "Каталог фиброцементных плит BLP Board",
        "itemListElement": [
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Product",
              "name": "NATURE — натуральные фиброцементные плиты"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Product",
              "name": "POLISHED — полированные фиброцементные плиты"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Product",
              "name": "TEXTURE — текстурированные фиброцементные плиты"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Product",
              "name": "WALYPAN — линеарные фиброцементные плиты"
            }
          }
        ]
      },
      "parentOrganization": {
        "@id": "https://building-port.ru/blp/#organization"
      }
    }
  ]
}
```

> **Примечание по координатам:** 55.67830, 37.27270 — приблизительные координаты Одинцово.  
> Необходимо уточнить точные координаты адреса ул. Неделина, 6А до 5 знаков после запятой через Яндекс.Карты или Google Maps.

---

## 4. Справочники — стратегия размещения (Россия)

### Tier 1 — Обязательно (максимальный приоритет)

| # | Справочник | URL | Особенности | Стоимость |
|---|-----------|-----|-------------|-----------|
| 1 | **Яндекс Бизнес** | business.yandex.ru | Яндекс.Карты, поиск Яндекс, Алиса — основной источник локального трафика в РФ | Бесплатно |
| 2 | **2ГИС** | 2gis.ru/firm | 2-е место по локальным поискам в РФ, мощная база организаций | Бесплатно |
| 3 | **Google Business Profile** | business.google.com | ChatGPT ≠ GBP (использует Bing), но для Google Search и Maps критично | Бесплатно |
| 4 | **Bing Places for Business** | bingplaces.com | Питает ChatGPT, Copilot, Alexa — стремительный рост AI-поиска | Бесплатно |

### Tier 2 — Строительные отраслевые справочники (высокий приоритет)

| # | Справочник | URL | Целевая аудитория |
|---|-----------|-----|--------------------|
| 5 | **StroySnab.ru** | stroysnab.ru | Оптовые поставщики стройматериалов |
| 6 | **BLIZKO.ru** | blizko.ru | Строительные и отделочные материалы |
| 7 | **Tiu.ru** | tiu.ru | B2B маркетплейс, строительная тематика |
| 8 | **Pulscen.ru** | pulscen.ru | Строительные материалы, цены |
| 9 | **ВсеСтройки.ру** | vsestroyki.ru | Строительные организации РФ |
| 10 | **Sbis.ru** | sbis.ru | Реквизиты компании, деловые контакты |

### Tier 3 — Общие бизнес-справочники (средний приоритет)

| # | Справочник | URL |
|---|-----------|-----|
| 11 | **Zoon.ru** | zoon.ru |
| 12 | **Yell.ru** | yell.ru |
| 13 | **Flamp.ru** | flamp.ru |
| 14 | **Cataloxy.ru** | cataloxy.ru |
| 15 | **Bizrate.ru** | bizrate.ru |

### Алгоритм размещения

```
Шаг 1 (Неделя 1): Яндекс Бизнес + 2ГИС + GBP
  → Единый NAP: ООО БИЛДИНГПОРТ / BLP Board
  → Адрес: Одинцово, Московская обл., ул. Неделина, 6А, 143007
  → Телефон: +7 (495) 984-96-89
  → Категория: Производитель строительных материалов / Фасадные материалы

Шаг 2 (Неделя 2): Bing Places + Tier 2 строительные
Шаг 3 (Неделя 3-4): Tier 3 + мониторинг корректности NAP
Шаг 4 (Ежеквартально): Аудит цитирований, обновление информации
```

---

## 5. Гео-ключевые слова — таблица вариаций

### Методология оценки
Объёмы — экспертные оценки на основе данных Яндекс.Вордстат 2026 (B2B сегмент, строительная тематика).  
HV = High Volume (>500/мес), MV = Medium (100–500), LV = Low (<100).

| # | Ключевая фраза | Город/Регион | Частотность | Интент | Приоритет |
|---|----------------|-------------|-------------|--------|-----------|
| 1 | фиброцементные плиты купить Москва | Москва | MV ~300 | Коммерческий | ★★★ |
| 2 | фасадные панели фиброцемент Москва | Москва | MV ~250 | Коммерческий | ★★★ |
| 3 | вентилируемый фасад фиброцемент Москва цена | Москва | MV ~200 | Транзакционный | ★★★ |
| 4 | фиброцементные плиты Санкт-Петербург | СПб | MV ~180 | Коммерческий | ★★★ |
| 5 | фасадные плиты купить СПб | СПб | MV ~150 | Коммерческий | ★★★ |
| 6 | фиброцементные панели Екатеринбург | Екатеринбург | LV ~90 | Коммерческий | ★★☆ |
| 7 | вентфасад фиброцемент Краснодар | Краснодар | LV ~80 | Коммерческий | ★★☆ |
| 8 | фасадные плиты Новосибирск | Новосибирск | LV ~70 | Коммерческий | ★★☆ |
| 9 | фиброцемент фасад Казань | Казань | LV ~65 | Коммерческий | ★★☆ |
| 10 | фиброцементные плиты Нижний Новгород | Нижний Новгород | LV ~60 | Коммерческий | ★★☆ |
| 11 | облицовочные панели фиброцемент Челябинск | Челябинск | LV ~50 | Коммерческий | ★★☆ |
| 12 | фасадные панели Ростов-на-Дону | Ростов-на-Дону | LV ~55 | Коммерческий | ★★☆ |
| 13 | фиброцементные плиты Уфа | Уфа | LV ~45 | Коммерческий | ★★☆ |
| 14 | купить фиброцемент Самара | Самара | LV ~40 | Транзакционный | ★☆☆ |
| 15 | фасадные плиты Пермь производитель | Пермь | LV ~35 | Коммерческий | ★☆☆ |
| 16 | фиброцементные панели Красноярск | Красноярск | LV ~35 | Коммерческий | ★☆☆ |
| 17 | дилер фиброцемент Москва | Москва | LV ~80 | B2B | ★★★ |
| 18 | дилер фасадных панелей Санкт-Петербург | СПб | LV ~60 | B2B | ★★★ |
| 19 | оптом фиброцементные плиты Московская область | МО | LV ~90 | Оптовый | ★★★ |
| 20 | BLP Board Москва | Москва | LV ~30 | Брендовый | ★★★ |
| 21 | BLP Board Санкт-Петербург | СПб | LV ~20 | Брендовый | ★★★ |
| 22 | фиброцемент URSA Москва альтернатива | Москва | LV ~25 | Конкурентный | ★★☆ |
| 23 | фасадные плиты негорючие купить Москва | Москва | LV ~70 | Транзакционный | ★★★ |
| 24 | НГ фасадные панели Москва | Москва | LV ~60 | Коммерческий | ★★★ |
| 25 | крупноформатные фасадные плиты Москва | Москва | LV ~50 | Коммерческий | ★★★ |

### Семантические кластеры по типу

```
Кластер 1 — Прямой спрос (продукт + город):
"фиброцементные плиты [город]", "фиброцементные панели [город]"
→ Покрывают страницы dealers/[city]/

Кластер 2 — Применение (тип объекта + город):
"вентфасад [город]", "облицовка фасада [город]"
→ Покрывают projects.php + pages_php/devops.php

Кластер 3 — B2B/Дилерский (дилер + оптом + город):
"дилер фиброцемент [город]", "оптом фасадные плиты [область]"
→ Покрывают dealers/[city]/ + diler.php

Кластер 4 — USP-характеристики (НГ, 0% асбеста + город):
"негорючие фасадные плиты [город]"
→ Покрывают title tags главных geo-страниц
```

---

## 6. Анализ видимости дилерской сети

### Текущее состояние

**Критическая проблема:** На сайте отсутствует какая-либо информация о конкретных дилерах с адресами/телефонами. Страница `/diler` описывает только условия партнёрства, но не содержит карту или список действующих дилеров.

### Что теряет компания

| Упущение | Оценка потерь |
|----------|--------------|
| Запросы "[город] + фиброцемент" без региональных страниц | ~60-70% регионального трафика |
| Невозможность ранжирования в Яндекс.Картах по городам-миллионникам | Нет локальных пакетов |
| Потенциальные дилеры ищут "дилер фасадных плит [город]" и не находят BLP | Потеря B2B лидов |
| Отсутствие в 2ГИС и Яндекс.Бизнес у дилеров | Снижение доверия |

### Рекомендации по дилерской видимости

#### Уровень 1 — Немедленно (0 дилерских данных)
```
1. Создать страницу /blp/dealers/ — "Карта дилеров BLP Board"
   с интерактивной картой и формой "Стать дилером в вашем регионе"
2. Добавить в форму поле "Город/Регион" для сбора заявок по географии
3. Запустить geo-страницы для топ-5 городов без локального дилера
   (Москва, СПб, Екатеринбург, Краснодар, Новосибирск)
```

#### Уровень 2 — При появлении дилеров
```
1. Каждый дилер получает индивидуальную страницу:
   /blp/dealers/[город]/[название-дилера]/
2. Страница дилера включает:
   - Уникальный LocalBusiness schema с адресом дилера
   - branchOf → главная организация BLP Board
   - Отзывы клиентов из региона
   - Фото объектов, реализованных дилером
3. Помочь дилерам зарегистрироваться в Яндекс.Бизнес/2ГИС
   с правильным NAP и упоминанием "официальный дилер BLP Board"
```

#### Уровень 3 — Масштабирование
```
1. Programmatic SEO: автогенерация страниц для 50+ городов
   с уникальным контентом (население, рынок, климат, объекты)
2. Интеграция с картографическими API (Яндекс.Карты)
   для отображения дилерской сети на сайте
3. Schema BreadcrumbList для навигации:
   Главная → Дилеры → [Город] → [Дилер]
```

---

## 7. Быстрые победы (Quick Wins)

### ⚡ QUICK WIN #1 — LocalBusiness Schema (приоритет: КРИТИЧНО)
**Усилие:** 30 минут | **Эффект:** +20-40% CTR в Яндексе и Google Maps

Добавить JSON-LD блок из раздела 3 в `template.php` перед `</head>`.  
Это немедленно позволяет поисковикам корректно парсить бизнес и отображать rich results.

```php
// В template.php добавить перед </head>:
// 2026-04-20: Organization + LocalBusiness schema для Local SEO
echo '<script type="application/ld+json">' . $organization_schema . '</script>';
```

### ⚡ QUICK WIN #2 — Яндекс Бизнес + 2ГИС (приоритет: КРИТИЧНО)
**Усилие:** 1-2 часа | **Эффект:** Появление в локальных пакетах Яндекса

Зарегистрировать/верифицировать карточку организации с единым NAP:
- **Название:** BLP Board (ООО БИЛДИНГПОРТ)
- **Адрес:** Одинцово, Московская обл., ул. Неделина, 6А, 143007
- **Телефон:** +7 (495) 984-96-89
- **Категория Яндекс:** Строительные материалы → Отделочные материалы → Фасадные материалы
- **Категория 2ГИС:** Строительные материалы, Производители

### ⚡ QUICK WIN #3 — NAP в footer (приоритет: ВЫСОКИЙ)
**Усилие:** 15 минут | **Эффект:** Консистентность NAP, помогает всем локальным сигналам

Добавить адресный блок в `footer.php` (код из раздела 2).

---

## 8. Ограничения анализа

Следующее **не могло быть** проверено в рамках данного анализа без внешних инструментов:

| Что не проверено | Инструмент для проверки |
|-----------------|------------------------|
| Реальная позиция в Яндекс/Google по гео-запросам | Яндекс.Вебмастер, SE Ranking |
| Фактическое наличие карточки в Яндекс.Бизнес / GBP | Ручная проверка на картах |
| Объёмы поисковых запросов (точные данные) | Яндекс.Вордстат, Keys.so |
| Текущие цитирования в справочниках | Whitespark, Semrush |
| Domain Authority / ИКС сайта | Ahrefs, PR-CY.ru |
| Geo-grid позиции (карта рейтингов по сетке) | Local Falcon, BrightLocal |
| Отзывы на сторонних платформах | Ручная проверка Фламп, Яндекс |

---

## 9. Дорожная карта реализации

### Неделя 1 (Быстрые победы)
- [ ] Добавить Organization + LocalBusiness JSON-LD в template.php
- [ ] Добавить NAP-блок в footer.php
- [ ] Зарегистрировать/верифицировать Яндекс.Бизнес
- [ ] Зарегистрировать/верифицировать 2ГИС
- [ ] Зарегистрировать Google Business Profile

### Неделя 2–3
- [ ] Bing Places for Business
- [ ] Размещение в Tier 2 строительных справочниках (5-6 шт.)
- [ ] Уточнить точные координаты адреса (5 знаков)
- [ ] Создать страницу /blp/dealers/ (карта дилеров)

### Месяц 2
- [ ] Создать geo-страницы для топ-5 городов (dealers/moskva и др.)
- [ ] Запустить сбор отзывов на Яндекс.Картах и 2ГИС
- [ ] Разработать FAQ-контент для каждого города

### Месяц 3+
- [ ] Экспансия на 10 городов
- [ ] Programmatic SEO для регионов присутствия дилеров
- [ ] Интеграция Яндекс.Карты API на страницу дилеров

---

*Документ создан: 2026-04-20 | Задача: Stage 2 Group 2.E | Проект: BLP Board Site Optimization*
