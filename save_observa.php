<?php
session_start();

include_once "conexion.php";
include_once "libreria.php";

$id_IdeaXprofe = (empty($_REQUEST['ideaxprofesor'])) ? 0 : $_REQUEST['ideaxprofesor'];
$observacion = $_REQUEST['observa'];
// echo $observacion;
// echo $id_IdeaXprofe;
if ($id_IdeaXprofe != 0) {

	$observa = "UPDATE ideaxprofesor SET observacion = '$observacion' where id = '$id_IdeaXprofe';";
	//echo 'sql:'.$observa;
	$sql = guardarSql($observa);
	if ($error==1){
		echo '<script language="JavaScript"> alert("Los datos no se actualizaron correctamente. Pongase en contacto con el administrador");</script>';
	}else{
		echo '<script language="JavaScript"> window.location = "calificarIdea.php";</script>';
	}
}else{
	echo '<script language="JavaScript"> window.location = "calificarIdea.php";</script>';
}

include_once "cerrar_conexion.php";
?>