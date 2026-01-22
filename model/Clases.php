<?php

namespace model;

use Exception;
use model\Database;
use model\Estudiante;


class Clases
{
  private $conexion;
  public function __construct()
  {
    $this->conexion = Database::getInstance();
  }
  public function getIdiomas()
  {
    $view = 'select * from idiomas';
    try {
      $resultado = $this->conexion->query($view);
      return $resultado;
    } catch (\Throwable $th) {
      throw new \Exception($th->getMessage());
    }
  }
  public function createClase($datos)
  {
    try {
      $res = $this->conexion->insert('clases', $datos);
      return $res;
    } catch (\Exception $err) {
      $errorMessage = $err->getMessage();
      if (
        strpos($errorMessage, 'ya existe una clase') !== false ||
        strpos($errorMessage, 'Duplicate entry') !== false ||
        strpos($errorMessage, '1062') !== false ||
        strpos($errorMessage, '23000') !== false
      ) {
        return true;
      }
      throw $err;
    };
  }
  public function getClase($id)
  {
    $view = "select * from clases where id = ?";
    try {
      $res = $this->conexion->query($view, ['id' => $id]);
      return $res;
    } catch (\Exception $err) {
      $errorMessage = $err->getMessage();
      throw $err;
    };
  }

  public function countClasesPeriodos()
  {
    try {
      $view = 'select count(*) from clasesActivas';
      $res = $this->conexion->query($view);
      return $res;

      return $res;
    } catch (\Exception $err) {
      throw $err;
    };
  }

  public function getClasesPeriodos($id = 0, $limit = [])
  {
    $view = "select * from clasesActivas";
    try {
      if ($id == 0) {
        if (!empty($limit)) {
          $min = $limit["min"] ?? 0;
          $max = $limit["max"] ?? 10;
          $view .= " limit $max offset $min";
        }
        $res = $this->conexion->query($view);
        return $res;
      }
      $view = 'SELECT
    c.id,
    i.name,
    c.tipo,
    c.horario,
    c.nivel,
    c.horaInicio,
    c.horaFin,
    p.id as idPeriodo,
    pd.status AS statusPeriodo
FROM
    clases c
LEFT JOIN Periodo p ON
    c.id = p.idClase
LEFT JOIN idiomas i ON
    i.id = c.idioma
LEFT JOIN periodoDate pd ON
    pd.id = p.idDate where c.id = ?';
      $res = $this->conexion->query($view, ['id' => $id]);
      return $res;
    } catch (\Exception $err) {
      throw $err;
    };
  }

  public function getHistorialClases($limit)
  {
    $view = "SELECT p.*,p.id as idPeriodo,c.*,i.name AS name,pd.* FROM Periodo p INNER JOIN profesores prof ON p.idProfesor = prof.cedula INNER JOIN clases c ON p.idClase = c.id INNER JOIN idiomas i ON c.idioma = i.id INNER JOIN periodoDate pd ON p.idDate = pd.id where pd.status = 0 and p.statusPeriodo = 1 order by p.id DESC;";
    try {
      $min = $limit["min"] ?? 0;
      $max = $limit["max"] ?? 10;
      $view .= " limit $max offset $min";
      $res = $this->conexion->query($view);
      return $res;
    } catch (\Exception $err) {
      $errorMessage = $err->getMessage();
      throw $err;
    };
  }

  public function getListadoClases($limit = [], $dato = [])
  {
    $view = "SELECT c.*, i.name FROM lenguajeSystem.clases c left JOIN lenguajeSystem.idiomas i ON c.idioma = i.id";
    try {
      if (!empty($dato)) {
        $view .= ' WHERE (horario LIKE :dato OR tipo LIKE :dato OR nivel LIKE :dato OR name LIKE :dato)';
      }
      if (!empty($limit)) {
        $min = $limit["min"] ?? 0;
        $max = $limit["max"] ?? 10;
        $view .= " limit $max offset $min";
      }
      if (!empty($dato)) {
        return $this->conexion->query($view, $dato, true);
      }
      $res = $this->conexion->query($view);
      return $res;
    } catch (\Exception $err) {
      $errorMessage = $err->getMessage();
      throw $err;
    };
  }

  public function countClases()
  {
    $view = "SELECT count(*) from lenguajeSystem.clases c";
    try {
      $res = $this->conexion->query($view);
      return $res;
    } catch (\Exception $err) {
      $errorMessage = $err->getMessage();
      throw $err;
    };
  }
  public function countHistorial()
  {
    $view = "SELECT count(*) FROM Periodo p INNER JOIN profesores prof ON p.idProfesor = prof.cedula INNER JOIN clases c ON p.idClase = c.id INNER JOIN idiomas i ON c.idioma = i.id INNER JOIN periodoDate pd ON p.idDate = pd.id where pd.status = 0 and p.statusPeriodo = 1;";
    try {
      $res = $this->conexion->query($view);
      return $res;
    } catch (\Exception $err) {
      $errorMessage = $err->getMessage();
      throw $err;
    };
  }

