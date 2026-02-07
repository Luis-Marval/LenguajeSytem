<?php

namespace model;

use Exception;
use model\Database;

class Pagos
{
  private $conexion;

  public function __construct()
  {
    $this->conexion = Database::getInstance();
  }

  /**
   * Registrar el primer pago de una inscripción (60% o 100%).
   * $datos debe incluir al menos: porcentaje (60 o 100), comentario (opcional).
   * El campo monto se calcula a partir del monto de la clase (monto_total en estudiante_periodo).
   */
  public function registrarPagoInicial(int $estudiantePeriodoId, float $montoClase, array $datos): int
  {
    try {
      // Validar que no exista ya un pago inicial
      $query = "SELECT * FROM pagos_estudiante WHERE estudiante_periodo_id = :id AND tipo = 'Inicial'";
      $pagosIniciales = $this->conexion->query($query, [':id' => $estudiantePeriodoId], true);

      if (!empty($pagosIniciales)) {
        throw new Exception('Ya existe un pago inicial para esta inscripción');
      }

      $porcentaje = (int)($datos['porcentaje'] ?? 0);
      if (!in_array($porcentaje, [60, 100], true)) {
        throw new Exception('Porcentaje inválido, solo se permite 60 o 100');
      }

      $monto = $montoClase;
      if ($porcentaje === 60) {
        $monto = $montoClase * 60 / 100;
      }

      $insertData = [
        'estudiante_periodo_id' => $estudiantePeriodoId,
        'monto' => $monto,
        'estado_pago' => (string)$porcentaje,
        'tipo' => 'Inicial',
      ];

      $id = $this->conexion->insert('pagos_estudiante', $insertData);
      return (int)$id;
    } catch (Exception $err) {
      throw $err;
    }
  }

  /**
   * Registrar abonos adicionales cuando el estado actual es 60% y aún no se ha alcanzado el 100%.
   * $datos debe incluir: monto, comentario (opcional).
   */
  public function registrarAbono(int $estudiantePeriodoId, array $datos): int
  {
    try {
      $montoAbono = (float)($datos['monto'] ?? 0);
      if ($montoAbono <= 0) {
        throw new Exception('El monto del abono debe ser mayor a 0');
      }

      $estado = $this->getPagosPorInscripcion($estudiantePeriodoId);
      $estado = $estado[0]['estado_pago'] ?? 'pendiente';
      // Registrar abono; el estado_pago se actualizaría externamente según la lógica de negocio
      $insertData = [
        'estudiante_periodo_id' => $estudiantePeriodoId,
        'monto' => $montoAbono,
        'estado_pago' => $estado,
        'moneda' => $datos['moneda'],
        'tipo' => 'Abono',
      ];

      $id = $this->conexion->insert('pagos_estudiante', $insertData);
      return (int)$id;
    } catch (Exception $err) {
      throw $err;
    }
  }

  /**
   * Listar todos los pagos de una inscripción.
   */
  public function getPagosPorInscripcion(int $estudiantePeriodoId): array
  {
    try {
      $query = "SELECT * FROM pagos_estudiante WHERE estudiante_periodo_id = :id ORDER BY fecha_pago desc, id desc";
      $res = $this->conexion->query($query, [':id' => $estudiantePeriodoId], true);
      return $res ?: [];
    } catch (Exception $err) {
      throw $err;
    }
  }

  /**
   * Devuelve total_pagado y estado_pago actual (último registro) para una inscripción.
   */
  public function getEstadoPagoPorInscripcion(int $estudiantePeriodoId): array
  {
    try {
      // Total pagado acumulado
      $queryTotal = "SELECT SUM(monto) AS total_pagado FROM pagos_estudiante WHERE estudiante_periodo_id = :id";
      $totalRes = $this->conexion->query($queryTotal, [':id' => $estudiantePeriodoId], true);
      $totalPagado = !empty($totalRes[0]['total_pagado']) ? (float)$totalRes[0]['total_pagado'] : 0.0;

      // Último registro para conocer estado_pago
      $queryUlt = "SELECT estado_pago FROM pagos_estudiante WHERE estudiante_periodo_id = :id ORDER BY id DESC LIMIT 1";
      $ultRes = $this->conexion->query($queryUlt, [':id' => $estudiantePeriodoId], true);
      $estadoPago = !empty($ultRes[0]['estado_pago']) ? $ultRes[0]['estado_pago'] : 'pendiente';

      return [
        'total_pagado' => $totalPagado,
        'estado_pago' => $estadoPago,
      ];
    } catch (Exception $err) {
      throw $err;
    }
  }

