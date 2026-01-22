<?php

$start = microtime(true);

$resEp = (new model\Estudiante)->getEstudiantePeriodo([
  'estudiante_id' => 28723454,
  'periodo_id' => 72
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
  'porcentaje' => 100,
  'comentario' => "Pago inicial del 100%",
]);

$end = microtime(true);
$time = $end - $start;
echo "execute time {$time}";