  public function verificarAlumno($datos)
  {
    try {
      $query =  $this->conexion->query('select p.idClase,p.id,ep.fecha_inscripcion from estudiantes e left join estudiante_periodo ep on ep.estudiante_id = e.cedula left join Periodo p on ep.periodo_id = p.id left join periodoDate pd  on p.idDate = pd.id where e.cedula = :estudiante_id and pd.status = 1 and p.id != :periodo_id order by ep.periodo_id DESC limit 1', ['estudiante_id' => $datos['estudiante_id'], 'periodo_id' => $datos['periodo_id']], true);
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
          $count = (new Estudiante)->countEstudiantes($datos['periodo_id']);
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


  public function inscribirAlumno($datos)
  {
    try {
      $res = $this->conexion->insert('estudiante_periodo', $datos);
      return $res;
    } catch (\Exception $err) {
      $errorMessage = $err->getMessage();
      throw $err;
    };
  }

  public function quitarAlumno($datos)
  {
    try {
      $res = $this->conexion->query('delete from estudiante_periodo where estudiante_id = :estudiante_id and periodo_id = :periodo_id', $datos, true);
      return $res;
    } catch (\Exception $err) {
      $errorMessage = $err->getMessage();
      throw $err;
    };
  }

  public function getAlumnosInscritos($id)
  {
    $view = "SELECT e.cedula, CONCAT(e.nombre, ' ', e.apellido) AS estudiante_completo,e.nombre,e.apellido , e.email, e.telefono,e.nacionalidad, DATE(ep.fecha_inscripcion) AS fecha_inscripcion,pe.estado_pago FROM estudiantes e left JOIN estudiante_periodo ep ON e.cedula = ep.estudiante_id left JOIN pagos_estudiante pe ON pe.estudiante_periodo_id = ep.id WHERE ep.periodo_id = ?  ORDER BY e.cedula;";
    try {
      $res = $this->conexion->query($view, [$id]);
      return $res;
    } catch (\Exception $err) {
      $errorMessage = $err->getMessage();
      throw $err;
    };
  }

  public function getAlumnosAptos($datos = [])
  {
    try {
      if ($datos['nivel'] == 1) {
        $view = 'SELECT e.cedula, e.nombre, e.apellido, e.email, e.telefono, e.fecha_nacimiento FROM estudiantes e LEFT JOIN estudiante_periodo ep ON e.cedula = ep.estudiante_id WHERE ep.estudiante_id IS NULL ORDER BY e.apellido, e.nombre;';
        $res = $this->conexion->query($view);
      } else {
        $datos['nivel'] = $datos['nivel'] - 1;
        $view = "SELECT DISTINCT e.*, c_anterior.Nivel AS nivel_anterior_cursado,ep_anterior.periodo_id  FROM estudiantes e INNER JOIN estudiante_periodo ep_anterior ON e.cedula = ep_anterior.estudiante_id INNER JOIN Periodo p_anterior ON ep_anterior.periodo_id = p_anterior.id INNER JOIN clases c_anterior ON p_anterior.idClase = c_anterior.id WHERE  ep_anterior.id = (SELECT MAX(id) FROM estudiante_periodo WHERE estudiante_id = e.cedula) and c_anterior.Nivel = :nivel AND c_anterior.tipo = :tipo AND c_anterior.idioma = :idioma AND c_anterior.horario = :horario";
        $res = $this->conexion->query($view, $datos, true);
      }
      return $res;
    } catch (\Exception $err) {
      throw $err;
    };
  }

  public function getAlumnosPorInscribir()
  {
    try {
      $valid = $this->getPeriodoDate();
      if (empty($valid)) return false;
      $view = "SELECT DISTINCT e.cedula,e.nombre, e.apellido, e.telefono, e.email, c_anterior.Nivel AS nivel,c_anterior.idioma,c_anterior.tipo ,c_anterior.horario 
            FROM
            estudiantes e
            LEFT JOIN estudiante_periodo ep_anterior ON e.cedula = ep_anterior.estudiante_id
            LEFT JOIN Periodo p_anterior ON ep_anterior.periodo_id = p_anterior.id 
            LEFT JOIN periodoDate pd_anterior ON p_anterior.idDate  = pd_anterior.id
            LEFT JOIN clases c_anterior ON p_anterior.idClase = c_anterior.id 
            wHERE c_anterior.id IS NOT NULL and p_anterior.statusPeriodo != 0 and pd_anterior.status !=1";
      $res = $this->conexion->query($view);
      if (empty($res)) return false;
      $clases = $this->getListadoClases();
      if (empty($clases)) return false;
      $clasesMap = [];
      foreach ($clases as $clase) {
        $clave = $this->generarClaveClase(
          $clase['Nivel'],
          $clase['idioma'],
          $clase['tipo'],
          $clase['horario']
        );
        $clasesMap[$clave] = [
          'idClase' => $clase['id'],
          'name' => $clase['name']
        ];
      }

      $lista = [];
      foreach ($res as $estudiante) {
        if ($estudiante['nivel'] == 22 && $estudiante['idioma'] == 1) continue;
        if ($estudiante['nivel'] == 14 && $estudiante['idioma'] == 2) continue;
        if ($estudiante['nivel'] == 20 && $estudiante['idioma'] == 3) continue;
        if ($estudiante['nivel'] == 24 && $estudiante['idioma'] == 4) continue;
        $nivelSiguiente = (int)$estudiante['nivel'] + 1;

        $claveBuscada = $this->generarClaveClase(
          $nivelSiguiente,
          $estudiante['idioma'],
          $estudiante['tipo'],
          $estudiante['horario']
        );

        if (isset($clasesMap[$claveBuscada])) {
          $estudiante['idClase'] = $clasesMap[$claveBuscada]['idClase'];
          $estudiante['nombre_idioma'] = $clasesMap[$claveBuscada]['name'];
          $lista[] = $estudiante;
        }
      }

      return $lista;
    } catch (\Exception $err) {
      throw $err;
    };
  }

  private function generarClaveClase($nivel, $idioma, $tipo, $horario)
  {
    return sprintf(
      '%d|%d|%s|%s',
      $nivel,
      $idioma,
      strtolower(trim($tipo)),
      strtolower(trim($horario))
    );
  }

  public function getPeriodoDate()
  {
    $view = "select * from periodoDate pd order by id desc limit 1";
    try {
      $res = $this->conexion->query($view);
      return $res;
    } catch (\Exception $err) {
      $errorMessage = $err->getMessage();
      throw $err;
    };
  }

  public function setPeriodoDate($datos)
  {
    $view = "select pd.status from periodoDate pd order by id desc limit 1";
    try {
      $res = $this->conexion->insert('periodoDate', $datos);
      return $res;
    } catch (\Exception $err) {
      $errorMessage = $err->getMessage();
      throw $err;
    };
  }

  public function Periodo($idClass, $idDate)
  {
    $view = "SELECT * FROM Periodo WHERE idClase = ? AND idDate = ?";
    try {
      $periodo = $this->conexion->query($view, [$idClass, $idDate]);
      if (!empty($periodo)) {
        return $periodo;
      } else {
        $insert = "INSERT INTO Periodo (idClase, idDate) VALUES ( ?, ?)";
        $this->conexion->modify($insert, [$idClass, $idDate]);
        $periodo = $this->conexion->query($view, [$idClass, $idDate]);
        return $periodo;
      }
    } catch (\Exception $err) {
      error_log("Error al crear período: " . $err->getMessage());
      throw $err;
    };
  }

  public function setProfesorPeriodo($periodoId, $profesorCedula)
  {
    $view = "UPDATE Periodo SET idProfesor = ? WHERE id = ?";
    try {
      $this->conexion->query($view, [$profesorCedula, $periodoId]);
      return true;
    } catch (\Exception $err) {
      throw $err;
    }
  }

  public function setEndPeriodo($periodoId, $fechaFin){
    $view = "UPDATE Periodo SET finalizacion = ? WHERE id = ?";
    try {
      $this->conexion->query($view, [$fechaFin, $periodoId]);
      return true;
    } catch (\Exception $err) {
      throw $err;
    }
  }
  public function getPeriodo($periodoId)
  {
    $view = "select * from Periodo WHERE id = ?";
    try {
      $res = $this->conexion->query($view, [$periodoId]);
      return $res;
    } catch (\Exception $err) {
      throw $err;
    }
  }
  public function sendFileList()
  {
    $view = "SELECT p.*,pd.id as periodoDate from Periodo p left join periodoDate pd on p.idDate = pd.id where p.statusPeriodo = 1 and p.sendList = 1 and pd.status = 0";
    try {
      $res = $this->conexion->query($view);
      return $res;
    } catch (\Exception $err) {
      throw $err;
    }
  }
}