  /**
   * Estudiantes con estado_pago pendiente o 60% en todo el sistema (para listado global).
   */
  public function getPendientesGlobal(): array
  {
    try {

      $query = "SELECT ep.id AS estudiante_periodo_id,
                       e.cedula,
                       e.nombre,
                       e.apellido,
                       c.id AS id_clase,
                       c.Nivel AS nivel,
                       i.name AS nombre_idioma,
                       COALESCE(ue.estado_pago, 'pendiente') AS estado_pago
                FROM estudiante_periodo ep
                INNER JOIN estudiantes e ON e.cedula = ep.estudiante_id
                INNER JOIN Periodo p ON p.id = ep.periodo_id
                INNER JOIN clases c ON c.id = p.idClase
                INNER JOIN idiomas i ON i.id = c.idioma
                LEFT JOIN (SELECT pe1.*
                   FROM pagos_estudiante pe1
                   INNER JOIN (
                     SELECT estudiante_periodo_id, MAX(id) AS max_id
                     FROM pagos_estudiante
                     GROUP BY estudiante_periodo_id
                   ) ult
                   ON ult.estudiante_periodo_id = pe1.estudiante_periodo_id AND ult.max_id = pe1.id) ue ON ue.estudiante_periodo_id = ep.id
                WHERE COALESCE(ue.estado_pago, 'pendiente') IN ('pendiente','60')
                ORDER BY ep.id DESC";

      $rows = $this->conexion->query($query);
      return $rows ?: [];
    } catch (Exception $err) {
      throw $err;
    }
  }

  /**
   * Listado de todos los pagos realizados (para pantalla de Pagos) con paginación.
   */
  public function getTodosLosPagos(int $limit, int $offset): array
  {
    try {
      $query = "SELECT pe.*, e.cedula, e.nombre, e.apellido, c.id AS id_clase,c.Nivel as nivel, i.name AS nombre_idioma, p.id AS periodo_id FROM pagos_estudiante pe INNER JOIN estudiante_periodo ep ON ep.id = pe.estudiante_periodo_id INNER JOIN estudiantes e ON e.cedula = ep.estudiante_id INNER JOIN Periodo p ON p.id = ep.periodo_id INNER JOIN clases c ON c.id = p.idClase INNER JOIN idiomas i ON i.id = c.idioma ORDER BY pe.fecha_pago DESC, pe.id DESC";
      $max = (int)$limit ?? 10;
      $min = (int)$offset ?? 0;
      $query .= " limit $max offset $min";
      $rows = $this->conexion->query($query);
      return $rows ?: [];
    } catch (Exception $err) {
      throw $err;
    }
  }

  /**
   * Total de registros de pagos (para paginación).
   */
  public function countPagos(): int
  {
    try {
      $query = "SELECT COUNT(*) AS total FROM pagos_estudiante";
      $res = $this->conexion->query($query);
      return (int)($res[0]['total'] ?? 0);
    } catch (Exception $err) {
      throw $err;
    }
  }
  public function getPagosPendientes()
  {
    try {
      $view = "SELECT
	t.*
FROM
	(
	SELECT
		pe.id AS pago_id,
		e.cedula,
		CONCAT(e.nombre, ' ', e.apellido) AS estudiante,
		p.id AS periodo_id,
		pe.monto,
		pe.tipo,
		pe.estado_pago,
		pe.fecha_pago,
		pe.moneda,
    		pe.estudiante_periodo_id,
		i.name as nombre_idioma,
		p.finalInscripcion,
		DATEDIFF(CURDATE(), p.finalInscripcion) AS dias_desde_fin_inscripcion,
		ep.fecha_inscripcion,
		ROW_NUMBER() OVER ( PARTITION BY ep.estudiante_id,
		ep.periodo_id
	ORDER BY
		pe.fecha_pago DESC,
		pe.id DESC) AS rn
	FROM
		pagos_estudiante pe
	INNER JOIN estudiante_periodo ep ON
		pe.estudiante_periodo_id = ep.id
	INNER JOIN estudiantes e ON
		ep.estudiante_id = e.cedula
	INNER JOIN Periodo p ON
		ep.periodo_id = p.id
	inner join clases c on
		c.id = p.idClase
	inner join idiomas i on
		c.idioma = i.id
	WHERE
		p.statusPeriodo != 0
		AND p.finalInscripcion IS NOT NULL
		AND (CURDATE() = DATE_ADD(p.finalInscripcion, INTERVAL 15 DAY)
			or CURDATE() = DATE_ADD(p.finalInscripcion, INTERVAL 10 DAY)
				or CURDATE() = DATE_ADD(p.finalInscripcion, INTERVAL 5 DAY))) t
WHERE
	t.rn = 1
	AND t.estado_pago IN ('pendiente', '60')
ORDER BY
	t.finalInscripcion DESC,
	t.fecha_pago DESC;";
      $lista = $this->conexion->query($view);
      if (empty($lista)) return false;
      return $lista;
    } catch (\Exception $err) {
      throw $err;
    };
  }

