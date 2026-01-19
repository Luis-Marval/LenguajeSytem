<?php
$folderPath = dirname($_SERVER['SCRIPT_NAME']);
$urlPath = $_SERVER['REQUEST_URI'];
$url = substr($urlPath, strlen($folderPath));
if (strpos($url, '?') !== false) {
  $url = strstr($url, '?', true);
}

$uploadDir = realpath(__DIR__.'/../src/images/cedulas');
if ($uploadDir === false) {
  // intentar crear el directorio si no existe
  $uploadDir = __DIR__ . '/../../src/images/cedulas';
  if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
    throw new Exception("No se puede crear el directorio de destino.");
  }
  $uploadDir = realpath($uploadDir);
}
define('ROOT', dirname($_SERVER['SCRIPT_NAME']));
define('PATH', ROOT);
define('URL', "/" . $url);
define('CompleteURL', ROOT . $url);
define('CompletePath', $urlPath);
define('targetSubmit', $uploadDir);
