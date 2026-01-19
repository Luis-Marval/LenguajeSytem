<?php

namespace model;

use Exception;
use model\Database;
use PDOException;

class Profesores
{
  private $conexion;
  public function __construct()
  {
    $this->conexion = Database::getInstance();
  }
  public function getGrado(): array|\PDOException
  {
    try {
      $res = $this->conexion->readMany('grado');
      return $res;
    } catch (\PDOException $err) {
      throw new \Exception($err->getMessage());
    }
  }

  public function getProfesor($dato = [], $limit = []): array|\PDOException
  {
    try {
      $table = "select * from profesores";
      // caundo solo se busca un resultado
      if ((empty($limit) && !empty($dato))) {
        $searchData = array_key_first($dato);
        $res = $this->conexion->query("$table where $searchData = ? limit 1", $dato);
        return $res;
      }
      $min = $limit["min"] ?? 0;
      $max = $limit["max"] ?? 10;
      if (!empty($dato)) {
        $table .= ' WHERE (nombre LIKE :dato OR apellido LIKE :dato OR cedula LIKE :dato OR email LIKE :dato OR telefono LIKE :dato) AND status = 1';
        $datoString = $dato['dato'];
        $dato['dato'] = "%$datoString%";
      } else {
        $table .= ' WHERE  status = 1';
      }
      if (!empty($limit)) {
        $table .= " limit $max offset $min";
      }
      $res = $this->conexion->query("$table", $dato, true);

      return $res;
    } catch (\PDOException $err) {
      throw new \Exception($err->getMessage());
    }
  }
  public function countProfesores()
  {
    $res = $this->conexion->query('SELECT count(*) FROM profesores where status = 1');
    return $res;
  }
  public function setProfesor($datos): bool|\PDOException
  {
    try {
      $res = $this->conexion->insert('profesores', $datos);
      return true;
    } catch (\PDOException $err) {
      throw new \Exception($err->getMessage());
    }
  }

  public function updateProfesor($cedula, $datos)
  {
    try {
      $res = $this->conexion->update('profesores', ['cedula' => $cedula], $datos);
      return $res;
    } catch (\Exception $err) {
      throw new \Exception($err->getMessage());
    }
  }
  public function eliminarProfesor($cedula)
  {
    try {
      $res = $this->conexion->update('profesores', ['cedula' => $cedula], ['status' => 0]);
      return $res;
    } catch (\Exception $err) {
      throw new \Exception($err->getMessage());
    }
  }
  public function lastProfesor($clase, $periodo)
  {
    $view = "SELECT c.id,p.id,p.idProfesor  from clases c left join Periodo p on p.idClase = c.id  WHERE idClase = :idClase AND p.id < :periodo_id ORDER BY p.id DESC LIMIT 1;";
    try {
      $res = $this->conexion->query($view, ['idClase' => $clase, 'periodo_id' => $periodo],true);
      if(empty($res)){
        return false;
      }
      return $res[0]['idProfesor'];

      return $res;
    } catch (\Exception $err) {
      throw new \Exception($err->getMessage());
    }
  }
}
