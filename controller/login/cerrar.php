<?php 


session_destroy();
$_SESSION = array();
header("Location: ".PATH."login");
die();

?>