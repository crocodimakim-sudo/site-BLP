<?php
// 2026-04-20: DEPRECATED — this file is a thin wrapper to blocks/template.php
// blocks/template.php is the production template with GA4, OG, Twitter Card, canonical support
// All pages should use blocks/template.php directly via `include '../blocks/template.php'`
// This wrapper exists for backward compatibility with pages that do `include 'template.php'`
include __DIR__ . '/../blocks/template.php';
