<?php

use model\Clases;
use model\Profesores;
use model\Estudiante;
use model\Pagos;
use model\utils;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Asume datos JSON en el body
  try {
    $data = json_decode(file_get_contents('php://input'), true);

    // Registrar pago inicial
    if (($data['action']) === 'registrar_pago_inicial') {
      try {
        $cedula = $data['estudiante_id'] ?? null;
        $periodoId = $data['periodo_id'] ?? null;
        $porcentaje = $data['porcentaje'] ?? null;
        $comentario = $data['comentario'] ?? null;
        if ($comentario == null) {
          if ($porcentaje !== null && $porcentaje == 100) {
            $comentario = 'Pago del monto Total';
          }
          if ($porcentaje !== null && $porcentaje == 60) {
            $comentario = 'Pago Inicial';
          }
        }

        if (empty($cedula) || empty($periodoId) || empty($porcentaje)) {
          header('Content-Type:application/json', true, 400);
          echo json_encode(['success' => false, 'error' => 'Faltan parámetros para registrar el pago inicial']);
          die();
        }
        $resEp = (new model\Estudiante)->getEstudiantePeriodo([
          'estudiante_id' => $cedula,
          'periodo_id' => $periodoId
        ]);

        $estudiantePeriodoId = (int)$resEp['id'];
        $clasesModel = (new model\Clases);
        $idClass = $clasesModel->getPeriodo($resEp['periodo_id']);

        if (empty($idClass[0]['idClase'])) {
          header('Content-Type:application/json', true, 404);
          echo json_encode(['success' => false, 'error' => 'No se encontró la inscripción del estudiante en este periodo']);
          die();
        }

        $Clase = (new model\Clases)->getClase($idClass[0]['idClase']);
        $montoClase = $Clase[0]['Monto'];
        $pagosModel = new model\Pagos();
        $pagosModel->registrarPagoInicial($estudiantePeriodoId, $montoClase, [
          'porcentaje' => $porcentaje,
          'comentario' => $comentario,
        ]);


        header('Content-Type:application/json');
        echo json_encode([
          'success' => true,
          'estado_pago' => $porcentaje
        ]);
        die();
      } catch (Exception $e) {
        header('Content-Type:application/json', true, 500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        die();
      }
    }

    // Inscribir alumno
    if ($data['action'] == 'inscribir') {
      if (empty($data['periodo_id'])) {
        header('Content-Type:application/json');
        echo json_encode(['success' => 'no_periodo']);
        die();
      }
      $datos = [
        'estudiante_id' =>  $data['estudiante_id'],
        'periodo_id' => $data['periodo_id']
      ];
      $status = (new Clases)->verificarAlumno($datos);
      if ($status == false) {
        header('Content-Type:application/json');
        echo json_encode(['success' => 'block']);
        die();
      }
      if (!empty($status['id'])) {
        header('Content-Type:application/json');
        echo json_encode(['success' => 'process', 'data' => $status['id']]);
        die();
      }
      $res =  (new Clases)->inscribirAlumno($datos);
      header('Content-Type:application/json');
      echo json_encode(['success' => true]);
      die();
    }
    // Cambiar alumno
    if ($data['action'] == 'cambio') {
      $datosQuitar = [
        'estudiante_id' =>  $data['estudiante_id'],
        'periodo_id' => $data['anterior_id']
      ];
      $datosInscribir = [
        'estudiante_id' =>  $data['estudiante_id'],
        'periodo_id' => $data['periodo_id']
      ];
      (new Clases)->quitarAlumno($datosQuitar);
      $res =  (new Clases)->inscribirAlumno($datosInscribir);
      header('Content-Type:application/json');
      echo json_encode(['success' => true]);
      die();
    }

    // quitar alumno
    if ($data['action'] == 'quitar') {
      $datos = [
        'estudiante_id' =>  $data['estudiante_id'],
        'periodo_id' => $data['periodo_id']
      ];
      (new Clases)->quitarAlumno($datos);
      header('Content-Type:application/json');
      echo json_encode(['success' => true]);
      die();
    }

    // Listar alumnos
    if ($data['action'] == 'lista') {
      // Retornar la lista de alumnos aptos para inscripción
      try {
        $periodo_id = $data['periodo_id'];
        $data = $data['data'][0];
        $nivel = intval(utils::sanear($data['Nivel']));
        $datos = [
          'nivel' => $nivel,
          'horario' => utils::sanear($data['horario']),
          'tipo' => utils::sanear($data['tipo']),
          'idioma' => utils::sanear($data['idioma']),
        ];
        $datos = utils::sanear($datos);
        $lista = (new Clases)->getAlumnosAptos($datos);
        $inscritos = (new Clases)->getAlumnosInscritos($periodo_id);
        $cedulasInscritas = array_column($inscritos, 'cedula');
        $lista = array_filter($lista, function ($item) use ($cedulasInscritas) {
          // Verificar si la cédula NO está en el array de cédulas inscritas
          return !in_array($item['cedula'], $cedulasInscritas);
        });
        $lista = array_values($lista);
        header('Content-Type:application/json');
        echo json_encode(['data' => $lista]);
        die();
      } catch (Exception $e) {
        header('Content-Type:application/json', true, 500);
        echo json_encode(['error' => $e->getMessage()]);
        die();
      }
    }

    if ($data['action'] == 'buscar_alumno') {
      try {
        $buscar = $data['buscar'] ?? null;
        $periodo_id = $data['periodo_id'];
        if (empty($buscar)) {
          header('Content-Type:application/json', true, 400);
          echo json_encode(['error' => 'Parámetro de búsqueda vacío']);
          die();
        }

        $estudiantes = (new Estudiante)->getEstudiante(['dato' => $buscar]);
        $inscritos = (new Clases)->getAlumnosInscritos($periodo_id);
        $cedulasInscritas = array_column($inscritos, 'cedula');
        $lista = array_filter($estudiantes, function ($item) use ($cedulasInscritas) {
          // Verificar si la cédula NO está en el array de cédulas inscritas
          return !in_array($item['cedula'], $cedulasInscritas);
        });
        $lista = array_values($lista);
        header('Content-Type:application/json');
        echo json_encode(['data' => $estudiantes]);
        die();
      } catch (Exception $e) {
        header('Content-Type:application/json', true, 500);
        echo json_encode(['error' => $e->getMessage()]);
        die();
      }
    }

    if ($data['action'] == 'set_profesor') {
      try {
        $periodoId = $data['periodo_id'] ?? null;
        $profCedula = $data['profesor_cedula'] ?? null;
        if (empty($periodoId) || empty($profCedula)) {
          header('Content-Type:application/json', true, 400);
          echo json_encode(['error' => 'Faltan parámetros']);
          die();
        }
        $res = (new Clases)->setProfesorPeriodo($periodoId, $profCedula);
        header('Content-Type:application/json');
        echo json_encode(['success' => true]);
        die();
      } catch (Exception $e) {
        header('Content-Type:application/json', true, 500);
        echo json_encode(['error' => $e->getMessage()]);
        die();
      }
    }
    if ($data['action'] == 'set_Date') {
      try {
        $periodoId = $data['periodo_id'] ?? null;
        $fechaFin = $data['fecha_fin'] ?? null;
        if (empty($periodoId) || empty($fechaFin)) {
          header('Content-Type:application/json', true, 400);
          echo json_encode(['error' => 'Faltan parámetros']);
          die();
        }
        $res = (new Clases)->setEndPeriodo($periodoId, $fechaFin);
        header('Content-Type:application/json');
        echo json_encode(['success' => true]);
        die();
      } catch (Exception $e) {
        header('Content-Type:application/json', true, 500);
        echo json_encode(['error' => $e->getMessage()]);
        die();
      }
    }
  } catch (Exception $err) {
    header('Content-Type:application/json', true, 500);
    echo json_encode(['error' => $err->getMessage()]);
    die();
  }
}

