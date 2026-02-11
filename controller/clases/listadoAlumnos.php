<?php
use model\Clases;
use model\Reportes;
use model\Profesores;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  try {
    $id = $_POST['idPeriodo'];
    if (empty($id)) {
      throw new Exception("Datos no ingresados");
    };
    $alumnos = (new Clases)->getAlumnosInscritos($id);
    $periodo = (new Clases)->getPeriodo($id);
    $clase = (new Clases) ->getClasePeriodo($periodo[0]["idClase"]);
    $profesor = (new Profesores) ->getProfesor(['cedula' => $periodo[0]["idProfesor"]]);
    if (empty($alumnos) || empty($profesor)) {
      throw new Exception("Datos no ingresados");
    };
    $profesor = $profesor[0];

    $dompdf = (new Reportes);
    $title = "Listado de Alumnos";
    $nombre = "Rotacion " . date('d-m-Y (hiA)');
/*     $logoPath = $_SERVER['DOCUMENT_ROOT'] . '/IPSFANB/src/images/logo.png';
    $logoData = base64_encode(file_get_contents($logoPath));
    $logoBase64 = 'data:image/png;base64,' . $logoData; */
    ob_start();
    ?>
    <!-- <img class="foto" src="<?php /* echo $logoBase64;  */?>" /> -->
    <h2 class="text-center">IVL</h2>
    <h3 class="text-center">Listado de alumnos</h3>
    <h3 class="text-center">Idioma:<?php echo $clase[0]['name'];?> </h3>
    <h3 class="text-center"> Nivel:<?php echo $clase[0]['nivel'];?>  Horario:<?php echo $clase[0]['tipo'];?>  Tipo:<?php echo $clase[0]['horario'];?></h3>
    <h4 class="text-center">PROFESOR(A): <?php echo $profesor['nombre']." ".$profesor['apellido']." ".$profesor['tipoDocumento'].$profesor['cedula']?></h4>
    <table>
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
            <td><?php echo $item['tipoDocumento']. $item['cedula']; ?></td>
            <td><?php echo $item['nombre']; ?></td>
            <td><?php echo $item['apellido']; ?></td>
            <td><?php echo $item['telefono']; ?></td>
            <td><?php echo $item['email']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    </table>
    <?php
    $html = ob_get_clean();
    $dompdf->createPdf($title, $html, $nombre, true);
    exit;
  } catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(["error" => $e->getMessage()]);
    die();
  }
}

header('location:' . PATH . 'clases/inscripciones');
