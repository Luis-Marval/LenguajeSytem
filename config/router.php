<?php

$routes = array(
  "/" => '/home',
  "/home" => '/home',
  // login
  "/register" => '/login/register',
  "/login" => '/login/login',
  "/logout" => '/login/cerrar',
  "/recuperar" => '/login/recuperar',
  "/users" => '/usuarios/usuarios_list',
  "/users/roles" => '/modificar_permisos',
  "/new_password" => '/login/nueva_clave',
  // clases
  '/clases/crear' => "/clases/crearClases",
  '/clases/historial' => "/clases/historialClases",
  '/clases/listado' => "/clases/listadoClases",
  '/clases/periodo' => "/clases/periodo", // donde se inscribiran los estudiantes
  '/clases/listadoClase' => "/clases/listadoAlumnos",// PDF de la clase
  '/clases/inscripciones' => "/clases/inscripciones",
  // Estudiantes
  '/estudiantes/info'=>"/estudiantes/info_estudiantes",
  '/estudiantes/listado' => '/estudiantes/list_estudiantes',
  '/estudiantes/registro' => '/estudiantes/registrar_estudiante',
  '/estudiantes/actualizar'=>"/estudiantes/actualizar_estudiante",
  
  // Profesores
  '/profesor/info'=>"/profesores/info_profesores",
  '/profesor/actualizar'=>"/profesores/actualizar_profesor",
  '/profesor/eliminar'=>"/profesores/eliminar_profesor",
  '/profesor/listado' => '/profesores/list_profesores',
  '/profesor/registro' => '/profesores/registrar_profesor',

  //otros
  '/Notificaciones/Historial' => '/Notificaciones/Historial',
  '/eliminarUsuario' => '/usuarios/eliminar',
  '/cambiarContrasena' => '/usuarios/cambiarContraseña',
  '/cambiarRolusuario' => '/usuarios/cambiarRol',
  '/cambiarRolusuario' => '/usuarios/cambiarRol',
  '/paciente/eliminar_informe' => '/estudiantes/eliminar_informe',
  '/inventario/existencias' => '/inventario/lista_stock',
  '/primer_registro' => '/fisrtRegister.php',
);

  /* 
$controller = array(
  "HomeController" => array(
    "/" => 'init()',
  ),
) */;
