<?php

use model\Usuario;

if (isset($_GET["id"])) {
  try {
    $usuarios = (new Usuario)->getTotal($_GET["id"]);
    header("Content-Type:application/json");
    echo json_encode($usuarios[0]);
    die();
  } catch (\Exception $e) {
    $_SESSION["error"] = $e;
    die();
  }
}

try {
  $usuarios = (new Usuario)->getTotal();
} catch (\Exception $e) {
  $_SESSION["error"] = $e;
}
require_once "./views/usuarios/usuarios_list.view.php";
