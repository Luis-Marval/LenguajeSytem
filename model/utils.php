<?php

namespace model;

class utils
{
  static public function sanear($variable)
  {
    if (static::vacia($variable)) {
      throw new \Exception("Hay uno o mas espacios vacios");
    }
    if (is_array($variable)) {
      foreach ($variable as $value) {
        $value = trim(htmlspecialchars(strip_tags($value)));
      }
    }else{
      $variable = trim(htmlspecialchars(strip_tags($variable)));
    }
    unset($value);
    return $variable;
  }

  static public function sanearMail(string $variable): string
  {
    static::vacia($variable);
    $result = filter_var($variable, FILTER_SANITIZE_EMAIL);
    if (strpos($result, '@') === false || strpos($result, '.') === false) {
      throw new \Exception("El correo ingresado no es valido");
    }
    return $result;
  }

  static public function vacia($variable): bool
  {
    if (is_array($variable)) {
      foreach ($variable as $value) {
        if (empty($value || $value == null)) {
          throw new \Exception("Hay uno o mas espacios vacios");
        }
      }
    }
    if (empty($variable)) {
      throw new \Exception("Hay uno o mas espacios vacios");
    } else {
      return false;
    }
  }

  static public function filter_list(array $array, string $search, string $Option): false | array
  {
    switch ($Option) {
      case "fecha_nacimiento":
        $search = (new \DateTime($search))->format('Y-m-d');
      break;
    }
    return $array = array_filter($array, function ($array) use ($search, $Option) {
      return strpos($array[$Option], $search)  !== false;
    });
  }
  static public function permisos($rol_list = "admin")
  {
    if ($_SESSION["rol"] !== $rol_list) {
      http_response_code(403);
      require_once("./views/403.view.php");
      die();
    }
  }
}
