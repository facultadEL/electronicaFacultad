<?php
session_start();

include_once "conexion.php";
include_once "libreria.php";

$id_IdeaXprofe = $_REQUEST['idIdeaXprofe'];
$aprobar = $_REQUEST['aprobar'];

if ($id_IdeaXprofe != 0) {

	$sql = traerSqlCondicion('id,ideaaprobada,fecha_aprobada,fecha_desaprobada, idea, profesor','ideaxprofesor','id ='.$id_IdeaXprofe);
	$rowIdea=pg_fetch_array($sql,NULL,PGSQL_ASSOC);
	    $idea_aprobada = $rowIdea['ideaaprobada'];
	    $id_idea = $rowIdea['idea'];
	    $id_profesor = $rowIdea['profesor'];
	    $fecha = date(Ymd);

	    if ($aprobar == 0){

			//se entra acá lo desaprueba entonces el estado debe volver a 2 que sería pendiente de aprobación
			$calificarIdea = "UPDATE idea SET estado=2 WHERE id = $id_idea;";
	    	$calificarIdea .= "UPDATE ideaxprofesor SET ideaaprobada=FALSE, visto=TRUE, fecha_desaprobada='$fecha', fecha_aprobada=NULL WHERE id = $id_IdeaXprofe;";
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
				echo '<script language="JavaScript"> window.location = "calificarIdea.php";</script>';
			}
	    }else{
	    	//Veo si la calificación tiene 5 aprobados para cambiarle el estado
	    	$cantAprobados = contarRegistro('ideaaprobada','ideaxprofesor','idea = '.$id_idea.' AND ideaaprobada = TRUE AND profesor != '.$id_profesor);

			if ($cantAprobados == 4) {//pregunto por 4 porque como se van a ejecutar las consultas al mismo tiempo si entró a este if quiere decir que la aprobó y que es el quinto aprobado.
				$calificarIdea = "UPDATE idea SET estado=3 WHERE id = $id_idea;";
				//$calificarIdea .= "INSERT INTO informe_idea(idea,archivo_pdf,fecha_registro_pdf,descripcion)VALUES($id_idea,NULL,NULL,NULL)"			
			}

	    	$calificarIdea .= "UPDATE ideaxprofesor SET ideaaprobada=TRUE, visto=TRUE, fecha_aprobada='$fecha', fecha_desaprobada=NULL WHERE id = $id_IdeaXprofe;";

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
				echo '<script language="JavaScript"> window.location = "calificarIdea.php";</script>';
			}
	    }
}else{
	echo '<script language="JavaScript"> window.location = "calificarIdea.php";</script>';
}

include_once "cerrar_conexion.php";
?>