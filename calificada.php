<?php
session_start();

include_once "conexion.php";
include_once "libreria.php";

$id_Idea = $_REQUEST['idIdea'];
$aprobar = $_REQUEST['aprobar'];

if ($id_Idea != 0) {

	$sql = traerSqlCondicion('id,ideaaprobada,fecha_aprobada,fecha_desaprobada','ideaxprofesor','idea='.$id_Idea);
	$rowIdea=pg_fetch_array($sql,NULL,PGSQL_ASSOC);
	    $idea_aprobada = $rowIdea['ideaaprobada'];
	    $fecha = date(Ymd);
	    if ($aprobar == 0){
	    	$calificarIdea = "UPDATE ideaxprofesor SET ideaaprobada=FALSE, visto=TRUE, fecha_desaprobada='$fecha', fecha_aprobada=NULL WHERE id = $id_Idea;";
				$error=0;
				if (!pg_query($conn, $calificarIdea)){
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
				echo '<script language="JavaScript"> window.location = "calificarIdea.php?calificacion=0";</script>';
			}
	    }else{
	    	$calificarIdea = "UPDATE ideaxprofesor SET ideaaprobada=TRUE, visto=TRUE, fecha_aprobada='$fecha', fecha_desaprobada=NULL WHERE id = $id_Idea;";
				$error=0;
				if (!pg_query($conn, $calificarIdea)){
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
				echo '<script language="JavaScript"> window.location = "calificarIdea.php?calificacion=1";</script>';
			}
	    }
}else{
	echo '<script language="JavaScript"> window.location = "calificarIdea.php";</script>';
}

include_once "cerrar_conexion.php";
?>