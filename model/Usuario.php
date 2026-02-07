<?php

namespace model;

use model\Database;
use model\utils;
use PDOException;
use PHPMailer\PHPMailer\PHPMailer;
use model\Mail;

class Usuario
{
  private $conexion;
  private $table;
  private $tableData;
  public function __construct()
  {
    $this->conexion = Database::getInstance();
    $this->table = 'usuarios';
    $this->tableData = 'select `u`.`id` AS `id`,`u`.`nombre` AS `nombre`, `u`.`apellido` AS `apellido`,`u`.`correo` AS `correo`,`u`.`activo` AS `activo`, `r`.`nombre` as name, `r`.`id` as rol  from (`lenguajeSystem`.`usuarios` `u` join `lenguajeSystem`.`roles` `r` on ((`r`.`id` = `u`.`rol`)))';
  }
  public function comprobar($datos)
  {
    $resultado = $this->conexion->readOnly('usuarios', $datos);
    if (empty($resultado)) {
      return false;
    }
    return $resultado;
  }
  public function userData($datos)
  {
    $resultado = $this->conexion->readOnly('usuarios', $datos);
    return $resultado;
  }

  public function login($datos)
  {
    try {
      $datos['correo'] = utils::sanearMail($datos['correo']);
      $clave = array_pop($datos);
      $resultado = $this->conexion->readOnly('usuarios', $datos);
      if (empty($resultado) || $resultado["activo"] !== 1) {
        throw new \Exception('Usuario no existe');
      }
      if (password_verify($clave, $resultado['clave'])) {
        $_SESSION['email'] = $resultado["correo"];
        $_SESSION['usuario'] = $resultado["nombre"] . " ".$resultado["apellido"] ;
        $_SESSION['id'] = $resultado["id"];
        $this->getRol($resultado['id']);
        return true;
      } else {
        return false;
      }
    } catch (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
  }

  public function setRol(int $id, int $rol): void
  {
    $this->conexion->update("usuarios", ['id' => $id], ["rol" => $rol]);
  }

  public function getRol($id)
  {
    try {
      $view = $this->tableData . ' where `u`.`id`  = ?';
      $rol = $this->conexion->query($view, ["id" => $id]);
      $_SESSION["rol"] = $rol[0]['name'];
    } catch (\Exception) {
      throw new \Exception('Fallo al obtener el usuario');
    }
  }


  public function registro(array $datos)
  {
    try {
      $resultado = $this->comprobar(['correo' => $datos['correo']]);
      if ($resultado != false) {
        if ($resultado['activo'] != 0) {
          throw new \PDOException('Usuario ya existente');
        }
      }
      $datos['nombre'] = utils::sanear($datos['nombre']);
      $datos['apellido'] = utils::sanear($datos['apellido']);
      $datos['correo'] = utils::sanearMail($datos['correo']);
      $datos['clave'] = password_hash($datos['clave'], PASSWORD_BCRYPT);
      if ($resultado != false && !empty($resultado['activo']) && $resultado['activo'] != 1) {
        $datos['activo'] = 1;
        $resultado = $this->conexion->update($this->table, ['correo' => $datos['correo']], $datos);
        return $resultado;
      }
      $resultado = $this->conexion->insert($this->table, $datos);
      return $resultado;
    } catch (\PDOException $err) {
      throw new \Exception("Error en el registro. Por favor, intenta de nuevo.");
    };
  }
  public function newPAssword(string $clave, array $datos)
  {
    try {
      $id_usuario = $this->comprobar($datos)['id'];
      $clave = password_hash($clave, PASSWORD_BCRYPT);
      $resultado = $this->conexion->modify('update usuarios set clave = :clave where id = :id', ['id' => $id_usuario, 'clave' => $clave], true);
      return $resultado;
    } catch (\PDOException $err) {
      throw new \Exception('Fallo al Cambiar la clave');
    }
  }

  public function getTotal($id = 0)
  {
    $view = $this->tableData . ' where activo = 1';
    try {
      $resultado = $this->conexion->query($view);
      return $resultado;
    } catch (\Throwable $th) {
      throw new \Exception($th->getMessage());
    }
  }
  public function setRecoverData($id, $token, $expires)
  {
    $view = 'UPDATE lenguajeSystem.usuarios SET reset_token=:reset_token, reset_expires=:reset_expires WHERE id=:id';
    try {
      return $this->conexion->query($view, ['id' => $id, 'reset_token' => $token, 'reset_expires' => $expires], true);
    } catch (\Throwable $th) {
      throw new \Exception($th->getMessage());
    }
  }


  public function EnviarCorreoRecuperacion($correo, $token)
  {
    try {
      $mail = new mail();
      $datos = [
        'adress' => $correo,
        'suject' => 'Correo de Recuperacion de Cuenta',
        'body' => "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Recuperar Cuenta</title></head><body><h1>Codigo de Recuperacion</h1><p>Hola, Tu codigo de recuperacion es el siguiente:<strong>$token</strong></p><br><p>En caso de no haber sido tù, cambia tu contraseña</p></body></html>",
        'altBody' => "Hola, Tu codigo de recuperacion es el siguiente:$token. En caso de no haber sido tù, cambia tu contraseña"
      ];
      $mail->sendMail($datos);
      return true;
    } catch (\Exception $th) {
      throw new \Exception($th->getMessage());
    }
  }
  public function actualizarUsuario(array $datos)
  {
    try {
      if (empty($datos['id'])) {
        throw new \Exception("ID de usuario no proporcionado");
      }
      // Sanitizar los datos
      $updateData = [];
      if (isset($datos['nombre'])) {
        $updateData['nombre'] = utils::sanear($datos['nombre']);
      }
      if (isset($datos['apellido'])) {
        $updateData['apellido'] = utils::sanear($datos['apellido']);
      }
      if (isset($datos['correo'])) {
        $updateData['correo'] = utils::sanearMail($datos['correo']);
      }
      if (isset($datos['clave']) && !empty($datos['clave'])) {
        $updateData['clave'] = password_hash($datos['clave'], PASSWORD_BCRYPT);
      }
      if (empty($updateData)) {
        throw new \Exception("No hay datos para actualizar");
      }
      $resultado = $this->conexion->update($this->table, ['id' => $datos['id']], $updateData);
      return $resultado;
    } catch (\PDOException $err) {
      throw new \Exception('Fallo al actualizar el usuario');
    }
  }
  public function usersDelete(int $id)
  {
    try {
      if (empty($id)) {
        throw new \Exception("ID de usuario no proporcionado");
      }
      $resultado = $this->conexion->update($this->table, ['id' => $id], ['activo' => 0]);
      return $resultado;
    } catch (\PDOException $err) {
      throw new \Exception('Fallo al eliminar el usuario');
    }
  }
  public function verifyPassword($clave, $usuario)
  {
    $resultado = $this->conexion->readOnly('usuarios', ["id" => $usuario]);
    return password_verify($clave, $resultado["clave"]);
  }
  public function getTotalAdmins()
  {
    $resultado = $this->conexion->query('select count(*) as total from usuarios where rol = ? and activo = ?', ["rol" => 1, 'activo' => 1]);
    return $resultado;
  }

  public function setAllAnalistasExcept(int $id)
  {
    try {
      $sql = "UPDATE usuarios SET rol = 3 WHERE id != :id";
      $this->setRol($id, 1);
      $this->conexion->modify($sql, ['id' => $id], true);
      return true;
    } catch (\PDOException $err) {
      throw new \Exception('Fallo al actualizar los roles de los usuarios');
    }
  }
}
