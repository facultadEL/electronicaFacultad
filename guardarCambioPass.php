<?php
session_start();
//$passActual = $_REQUEST['passGenerado'];
$passNuevo = $_REQUEST['nuevoPass'];
//echo 'usuario: '.$usuario.'<br>';
//echo 'password: '.$password.'<br>';
$id_Pasante = $_SESSION['id_Pasante'];
//echo 'pass: '.$passNuevo;

include_once "conexion.php";
include_once "libreria.php";

$sql = traerSqlCondicion('usuario_fk','pasante','id='.$id_Pasante);
$rowUsu = pg_fetch_array($sql);
	$id_Usuario = $rowUsu['usuario_fk'];

$modifPass="UPDATE usuario SET password='$passNuevo', primera_vez='FALSE' WHERE id = $id_Usuario;";
	$error=0;

	if (!pg_query($conn, $modifPass)){
		$errorpg = pg_last_error($conn);
		$termino = "ROLLBACK";
		$error=1;
	}else{
		$termino = "COMMIT";
	}
   pg_query($termino);
		
if ($error==1){
	echo '<script language="JavaScript"> alert("Los datos no se actualizaron correctamente. Pongase en contacto con el administrador");</script>';
}else{
	echo '<script language="JavaScript"> alert("Los datos se actualizaron correctamente."); window.location = "escritorioPasante.php?idPasante='.$id_Pasante.'";</script>';
}

include_once "cerrar_conexion.php";
?>