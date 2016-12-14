<?php
	session_start();
	include_once "chekearLogin.php";

echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';

include_once "conexion.php";
include_once "libreria.php";

$cuerpo = trim($_REQUEST['msj']); //trim limpia los espacios al principio y al final de contenido enviado en el campo

$mail = $_REQUEST['mail'];
$asunto = $_REQUEST['asunto'];
//$asunto = "Consulta idea";
$sendFrom = "dpto-electronica@frvm.utn.edu.ar";
$from_name = "Dpto Electronica";
//$to = $mail;
$to = 'eze.olea.f@gmail.com';

enviarMail($cuerpo,$asunto,$sendFrom,$from_name,$to,NULL,1);

include_once "cerrar_conexion.php";

echo '<script language="JavaScript"> window.location = "ideas_aprob.php";</script>';

?>