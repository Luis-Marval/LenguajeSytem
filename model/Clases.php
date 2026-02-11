<?php

namespace model;

use DateTime;
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
  /**
   * busca el lisado de idiomas 
   * @return array listado de idiomas
   */
  public function getIdiomas(): array
  {
    $view = 'select * from idiomas';
    try {
      $resultado = $this->conexion->query($view);
      return $resultado;
    } catch (\Throwable $th) {
      throw new \Exception($th->getMessage());
    }
  }
  /**
   * Crea una nueva fila de la tabla clase
   * @param array $datos la informacion de la clase a crear
   */
  public function createClase(array $datos)
  {
    try {
      $res = $this->conexion->insert('clases', $datos);
      return true;
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

  /**
   * Buscar la inforamcion de una clase 
   * @param int $id identificador de la clase a buscar
   * @return array retorna la informacion de la clase
   */
  public function getClase($id)
  {
    $view = "select c.*,i.name from clases c left join idiomas i on c.idioma = i.id where c.id = ? limit 1";
    try {
      $res = $this->conexion->query($view, ['id' => $id]);
      return $res;
    } catch (\Exception $err) {
      $errorMessage = $err->getMessage();
      throw $err;
    };
  }

  /**
   * Trae la cantidad total de clases activas actualmente
   * @return int el total de clases activas
   */
  public function countClasesPeriodos(): int
  {
    try {
      $view = 'select count(*) as total from clasesActivas';
      $res = $this->conexion->query($view);
      $total = is_int($res[0]['total']) ? $res[0]['total'] : throw new Exception("Fallo al cargar los datos");
      return $total;
    } catch (\Exception $err) {
      throw $err;
    };
  }

  /**
   * Busca el listado de la vista clasesActivas 
   * @param array $limit cantidad de filas a traer [max:int= cantidad a buscar][min:int = numero de donde inicia a buscar]
   * @param array $dato filtra los resultado en base a parecidos
   * @return array listado de las clasesActivas
   */
  public function getClasesPeriodosListado($limit = [], $dato = '')
  {
    $view = "select * from clasesActivas";
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
        $dato = "%$dato%";
        return $this->conexion->query($view, ['dato' => $dato], true);
      }
      $res = $this->conexion->query($view);
      return $res;
    } catch (\Exception $err) {
      throw $err;
    };
  }

  /**
   * Busca la informacion de un periodo especifico
   * @param int $id identificador del periodo 
   * @return array informacion del periodo
   */
  public function getClasePeriodo($id)
  {
    try {
      // #region Query de Clases
      $view = 'SELECT c.id,i.name,c.tipo,c.horario,c.nivel,c.horaInicio, c.horaFin,p.id as idPeriodo,p.idDate AS statusPeriodo FROM clases c LEFT JOIN Periodo p ON c.id = p.idClase LEFT JOIN idiomas i ON i.id = c.idioma where c.id = ?';
      // #endregion Query de Clases
      $res = $this->conexion->query($view, ['id' => $id]);
      return $res;
    } catch (\Exception $err) {
      throw $err;
    };
  }

  /**
   * Trae el historial de  las clases
   * @param array $limit cantidad de filas a traer [max:int= cantidad a buscar][min:int = numero de donde inicia a buscar]
   * @return array listadod e clases finalizadas
   */
  public function getHistorialClases($limit)
  {
    $view = "SELECT p.*,p.id as idPeriodo,c.*,i.name AS name FROM Periodo p INNER JOIN profesores prof ON p.idProfesor = prof.cedula INNER JOIN clases c ON p.idClase = c.id INNER JOIN idiomas i ON c.idioma = i.id where p.idDate = 0 and p.statusPeriodo = 1 order by p.id DESC;";
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

  /**
   * Trae el listado de las clases creadas
   * @param array $limit cantidad de filas a traer [max:int= cantidad a buscar][min:int = numero de donde inicia a buscar]
   * @param array $dato filtra los resultado en base a parecidos
   * @return array listado de las clases
   */
  public function getListadoClases($limit = [], $dato = '')
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
        $dato = "%$dato%";
        return $this->conexion->query($view, ['dato' => $dato], true);
      }
      $res = $this->conexion->query($view);
      return $res;
    } catch (\Exception $err) {
      $errorMessage = $err->getMessage();
      throw $err;
    };
  }

  /**
   * @return int retorna la cantidad de entradas de la tabla clases
   */
  public function countClases()
  {
    $view = "SELECT count(*) as total from lenguajeSystem.clases c";
    try {
      $res = $this->conexion->query($view);
      $total = $res[0]['total'];
      return $total;
    } catch (\Exception $err) {
      $errorMessage = $err->getMessage();
      throw $err;
    };
  }

  /**
   * @return int retorna el total de clases historial
   */
  public function countHistorial()
  {
    $view = "SELECT count(*) as total FROM Periodo p INNER JOIN profesores prof ON p.idProfesor = prof.cedula INNER JOIN clases c ON p.idClase = c.id INNER JOIN idiomas i ON c.idioma = i.id where p.idDate = 0 and p.statusPeriodo = 1;";
    try {
      $res = $this->conexion->query($view);
      $total = $res[0]['total'];
      return $total;
    } catch (\Exception $err) {
      $errorMessage = $err->getMessage();
      throw $err;
    };
  }
  /**
   * analiza si el alumno es apto para cambiar de clase
   */
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
    $view = "SELECT e.cedula, CONCAT(e.nombre, ' ', e.apellido) AS estudiante_completo,e.nombre,e.apellido , e.email, e.telefono,e.nacionalidad,e.tipoDocumento, DATE(ep.fecha_inscripcion) AS fecha_inscripcion,pe.estado_pago FROM estudiantes e left JOIN estudiante_periodo ep ON e.cedula = ep.estudiante_id left JOIN pagos_estudiante pe ON pe.estudiante_periodo_id = ep.id WHERE ep.periodo_id = ?  ORDER BY e.cedula;";
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
        $view = 'SELECT e.cedula, e.nombre, e.apellido,e.tipoDocumento, e.email, e.telefono, e.fecha_nacimiento FROM estudiantes e LEFT JOIN estudiante_periodo ep ON e.cedula = ep.estudiante_id WHERE ep.estudiante_id IS NULL ORDER BY e.apellido, e.nombre;';
        $res = $this->conexion->query($view);
      } else {
        $datos['nivel'] = $datos['nivel'] - 1;
        // #region 
        $view = "SELECT DISTINCT e.*,c_anterior.Nivel AS nivel_anterior_cursado, ep_anterior.periodo_id FROM estudiantes e INNER JOIN estudiante_periodo ep_anterior ON e.cedula = ep_anterior.estudiante_id INNER JOIN Periodo p_anterior ON ep_anterior.periodo_id = p_anterior.id INNER JOIN clases c_anterior ON p_anterior.idClase = c_anterior.id WHERE ep_anterior.id = (SELECT MAX(id) FROM estudiante_periodo WHERE estudiante_id = e.cedula) and p_anterior.idDate != 1 and c_anterior.Nivel = :nivel AND c_anterior.tipo = :tipo AND c_anterior.idioma = :idioma AND c_anterior.horario = :horario";
        // #endregion 
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
      $view = "SELECT e.cedula, e.nombre,e.apellido, e.telefono, e.email, c_anterior.Nivel AS nivel, c_anterior.idioma, c_anterior.tipo,c_anterior.horario,p_anterior.idDate FROM estudiantes e INNER JOIN estudiante_periodo ep_anterior ON e.cedula = ep_anterior.estudiante_id INNER JOIN Periodo p_anterior ON ep_anterior.periodo_id = p_anterior.id INNER JOIN clases c_anterior ON p_anterior.idClase = c_anterior.id WHERE p_anterior.id = (SELECT MAX(p2.id) FROM Periodo p2 JOIN estudiante_periodo ep2 ON p2.id = ep2.periodo_id WHERE ep2.estudiante_id = e.cedula AND p2.statusPeriodo != 0) and p_anterior.idDate != 1 AND EXISTS ( SELECT 1 FROM clases c_futura INNER JOIN Periodo p_futura ON c_futura.id = p_futura.idClase WHERE p_futura.idDate = 1 and p_futura.idProfesor is NOT NULL and p_futura.finalizacion is NOT NULL AND c_futura.Nivel > c_anterior.Nivel AND c_futura.idioma = c_anterior.idioma and c_futura.tipo = c_anterior.tipo and c_futura.horario = c_anterior.horario)";
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

  public function Periodo($idClass)
  {
    $view = "SELECT * FROM Periodo WHERE idClase = ? AND idDate = 1";
    try {
      $periodo = $this->conexion->query($view, [$idClass]);
      if (!empty($periodo)) {
        return $periodo;
      } else {
        $insert = "INSERT INTO Periodo (idClase) VALUES (?)";
        $this->conexion->insert('Periodo', ['idClase' => $idClass]);
        $periodo = $this->conexion->query($view, [$idClass]);
        return $periodo;
      }
    } catch (\Exception $err) {
      error_log("Error al crear período: " . $err->getMessage());
      throw $err;
    };
  }

  public function setProfesorPeriodo($periodoId, $profesorCedula)
  {
    $view = "UPDATE Periodo SET idProfesor = :idProfesor WHERE id = :id";
    try {
      $this->conexion->modify($view, ['idProfesor'=>$profesorCedula, 'id'=>$periodoId],true);
      return true;
    } catch (\Exception $err) {
      throw $err;
    }
  }

  public function setEndPeriodo($periodoId, $fechaFin)
  {
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

  public function updateClase($id, $datos)
  {
    try {
      $res = $this->conexion->update('clases', ['id' => $id], $datos);
      return $res;
    } catch (\Exception $err) {
      throw new \Exception($err->getMessage());
    }
  }

  public function finalizarPeriodo($periodoId)
  {
    $periodoData = $this->getPeriodo($periodoId);
    if (($periodoData[0]['idDate']) == 0) {
      return false;
    }
    if (empty($periodoData[0]['finalizacion'])) {
      throw new \Exception('No existe una fecha de finalizacion');
    }
    if (empty($periodoData[0]['idProfesor'])) {
      throw new \Exception('No existe una un profesor establecido');
    }
    $inscritos = $this->getAlumnosInscritos($periodoId);
    $date = new DateTime();
    $this->conexion->update('Periodo', ['id' => $periodoId], ['idDate' => 0, 'finalInscripcion' => $date->format('Y-m-d')]);
    return true;
  }
}
