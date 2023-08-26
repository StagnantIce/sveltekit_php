<?php

$backendPath = __DIR__ . '/backend';
$buildPath = __DIR__ . '/build';

$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$pathWithoutSlash = substr($path, 1) ?: 'index';
$htmlFile = "$buildPath/$pathWithoutSlash.html";

$phpData = [];
$request = null;

if (file_exists($backendPath . '/routes.php')) {
    $dynamicRoutes = require_once($backendPath . '/routes.php');
    if (!file_exists($htmlFile)) {
        foreach ($dynamicRoutes as $key => $file) {
            if (preg_match($key, $pathWithoutSlash, $params)) {
                $pathWithoutSlash = $file;
                $htmlFile = "$buildPath/$pathWithoutSlash.html";
                $request = array_slice($params, 1);
            }
        }
    }
}

$data = file_get_contents("$buildPath/$pathWithoutSlash.html");
$phpDataFile = "$backendPath/$pathWithoutSlash.php";

if (file_exists($phpDataFile)) {
    $result = require_once($phpDataFile);
    if (is_array($result)) {
        $phpData = array_merge($phpData, $result);
    }
}
echo str_replace(
    '%sveltekit.php%',
    json_encode($phpData),
    preg_replace_callback('/%phpData\.([-_a-z]*)\[?(\d+)?\]?\.?([-_a-z]*)\[?(\d+)?\]?%/i', function ($matches) use ($phpData) {
        list($slug1, $id1, $slug2, $id2) = array_slice($matches, 1);
        $result = $phpData;
        if (isset($slug1) && $slug1 !== '' && isset($result[$slug1])) {
            $result = $result[$slug1];
        }
        if (isset($id1) && $id1 !== '' && isset($result[(int)$id1])) {
            $result = $result[(int)$id1];
        }
        if (isset($slug2) && $slug2 !== '' && isset($result[$slug2])) {
            $result = $result[$slug2];
        }
        if (isset($id2) && $id2 !== '' && isset($result[(int)$id2])) {
            $result = $result[(int)$id2];
        }

        return is_string($result) ? $result : '';
    }, $data)
);
