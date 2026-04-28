<?php
// 2026-04-27: инициализация сессии и CSRF-токена — инклудить ДО ob_start() на всех страницах с формами
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
