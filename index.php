<?php
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private, must-revalidate');
session_cache_expire(60);
date_default_timezone_set('America/Caracas');
setlocale(LC_TIME, 'es_ES.utf8', 'spa', 'es_ES', 'es');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once(__DIR__ . '/config/config.php');
require_once(__DIR__ . '/config/router.php');
require "vendor/autoload.php";
Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../')->load();


spl_autoload_register(function ($className) {
  // Convierte namespace a ruta de archivo
  $file = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';

  if (file_exists($file)) {
    require_once $file;
    return true;
  }
  return false;
});

if (URL === '/prueba') {
  require_once('./prueba.php');
  die();
}
function checkAccessByRole()
{
  if (strpos(URL, '/login') === 0 || strpos(URL, '/home') === 0 ||  strpos(URL, '') === 0) return;

  require_once(__DIR__ . '/config/permisos.php');
  $allowed = false;
  if (array_key_exists($_SESSION['rol'], $Permisos)) {
    $AllowedFolders = $Permisos[$_SESSION['rol']];
    foreach ($AllowedFolders as $folder) {
      if (URL === $folder) {
        $allowed = true;
        break;
      }
    }
  }
  if (!$allowed) {
    http_response_code(403);
    require_once("./views/403.view.php");
    die();
  }
}
/*
  ! Este foreach es el que permite cargar los archivos en base a la url
*/

if (array_key_exists(URL, $routes)) {
  if ((!isset($_SESSION['usuario']) || !isset($_SESSION['rol'])) && strpos($routes[URL], '/login') === false) {
    header("location:" . PATH . "login");
    die();
  };
  if (!empty($_SESSION['rol']) && $_SESSION['rol'] !== 'admin') {
    checkAccessByRole();
  }
  require_once("./controller" . $routes[URL] . ".php");
  die();
}

// ! En caso de no Existir se retorna un error 404 

http_response_code(404);
require_once("./views/404.view.php");
