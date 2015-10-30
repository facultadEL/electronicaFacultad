<?php
	session_start();
	include_once "chekearLogin.php";

echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';

include_once "conexion.php";
include_once "libreria.php";

$cuerpo = trim($_REQUEST['msj']); //trim limpia los espacios al principio y al final de contenido enviado en el campo
$cuerpo .= '<br><br> Enviado por:'.$_SESSION['nombre'].', '.$_SESSION['apellido'].'.';

$id_Profesor = $_REQUEST['idProfesor'];

$sql = traerSql('mail','profesor','id='.$id_Profesor);
$rowMail = pg_fetch_array($sql);
	$mail = $rowMail['mail'];

$asunto = "Consulta idea";
$sendFrom = "dpto-electronica@frvm.utn.edu.ar";
$from_name = "Dpto Electronica";
$to = $mail;
if ($_SESSION['rol_fk'] == 2) {
	$copia_oculta = NULL;
}else{
	$copia_oculta = ADMIN;
}
enviarMail($cuerpo,$asunto,$sendFrom,$from_name,$to,$copia_oculta);

include_once "cerrar_conexion.php";

if ($_SESSION['rol_fk'] == 2) {
	echo '<script language="JavaScript"> window.location = "enCursoAdmin_if.php";</script>';
}elseif ($_SESSION['rol_fk'] == 1) {
	echo '<script language="JavaScript"> window.location = "escritorioPasante.php";</script>';
}elseif ($_SESSION['rol_fk'] == 3) {
	echo '<script language="JavaScript"> window.location = "enCurso_if.php";</script>';
}
?>