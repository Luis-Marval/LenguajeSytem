<?php


require "/var/www/html/vendor/autoload.php";
Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../../')->load();

use PHPUnit\Framework\TestCase;
use model\Usuario;

class UsuarioTest extends TestCase
{
  public function testSearchUserExits(): void
  {
    $usuario = new Usuario;
    $datos = $usuario->comprobar(['id' => 1]);
    $this->assertIsArray($datos);
    $this->assertEquals(9,count($datos));
  }
  public function testSearchUserNoExits(): void
  {
    $usuario = new Usuario;
    $this->assertSame(false, $usuario->comprobar(['id' =>'w']));
  }
}
