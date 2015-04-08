<?php
session_start();
//$passActual = $_REQUEST['passGenerado'];
$passNuevo = $_REQUEST['nuevoPass'];
//echo 'usuario: '.$usuario.'<br>';
//echo 'password: '.$password.'<br>';
$id_Pasante = $_SESSION['id'];
echo 'pass: '.$passNuevo;

include_once "conexion.php";

$modifPass="UPDATE pasante SET password='$passNuevo', primera_vez='FALSE' WHERE id = $id_Pasante;";
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
?>