  public function getInfoInscripcion($estudiante_periodo_id)
  {
    $query = "
        SELECT 
            ep.id AS estudiante_periodo_id,
            e.cedula, e.nombre, e.apellido, e.telefono,
            i.name AS idioma,
            c.Nivel AS nivel,
            c.monto as total,
            p.id AS periodo_id,
            p.finalInscripcion
        FROM estudiante_periodo ep
        INNER JOIN estudiantes e ON ep.estudiante_id = e.cedula
        INNER JOIN Periodo p ON ep.periodo_id = p.id
        INNER JOIN clases c ON p.idClase = c.id
        INNER JOIN idiomas i ON c.idioma = i.id
        WHERE ep.id = :id
        order by ep.id DESC
    ";
    $stmt = $this->conexion->query($query, ['id' => $estudiante_periodo_id], true);
    return $stmt;
  }
  // Totales agrupados por moneda para un estudiante_periodo_id
  public function getTotalesPagados($estudiante_periodo_id)
  {
    $query = "
        SELECT 
            moneda,
            SUM(monto) AS total_pagado
        FROM pagos_estudiante
        WHERE estudiante_periodo_id = :id
        GROUP BY moneda
    ";
    $stmt = $this->conexion->query($query, ['id' => $estudiante_periodo_id], true);
    $result = ['Dolar' => 0.00, 'Bolivar' => 0.00];
    foreach ($stmt as $row) {
      $moneda = $row['moneda'] ?? 'Dolar';
      $result[$moneda] = (float)$row['total_pagado'];
    }

    return $result;
  }

  /**
   * Calcula cuánto falta por pagar en dólares para llegar al 100% de la clase.
   * Retorna 0 si ya se superó o igualó el monto total.
   * 
   * @return float Monto faltante en dólares
   */
  public function calcularMontoFaltanteDolares(int $estudiantePeriodoId): float
  {
    $info = $this->getInfoInscripcion($estudiantePeriodoId);
    if (empty($info)) {
      return 0.0;
    }

    $montoTotalClase = (float)($info[0]['total'] ?? 0.0);  

    $totales = $this->getTotalesPagados($estudiantePeriodoId);
    $pagadoDolares = $totales['Dolar'] ?? 0.0;

    $faltante = $montoTotalClase - $pagadoDolares;

    return max(0.0, $faltante);
  }
  // Registrar pago completado (estado 100) - idealmente con monto restante o monto fijo
  public function registrarPagoCompletado($estudiante_periodo_id, $moneda = 'Dolar')
  {
    try{
          $faltante = $this->calcularMontoFaltanteDolares($estudiante_periodo_id);
    
    if ($faltante <= 0) {
        // Opcional: podrías lanzar excepción o simplemente no insertar
        return false; // o throw new Exception("No hay saldo pendiente");
    }
    $datos = [
      'estudiante_periodo_id' => $estudiante_periodo_id,
      'monto'                 => $faltante,
      'tipo'                  => 'abono',
      'estado_pago'           => '100',
      'moneda'                => $moneda,
    ];

    $query = "
        INSERT INTO pagos_estudiante 
        (estudiante_periodo_id, monto, tipo, estado_pago, moneda)
        VALUES 
        (:estudiante_periodo_id, :monto, :tipo, :estado_pago, :moneda)
    ";
    return $this->conexion->query($query, $datos, true);
    }catch(\Exception $e){
      throw new Exception("No se pudo registrar el pago completado");
    }
  }
}
