<?php

namespace model;

use Exception;
use model\Database;
use PDOException;
use model\utils;
use PDO;

class Estudiante
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

  public function getEstudiante($dato = [], $limit = []): array|\PDOException
  {
    try {
      $table = "select * from estudiantes";
      if ((empty($limit) && !empty($dato))) {
        $searchData = array_key_first($dato);
        $res = $this->conexion->query("$table where $searchData = ? limit 1", $dato);
        return $res;
      }
      $min = $limit["min"] ?? 0;
      $max = $limit["max"] ?? 10;
      if (!empty($dato)) {
        $table .= ' WHERE nombre LIKE :dato OR apellido LIKE :dato OR cedula LIKE :dato OR email LIKE :dato OR telefono LIKE :dato';
        $datoString = $dato['dato'];
        $dato['dato'] = "%$datoString%";
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
  public function countEstudiantes($idPeriodo = 0)
  {
    if($idPeriodo == 0){
      $res = $this->conexion->query('SELECT count(*) FROM estudiantes');
    }else{
      $res = $this->conexion->query('SELECT count(*) FROM estudiante_periodo where periodo_id = :periodo_id',['periodo_id' => $idPeriodo],true);
    }
    return $res;
  }

  public function setEstudiante($datos): bool
  {
    try {
      $res = $this->conexion->insert('estudiantes', $datos);
      return true;
    } catch (\Exception $err) {
      if (
        strpos($err, 'Duplicate entry') !== false ||
        strpos($err, '1062') !== false ||
        strpos($err, '23000') !== false
      ) {
        if(strpos($err, 'telefono') !== false){
          throw new \Exception('Numero Telefonico Duplicado, Por favor utilice otro');
        }
        if(strpos($err, 'email') !== false){
          throw new \Exception('Correo Duplicado, Por favor utilice otro');
        }
        return true;
      }
      throw new \Exception($err->getMessage());
    }
  }

    public function updateEstudante($cedula, $datos)
  {
    try {
      $res = $this->conexion->update('estudiantes', ['cedula' => $cedula], $datos);
      return $res;
    } catch (\Exception $err) {
      throw new \Exception($err->getMessage());
    }
  }

}
