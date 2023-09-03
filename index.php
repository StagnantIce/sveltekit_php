<?php

session_start();

if ($_SERVER['HTTP_HOST'] === 'localhost') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

const BACKEND_PATH = __DIR__ . '/backend';
const BUILD_PATH = __DIR__ . '/build';

$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$pathWithoutSlash = trim(substr($path, 1) ?: 'index', '/');
$htmlFile = BUILD_PATH . "/$pathWithoutSlash.html";

$phpData = [];
$request = null;

if (file_exists(BACKEND_PATH . '/routes.php')) {
    $dynamicRoutes = require_once(BACKEND_PATH . '/routes.php');
    if (!file_exists($htmlFile)) {
        foreach ($dynamicRoutes as $key => $file) {
            if (preg_match($key, $pathWithoutSlash, $params)) {
                $pathWithoutSlash = $file;
                $htmlFile = BUILD_PATH . "/$pathWithoutSlash.html";
                $request = array_slice($params, 1);
            }
        }
    }
}

$data = '';
if (file_exists($htmlFile)) {
    $data = file_get_contents(BUILD_PATH . "/$pathWithoutSlash.html");
    $phpDataFile = BACKEND_PATH . "/$pathWithoutSlash.php";

    if (file_exists($phpDataFile)) {
        $result = require_once($phpDataFile);
        if (is_array($result)) {
            $phpData = array_merge($phpData, $result);
        }
    }
} else {
    http_response_code(404);
}

echo str_replace(
    '%sveltekit.php%',
    json_encode($phpData, JSON_THROW_ON_ERROR),
    preg_replace_callback('/%phpData\.([-_a-z]*)\[?(\d+)?\]?\.?([-_a-z]*)\[?(\d+)?\]?%/i', function ($matches) use ($phpData) {
        $params = array_slice($matches, 1);
        $slug1 = $params[0] ?? null;
        $id1 = $params[1] ?? null;
        $slug2 = $params[2] ?? null;
        $id2 = $params[3] ?? null;
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
