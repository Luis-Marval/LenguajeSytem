<?php

$pagosModel = new model\Pagos();
// Procesar POST (guardar nuevo abono)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $epi =  $_POST['epi'];
    if (isset($_POST['action']) && $_POST['action'] === 'completar_pago') {
      // Botón "Marcar como 100"
      $resultado = $pagosModel->registrarPagoCompletado($epi);
      $_SESSION['success'] = "Pago completado registrado correctamente";
      header("Location: " . PATH . "pagos/listado");
      exit;
    }
    // Validar y guardar
    $datos = [
      'monto' => $_POST['monto'] ?? 0,
      'moneda'  => $_POST['moneda'],
    ];

    $pagosModel->registrarAbono($epi, $datos);  // método que inserta

    // Mensaje éxito y redirigir (o recargar)
    $_SESSION['success'] = "Abono registrado correctamente.";
    header("Location: " . PATH . "pagos/abono?epi=" . $epi);
    exit;
  } catch (\Exception $e) {
    $_SESSION['error'] = $e->getMessage();
  }
}


$epi = isset($_GET['epi']) ? (int)$_GET['epi'] : 0;
if ($epi <= 0) {
  // redirigir o mostrar error
  header("Location: " . PATH . "pagos/listado");
  exit;
}

// Obtener datos básicos del estudiante + periodo
$inscripcion = $pagosModel->getInfoInscripcion($epi);  // nuevo método (ver abajo)
$inscripcion = $inscripcion[0];
if (!$inscripcion) {
  // no existe → redirigir
  header("Location: " . PATH . "pagos/listado");
  exit;
}

$historial = $pagosModel->getPagosPorInscripcion($epi);
$totales     = $pagosModel->getTotalesPagados($epi);

require_once "./views/pagos/abono.view.php";
exit;
