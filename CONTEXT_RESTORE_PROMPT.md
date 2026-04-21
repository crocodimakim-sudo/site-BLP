# 🚀 ПРОМТ ДЛЯ НОВОГО ЧАТА — ВОССТАНОВЛЕНИЕ КОНТЕКСТА

**Используй этот промт в новом чате на claude.ai/code чтобы продолжить работу с того же места.**

---

## 📋 СКОПИРУЙ И ВСТАВЬ В НОВЫЙ ЧАТ:

```
# BLP Board Website Rehabilitation — ПРОДОЛЖЕНИЕ РАБОТЫ

## Статус проекта
Проект: D:\Claude Code\site-blp\site-kimi\ (PHP сайт фиброцементных панелей)

**Что было сделано:**
✅ Полный комплексный аудит (27 PHP + 21 CSS + 9 JS файлы)
✅ Deep-dive lane-анализ мобильной адаптивности (Lane 1/2/3)
✅ Интегрирован план 4 этапов (критические исправления → SEO → архитектура → контент)
✅ Подготовлены документы для начала Этапа 1

**Текущий этап:** Этап 1 — Критические исправления (неделя 1)

---

## 📁 КРИТИЧНЫЕ ДОКУМЕНТЫ (читай в таком порядке):

1. **AUDIT_INTEGRATION_SUMMARY.md** ← Сводка что произошло (5 мин)
2. **GLOBAL_PLAN.md** ← Полный план с параллельными работами (10 мин)
3. **FULL_AUDIT_REPORT.md** ← Все 20 критических проблем (если интересуют детали)
4. **html_preview/PREVIEW_PLAN.md** ← Lane-аудит (Lane 1/2/3 мобильной адаптивности)

---

## 🎯 ЧТО ДЕЛАТЬ СЕЙЧАС (Этап 1):

### Группа 1.A: Безопасность PHP (КРИТИЧЕСКАЯ)
- [ ] Task 1.A.1: CSRF-токены в contact-form.php + send-form.php
- [ ] Task 1.A.2: Honeypot + rate limiting в send-form.php
- [ ] Task 1.A.3: Email-injection фильтрация в send-form.php
- [ ] Task 1.A.4: Логирование ошибок mail() в send-form.php

### Группа 1.B: JavaScript безопасность (параллельно 1.A)
- [ ] Task 1.B.1: XSS в projects.js (innerHTML → textContent)
- [ ] Task 1.B.2: response.ok во всех fetch (contact-form.js, contacts.js, projects.js)
- [ ] Task 1.B.3: AbortController для fetch таймаутов

### Группа 1.C: HTML баги (параллельно 1.A, 1.B)
- [ ] Task 1.C.1: Удалить лишний `</body>` в pages_php/catalog.php:421
- [ ] Task 1.C.2: Добавить `<h1>` в pages_php/catalog.php
- [ ] Task 1.C.3: Исправить `href="#"` → `/blp/contacts` в pages_php/diler.php:36
- [ ] Task 1.C.4: `/policy` → `/blp/policy` в blocks/contact-form.php, pages_php/contacts.php

### Группа 1.D: CSS архитектура (Lane 1/2/3)
- [ ] Task 1.D.1: Создать css/base.css (root, reset, типография)
- [ ] Task 1.D.2: Создать css/components.css (.btn, .card, .badge)
- [ ] Task 1.D.3: Убрать !important из h1–h4 в css/main.css:158–176
- [ ] Task 1.D.4: Мобильные breakpoints (Lane 2: 900px, 640px для h1–h4)
- [ ] Task 1.D.5: Унифицировать padding (Lane 1: 16px везде)
- [ ] Task 1.D.6: Унифицировать breakpoints (Lane 3: 1200px → 960px → 640px)
- [ ] Task 1.D.7: Удалить дубли из index.css, devops.css, diler.css, hero-section.css

### Группа 1.E: Доступность (параллельно 1.D)
- [ ] Task 1.E.1: Восстановить focus indicators в css/header.css:82–86
- [ ] Task 1.E.2: Исправить контраст footer opacity 0.45 → 0.7 в css/footer.css:62–69

---

## 👥 ИСПОЛЬЗОВАТЬ АГЕНТОВ И СКИЛЫ:

### День 1: Группы 1.A + 1.B + 1.C параллельно
```
/oh-my-claudecode:ultrawork

Агент 1 (security-reviewer): Group 1.A
Агент 2 (code-simplifier): Group 1.B
Агент 3 (designer): Group 1.C
```

### День 2–3: Группы 1.D + 1.E параллельно
```
/oh-my-claudecode:team

Lead (executor): Task 1.D.1 (create base.css)
Agent 2 (code-simplifier): Task 1.D.2–1.D.6 (параллельно, после 1.D.1)
Agent 3 (designer): Task 1.E.1–1.E.2 (независимы)

