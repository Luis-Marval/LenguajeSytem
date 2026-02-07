<?php

namespace model;

use Exception;
use PDOException;
use model\Database;

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
      if (!empty($dato['dato'])) {
        $table .= ' WHERE nombre LIKE :dato OR apellido LIKE :dato OR cedula LIKE :dato OR email LIKE :dato OR telefono LIKE :dato';
        $datoString = $dato['dato'];
        $dato['dato'] = "%$datoString%";
      }
      if (!empty($dato['cedula'])) {
        $table .= ' WHERE cedula = :cedula';
      }
      if (!empty($limit)) {
        $min = $limit["min"] ?? 0;
        $max = $limit["max"] ?? 10;
        $table .= " limit $max offset $min";
      }
      $res = $this->conexion->query("$table", $dato, true);

      return $res;
    } catch (\PDOException $err) {
      throw new \Exception($err->getMessage());
    }
  }

  public function getEstudiantePeriodo($dato): array|\PDOException
  {
    try {
      return $this->conexion->readOnly('estudiante_periodo', $dato);
    } catch (\PDOException $err) {
      throw new \Exception($err->getMessage());
    }
  }

  public function countEstudiantes($idPeriodo = 0)
  {
    if ($idPeriodo == 0) {
      $res = $this->conexion->query('SELECT count(*) as total FROM estudiantes');
    } else {
      $res = $this->conexion->query('SELECT count(*) as total FROM estudiante_periodo where periodo_id = :periodo_id', ['periodo_id' => $idPeriodo], true);
    }
    $res = $res[0]['total'];
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
        if (strpos($err, 'telefono') !== false) {
          throw new \Exception('Numero Telefonico Duplicado, Por favor utilice otro');
        }
        if (strpos($err, 'email') !== false) {
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

  public function verificarAlumno($datos)
  {
    try {
      $query =  $this->conexion->query('select p.idClase,p.id,ep.fecha_inscripcion from estudiantes e left join estudiante_periodo ep on ep.estudiante_id = e.cedula left join Periodo p on ep.periodo_id = p.id where e.cedula = :estudiante_id and p.idDate = 1 and p.id != :periodo_id order by ep.periodo_id DESC limit 1', ['estudiante_id' => $datos['estudiante_id'], 'periodo_id' => $datos['periodo_id']], true);
      if (!empty($query[0]['idClase'])) {
        $fecha = new \DateTime($query[0]['fecha_inscripcion']);
        $fechaActual = new \DateTime(); // Fecha y hora actual

        // Calcular la diferencia
        $diferencia = $fechaActual->diff($fecha);

        // Convertir diferencia a horas totales
        $horasDiferencia = ($diferencia->days * 24) + $diferencia->h;
        // También considerar minutos para precisión (opcional)
        $horasDiferencia += $diferencia->i / 60;

        // Retornar false si hay más de 24 horas (como solicitaste)
        if (abs($horasDiferencia) < 24) {
          return ['id' => $query[0]['id']];
        } else {
          $count = $this->countEstudiantes($datos['periodo_id']);
          if ($count >= 5) {
            return true;
          } else {
            return false;
          }
        }
      }
      return true;
    } catch (\Exception $err) {
      $errorMessage = $err->getMessage();
      throw $err;
    };
  }
}
