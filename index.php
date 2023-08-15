<?php
$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$pathWithoutSlash = substr($path, 1) ?: 'index';
echo require_once(__DIR__ . "/build/$pathWithoutSlash.html");
