<?php
$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$pathWithoutSlash = substr($path, 1) ?: 'index';
require_once(__DIR__ . "/build/$pathWithoutSlash.html");
