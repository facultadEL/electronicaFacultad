<?php
session_start();

include_once "conexion.php";
include_once "libreria.php";

$idea = (empty($_REQUEST['idea'])) ? 0 : $_REQUEST['idea'];
//$aprobar = $_REQUEST['aprobar'];
//$iec = (empty($_REQUEST['iec'])) ? 0 : $_REQUEST['iec'];

if ($idea != 0) {

	$aEjecucion = "UPDATE idea SET estado=5 WHERE id = $idea;";
	$error = guardarSql($aEjecucion);
					
	if ($error==1){
		echo '<script language="JavaScript"> alert("Los datos no se actualizaron correctamente. Pongase en contacto con el programador");</script>';
	}else{
		echo '<script language="JavaScript"> window.location = "ideas_aprob.php";</script>';
	}
}else{
	echo '<script language="JavaScript"> window.location = "ideas_aprob.php";</script>';
}

include_once "cerrar_conexion.php";
?>