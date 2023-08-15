<?php

$backendPath = __DIR__ . '/backend';
$buildPath = __DIR__ . '/build';

$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$pathWithoutSlash = substr($path, 1) ?: 'index';
$htmlFile = "$buildPath/$pathWithoutSlash.html";

$phpData = [];

if (file_exists($backendPath . '/routes.php')) {
    $dynamicRoutes = require_once($backendPath . '/routes.php');
    if (!file_exists($htmlFile)) {
        foreach ($dynamicRoutes as $key => $file) {
            if (preg_match($key, $pathWithoutSlash, $params)) {
                $pathWithoutSlash = $file;
                $htmlFile = "$buildPath/$pathWithoutSlash.html";
                $phpData['request'] = array_slice($params, 1);
            }
        }
    }
}

$data = file_get_contents("$buildPath/$pathWithoutSlash.html");
$phpDataFile = "$backendPath/$pathWithoutSlash.php";

if (file_exists($phpDataFile)) {
    $phpData = array_merge($phpData, require_once($phpDataFile));
}
echo str_replace('%sveltekit.php%', json_encode($phpData), $data);
