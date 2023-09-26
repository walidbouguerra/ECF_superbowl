<?php

session_start();

// Charge automatiquement les classes
spl_autoload_register(function($class)
{
    $class = str_replace("\\", "/", $class);
    if(file_exists('../app/controllers/' . $class . '.php')) {
        require_once '../app/controllers/' . $class . '.php';
    } elseif (file_exists('../app/models/' . $class . '.php')) {
        require_once '../app/models/' . $class . '.php';
    }
});


// Charge les fonctions du fichier utils.php
require_once '../app/utils.php';

$url = $_SERVER['QUERY_STRING'] ?? null;

$url = explode("/", filter_var($url, FILTER_SANITIZE_URL));

$controller = !empty($url[0]) ? $url[0] : 'game';
$action = !empty($url[1]) ? $url[1] : 'home';
$param = $url[2] ?? null;
$param2 = $url[3] ?? null;

// Récupère les paramètres d'url
if (!empty($url[0]) && !empty($url[1])) {
    $controller = htmlspecialchars($url[0]);
    $action = htmlspecialchars($url[1]);
    $param = htmlspecialchars($param);
    $param2 = htmlspecialchars($param2);
} else {
    // Affiche la page d'accueil
    $controller = 'game';
    $action = 'home';
}

// Appelle un contrôleur et son action
router($controller, $action, $param, $param2);



