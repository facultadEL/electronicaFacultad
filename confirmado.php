<?php
session_start();

include_once "conexion.php";
include_once "libreria.php";

$id_Pasante = $_REQUEST['idPasante'];

$sql = traerSqlCondicion('id,confirmado','pasante','id='.$id_Pasante);
$rowPasante=pg_fetch_array($sql,NULL,PGSQL_ASSOC);
    $confirmado = $rowPasante['confirmado'];
    
    if ($confirmado == 'f'){
    	$confirmPasante = "UPDATE pasante SET confirmado=TRUE WHERE id = $id_Pasante;";
			$error=0;
			if (!pg_query($conn, $confirmPasante)){
				$errorpg = pg_last_error($conn);
				$termino = "ROLLBACK";
				$error=1;
			}else{
				$termino = "COMMIT";
			}
		   pg_query($termino);
				
		if ($error==1){
			echo '<script language="JavaScript"> alert("Los datos no se modificaron correctamente. Pongase en contacto con el administrador");</script>';
		}else{
			echo '<script language="JavaScript"> window.location = "confirmarPasante.php";</script>';
		}
    }else{
    	$cancelarConfirmPasante = "UPDATE pasante SET confirmado=FALSE WHERE id = $id_Pasante;";
			$error=0;
			if (!pg_query($conn, $cancelarConfirmPasante)){
				$errorpg = pg_last_error($conn);
				$termino = "ROLLBACK";
				$error=1;
			}else{
				$termino = "COMMIT";
			}
		   pg_query($termino);
				
		if ($error==1){
			echo '<script language="JavaScript"> alert("Los datos no se modificaron correctamente. Pongase en contacto con el administrador");</script>';
		}else{
			echo '<script language="JavaScript"> window.location = "confirmarPasante.php";</script>';
		}
    }

include_once "cerrar_conexion.php";
?>