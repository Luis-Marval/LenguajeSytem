<?php

namespace model;

use Dompdf\Dompdf;

class Reportes extends Dompdf
{
  public function __construct(){
    parent::__construct(); 
    $options = $this->getOptions(); 
    $options->set('isPhpEnabled', true);
    $options->set('isJavascriptEnabled', true);
    $options->set('isRemoteEnabled', true);
    $this->setOptions($options);
    $this->setPaper("a4", "portrait");
  }
  public function createPdf($title,$html, $name, $tream = false){
    $gola = $this-> struct($title,$html); 
    $this->loadHtml($gola);
    $this->render();
    $this->getFooter();
    $this->stream($name . ".pdf", array("Attachment" => 0));
  }
  public function getFooter(){
    $this->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
      $text = "$pageNumber/$pageCount";
      $font = $fontMetrics->getFont('Arial', 'normal');
      $size = 10;
      $width = $fontMetrics->getTextWidth($text, $font, $size);
      $canvas->text(
        ($canvas->get_width() - $width) / 2,
        $canvas->get_height() - 30,
        $text,
        $font,
        $size
      );
      $fecha = date('d/m/Y (h:i A)');
      $width_fecha = $fontMetrics->getTextWidth($fecha, $font, $size);
      $canvas->text(
        $canvas->get_width() - $width_fecha - 20, // 20px de margen derecho
        $canvas->get_height() - 30,
        $fecha,
        $font,
        $size
      );
    });
  }
  public function struct($title,$html): string {
    return "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width,initial-scale=1.0'><style>@page{margin:10mm 0 15mm 0;padding:0}body{margin:0;padding:0;max-width:100vw}.h-2{height:2%}.grow-2px{flex-grow:2px}.w-50{width:50%}.inBlock{display:inline-block}.btn:hover{background:color-mix(in srgb,#002366 85%,white 15%);outline:#ac89db 1.7px solid;color:#ac89db;transition:all 0.3s ease;cursor:pointer}table{width: 90%;border:1px solid black;border-collapse:collapse;text-align:center;margin:auto}td,th{border:1px solid black}.px-6{padding-left:1.5rem;padding-right:1.5rem}h1{margin:0,margin-botton:1mm}.py-3{padding-top:.75rem;padding-bottom:.75rem} .text-center{text-align:center}.footer{position:fixed;bottom:-20mm;left:0;right:0;height:20mm;text-align:center;font-size:10pt;border-top:1px solid #ddd;padding-top:5mm}Firma {
        position: absolute;
        bottom: 50mm;  /* Usar milímetros es más confiable */
        right: 20mm;
        width: 70mm;
        text-align: center;
        border-top: 1px solid #000;
        padding-top: 5mm;
    }.mesA {
  position: relative;top:-8; border-bottom:10px solid blue; font-size:20px}.diaA{font-size:40px}.datos{border-left:5px solid blue}.foto{position:absolute;left:50;top:15;}.fechaFin{position:absolute;left:50;top:15;}.foto{width:80px}.first::first-letter{text-transform:uppercase}.offBorder{border:1px solid black}.border-blue{border-left:1ps solid blue}</style><title>".$title."</title></head><body><div class='flex wrapper'><main>$html</main></div></div><div class='footer'></div></body></html>";
  }
  public function logo(){
    $logoPath = $_SERVER['DOCUMENT_ROOT'] . '/IPSFANB/src/images/logo.png';
    $logoData = base64_encode(file_get_contents($logoPath));
    $logoBase64 = 'data:image/png;base64,' . $logoData;
    ob_start();?>
    <img class="foto" src="<?php echo $logoBase64; ?>">
    <?php
    return ob_get_clean();
  }
}
