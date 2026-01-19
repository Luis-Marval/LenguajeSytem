<?php
require "vendor/autoload.php";
Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../')->load();
spl_autoload_register(function ($className) {
  // Convierte namespace a ruta de archivo
  $file = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';

  if (file_exists($file)) {
    require_once $file;
    return true;
  }
  return false;
});
var_dump($_ENV);

use model\Clases;
use model\Reportes;
use model\Profesores;
use model\Mail;


$clase = new Clases();
$lista = $clase->sendFileList();

$results = []; // Para almacenar resultados de cada envío

try {
  if (empty($lista)) {
    die();
  }

  foreach ($lista as $listItem) {
    try {
      // Obtener el ID del periodo desde el elemento de la lista
      $id = $listItem['id']; // Ajusta esta clave según la estructura real de $lista

      if (empty($id)) {
        throw new Exception("ID de periodo no encontrado en el elemento de la lista");
      }

      $alumnos = (new Clases)->getAlumnosInscritos($id);
      $periodo = (new Clases)->getPeriodo($id);

      if (empty($periodo)) {
        throw new Exception("Periodo no encontrado para ID: $id");
      }

      $claseData = (new Clases)->getClasesPeriodos($periodo[0]["idClase"]);
      $profesor = (new Profesores)->getProfesor(['cedula' => $periodo[0]["idProfesor"]]);
      if (empty($alumnos) || empty($profesor)) {
        throw new Exception("Datos incompletos para el periodo $id");
      };

      $profesor = $profesor[0];

      // Generar el PDF
      $dompdf = new Reportes();
      $title = "Listado de Alumnos";
      $nombre = "Rotacion_" . $id . "_" . date('d-m-Y');

      ob_start();
?>
      <h2 class="text-center">IVL</h2>
      <h3 class="text-center">Listado de alumnos</h3>
      <h3 class="text-center">Idioma:<?php echo $claseData[0]['name']; ?> </h3>
      <h4 class="text-center">PROFESOR(A): <?php echo $profesor['nombre'] . " " . $profesor['apellido'] . " " . $profesor['cedula'] ?></h4>
      <table>
        <h3 class="text-center"> Nivel:<?php echo $claseData[0]['nivel']; ?> Horario:<?php echo $claseData[0]['horario']; ?> Tipo:<?php echo $claseData[0]['tipo']; ?></h3>
        <thead class="">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Cedula</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Telefono</th>
            <th scope="col">Email</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          foreach ($alumnos as $item) {
          ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td><?php echo $item['nacionalidad'] . $item['cedula']; ?></td>
              <td><?php echo $item['nombre']; ?></td>
              <td><?php echo $item['apellido']; ?></td>
              <td><?php echo $item['telefono']; ?></td>
              <td><?php echo $item['email']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
<?php
      $html = ob_get_clean();

      // Crear PDF en archivo temporal
      $tempDir = sys_get_temp_dir() . '/';
      $tempFileName = $nombre . ".pdf";
      $tempFilePath = $tempDir . $tempFileName;

      // Renderizar PDF a archivo temporal
      $dompdf->loadHtml($dompdf->struct($title, $html));
      $dompdf->render();
      $dompdf->getFooter();

      // Guardar el PDF en archivo temporal
      file_put_contents($tempFilePath, $dompdf->output());

      // Enviar por correo
      $mail = new Mail();
      $message = [
        'adress' => $profesor['email'],
        'suject' => "Listado de Alumnos",
        'body' => "Estimado/a Profesor(a) {$profesor['nombre']} {$profesor['apellido']},<br><br>
                          Se adjunta el listado de alumnos para la session Actual<br>
                          Idioma: {$claseData[0]['name']}<br>
                          Nivel: {$claseData[0]['nivel']}<br>
                          Horario: {$claseData[0]['horario']}<br><br>
                          Saludos cordiales,<br>
                          Instituto Venezolano de Lenguas",
        'altBody' => "Estimado/a Profesor(a) {$profesor['nombre']} {$profesor['apellido']},\n\nSe adjunta el listado de alumnos para la rotación $id.\nIdioma: {$claseData[0]['name']}\nNivel: {$claseData[0]['nivel']}\nHorario: {$claseData[0]['horario']}\n\nSaludos cordiales,\nInstituto Venezolano de Lenguas",
        'filePath' => $tempFilePath,
        'fileName' => $nombre
      ];

      $mail->sendMail($message);

      // Limpiar archivo temporal
      unlink($tempFilePath);

      $results[] = [
        'periodo' => $id,
        'profesor' => $profesor['nombre'] . " " . $profesor['apellido'],
        'email' => $profesor['email'],
        'status' => 'success',
        'message' => 'PDF generado y enviado correctamente'
      ];
    } catch (Exception $e) {
      $results[] = [
        'periodo' => $id ?? 'Desconocido',
        'status' => 'error',
        'message' => $e->getMessage()
      ];
      // Continuar con el siguiente elemento aunque este falle
      continue;
    }
  }

  // Devolver resultados como JSON
  var_dump([
    "success" => true,
    "message" => "Procesamiento completado",
    "results" => $results,
    "total" => count($lista),
    "exitosos" => count(array_filter($results, function ($r) {
      return $r['status'] === 'success';
    }))
  ]);
} catch (Exception $e) {
  var_dump([
    "error" => $e->getMessage(),
    "results" => $results
  ]);
  die();
}