if (!empty($_GET['get'])) {
  try {
    $inscritos = (new Clases)->getAlumnosInscritos($_GET['get']);
    
    header('Content-Type:application/json');
    echo json_encode(['data' => $inscritos]);
    die();
  } catch (Exception $err) {
    http_response_code(404);
    echo '<pre>';
    var_dump($err);
    echo '</pre>';
    die();
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  try {
    if (empty($_GET['idClass']) || $_GET['idClass'] == null) {
      throw new Exception("Seleccione una clase valida");
    };

    $clase = (new Clases)->getClasesPeriodos($_GET['idClass']);
    $clase = empty($clase[0]) ? false : $clase[0];
    if ($clase == false) {
      throw new Exception("Fallo del sistema");
    }
    $profesores = (new Profesores)->getProfesor();
    foreach ($profesores as $i => $profesor) {
      $profesores[$i]['text'] =
        ($profesor['nacionalidad'] ?? '') . ($profesor['cedula'] ?? '') . ' ' .
        ($profesor['nombre'] ?? '') . ' ' . ($profesor['apellido'] ?? '') . ' ' .
        ($profesor['email'] ?? '');
    }

    // Traera el ID de la fecha de periodo
    $periodo = (new Clases)->getPeriodoDate();
    // Trae los datos del periodo actual
    $periodoData = (new Clases)->Periodo($_GET['idClass'], $periodo[0]['id']);
    // toma el id del periodo
    $periodoId = $periodoData[0]['id'];
    //Trae la informacion de la clase
    $claseData = (new Clases)->getClase($_GET['idClass']);
    $lastProfesor = (new Profesores)->lastProfesor($_GET['idClass'], $periodoId);
    if (!empty($lastProfesor) && empty($periodoData[0]['idProfesor'])) {
      (new Clases)->setProfesorPeriodo($periodoId, $lastProfesor);
    }
  } catch (Exception $err) {
    $_SESSION['error'] = $err->getMessage();/* 
    header('Location:' . PATH . 'clases/inscripciones'); */
  }
} else {
  die();
}


require_once("./views/clases/periodo.view.php");
