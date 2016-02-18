<?php
session_start();
//$passActual = $_REQUEST['passGenerado'];
$passNuevo = md5($_REQUEST['nuevoPass']);
//echo 'usuario: '.$usuario.'<br>';
//echo 'password: '.$password.'<br>';
if (empty($_SESSION['id_Pasante'])) {
	$id_Pasante = $_REQUEST['idPasante'];
	//echo 'idR: '.$id_Pasante;
}else{
	$id_Pasante = $_SESSION['id_Pasante'];
	//echo 'idS: '.$id_Pasante;
}
//echo 'pass: '.$passNuevo;

include_once "conexion.php";
include_once "libreria.php";

$sql = traerSqlCondicion('usuario_fk','pasante','id='.$id_Pasante);
$rowUsu = pg_fetch_array($sql);
	$id_Usuario = $rowUsu['usuario_fk'];

$modifPass="UPDATE usuario SET password='$passNuevo', primera_vez='FALSE' WHERE id = $id_Usuario;";
$modifPass.="DELETE FROM recupera_pass WHERE pasante_fk = $id_Pasante;";
//echo $modifPass;
$error = guardarSql($modifPass);
		
if ($error==1){
	echo '<script language="JavaScript"> alert("Los datos no se actualizaron correctamente. Pongase en contacto con el administrador");</script>';
}else{
	echo '<script language="JavaScript"> alert("Los datos se actualizaron correctamente."); window.location = "escritorioPasante.php?idPasante='.$id_Pasante.'";</script>';
}

include_once "cerrar_conexion.php";
?>