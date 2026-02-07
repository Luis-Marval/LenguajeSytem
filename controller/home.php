<?php

use model\Clases;
use model\Pagos;
// Date
$listas = (new Clases)->getAlumnosPorInscribir();
$pagos = (new Pagos)->getPagosPendientes();

require_once 'views/home.view.php';