После 1.D.1:
Lead: Task 1.D.7 (удалить дубли)
```

---

## 🔌 ОБЯЗАТЕЛЬНЫЕ ПЛАГИНЫ:

- ✅ `plugin:context7:context7` (PHP docs)
- ✅ `plugin:oh-my-claudecode` (агенты/скилы)
- ✅ `mcp__ide__executeCode` (проверка PHP)
- 🔗 `gstack:browse` (проверка в браузере)

---

## ⚠️ ВАЖНЫЕ ПРАВИЛА:

1. **ВСЕГДА синхронизировать в XAMPP после каждого изменения:**
   ```bash
   cp -f "D:/Claude Code/site-blp/site-kimi/[файл]" "C:/xampp/htdocs/blp/[файл]"
   ```

2. **НИКОГДА не говорить "готово" без проверки:**
   - Открыть в браузере http://localhost/blp/
   - Проверить curl на HTTP 200
   - Убедиться что картинки загружаются

3. **Все изображения в D:\Claude Code\site-blp\site-kimi\images\**
   - Только там! Больше нигде!

4. **Используй Context7 для PHP/CSS docs:**
   ```
   /plugin:context7:context7 (query docs) — при вопросах про синтаксис
   ```

---

## 📊 СРОКИ:

- **Этап 1:** 2026-04-21 → 2026-04-26 (1 неделя)
- **Этап 2:** 2026-04-27 → 2026-04-29 (1–2 недели, SEO)
- **Этап 3:** 2026-04-30 → 2026-05-04 (2–3 недели, архитектура)
- **ЗАПУСК:** 2026-05-05 (после Этапа 3)

---

## 📞 ФАЙЛЫ ПРОЕКТА:

```
D:\Claude Code\site-blp\site-kimi\
├── pages_php/               ← PHP страницы (index.php, catalog.php, и т.д.)
├── blocks/                  ← Повторяемые блоки (header, footer, contact-form, и т.д.)
├── css/                     ← Стили (будут изменены в Этап 1.D)
├── js/                      ← JavaScript (будут изменены в Этап 1.B)
├── images/                  ← Оригинальные изображения
├── html_preview/            ← Preview CSS + документация
├── .claude_work_log/        ← Логирование всех работ
├── GLOBAL_PLAN.md           ← ОСНОВНОЙ ПЛАН (4 этапа)
├── AUDIT_INTEGRATION_SUMMARY.md  ← Сводка (читай первым!)
├── MORNING_BRIEF.md         ← Справка на утро
└── .htaccess, robots.txt, sitemap.xml  ← Конфиги (будут обновлены в Этап 2)
```

---

## 🚀 ПЕРВЫЙ ШАГИ В НОВОМ ЧАТЕ:

1. Прочитай AUDIT_INTEGRATION_SUMMARY.md (5 мин)
2. Прочитай GLOBAL_PLAN.md раздел "ПАРАЛЛЕЛЬНОЕ ВЫПОЛНЕНИЕ" (10 мин)
3. Запусти `/oh-my-claudecode:ultrawork` на Group 1.A + 1.B + 1.C
4. После завершения → запусти `/oh-my-claudecode:team` на Group 1.D + 1.E

---

## 🔑 КРАТКАЯ СПРАВКА:

**Что нужно исправить в Этап 1:**
- 6 уязвимостей безопасности (CSRF, XSS, email-injection, rate limit, fetch errors, logging)
- 4 критических бага HTML (лишний </body>, нет h1, битые ссылки, неправильные пути)
- 5 проблем CSS архитектуры (113 !important, 15 breakpoints, дубли, отступы, шрифты)
- 2 проблемы доступности (focus indicators, контраст)

**Всего:** 20 задач, но параллельно за 3–4 дня вместо 11–12 дней!

---

**Создано:** 2026-04-20  
**Для:** Быстрого восстановления контекста в новом чате  
**Версия:** 1.0
```

---

## 📌 КАК ИСПОЛЬЗОВАТЬ:

1. **Открой новый чат** на claude.ai/code
2. **Скопируй весь текст выше** (с маркированием # ПРОМТ)
3. **Вставь в новый чат**
4. **Claude автоматически** загрузит контекст и будет готов продолжить

---

## 💡 АЛЬТЕРНАТИВА (если контекст потеряется):

Если новый чат не загрузит файлы автоматически:
1. Открой `.claude_work_log/RESUME.md` (быстрый старт)
2. Открой `AUDIT_INTEGRATION_SUMMARY.md` (что произошло)
3. Открой `GLOBAL_PLAN.md` (текущий план)
4. Вставь этот промт в новый чат

---

**Готово! Используй этот промт для безшовного продолжения работы.**
