<?php
session_start();

include_once "conexion.php";
include_once "libreria.php";

$id_IdeaXprofe = $_REQUEST['idIdeaXprofe'];
$aprobar = $_REQUEST['aprobar'];
$iec = (empty($_REQUEST['iec'])) ? 0 : $_REQUEST['iec'];

if ($id_IdeaXprofe != 0) {

	$sql = traerSqlCondicion('ideaxprofesor.id,ideaaprobada,fecha_calif,observacion,idea,profesor,pasante_fk','ideaxprofesor INNER JOIN idea ON ideaxprofesor.idea = idea.id','ideaxprofesor.id ='.$id_IdeaXprofe);
	$rowIdea=pg_fetch_array($sql,NULL,PGSQL_ASSOC);
	    $idea_aprobada = $rowIdea['ideaaprobada'];
	    $id_idea = $rowIdea['idea'];
	    $id_profesor = $rowIdea['profesor'];
	    $fecha = date(Ymd);
	    $observacion = (empty($rowIdea['observacion'])) ? 0 : $rowIdea['observacion'];
	    $mail_pasante = traer_dato('mail','pasante','pasante.id= '.$rowIdea['pasante_fk']);
	    $profesor = $_SESSION['apellido'].', '.$_SESSION['nombre'];

	    if ($observacion == 0) {
	    	$correciones = 'No realiz&oacute; comentarios';
	    }else{
	    	$correciones = $observacion;
	    }

	    if ($aprobar == 0){ //IDEA DESAPROBADA
				$calificarIdea = "UPDATE idea SET estado=4 WHERE id = $id_idea;";
	    		$calificarIdea .= "UPDATE ideaxprofesor SET ideaaprobada=FALSE, visto=TRUE, fecha_calif='$fecha' WHERE ideaxprofesor.id = $id_IdeaXprofe;";

	    		$cuerpo = "
					<div align='left'>
					    <div align='left'>
					        <strong>Idea no aprobada</strong><br/><br/>

					        Su idea no ha sido aprobada, a continuaci&oacute;n se describen los errores y como deber&iacute;a proceder: .<br/><br />
					        
					        1) <strong>Comentarios del profesor: </strong> $correciones.<br /><br />
							2) <strong>Profesor que calific&oacute; la idea: </strong> $profesor. Por favor, p&oacute;ngase en contacto con el para mas informaci&oacute;n.<br /><br />
							3) <strong>Nueva idea: </strong> paso siguiente deber&aacute; subir un nuevo PDF con las correciones realizadas.<br/><br />
					    </div>
					</div>
				";
				$asunto = "Informacion sobre la idea";
				$sendFrom = "dpto-electronica@frvm.utn.edu.ar";
				$from_name = "Dpto Electronica";
				//$to = "etell@frvm.utn.edu.ar";
				$to = $mail_pasante;
				$to2 = "lucas.peraltam@outlook.com";


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
				enviarMail($cuerpo,$asunto,$sendFrom,$from_name,$to,$to2);
				if ($iec == 1) {
					echo '<script language="JavaScript"> window.location = "enCurso.php";</script>';
				}else{
					echo '<script language="JavaScript"> window.location = "calificarIdea.php";</script>';
				}
			}
	    }else{ //IDEA APROBADA
	    	//Veo si la calificación tiene 5 aprobados para cambiarle el estado
	    	$cantAprobados = contarRegistro('ideaaprobada','ideaxprofesor','idea = '.$id_idea.' AND ideaaprobada = TRUE AND profesor != '.$id_profesor);

	    	$cant_NoAprobados = contarRegistro('ideaaprobada','ideaxprofesor','idea = '.$id_idea.' AND ideaaprobada = FALSE AND profesor != '.$id_profesor);

			if ($cantAprobados == 4) {//pregunto por 4 porque como se van a ejecutar las consultas al mismo tiempo si entró a este if quiere decir que la aprobó y que es el quinto aprobado.
				$calificarIdea = "UPDATE idea SET estado=3 WHERE id = $id_idea;";
				//$calificarIdea .= "INSERT INTO informe_idea(idea,archivo_pdf,fecha_registro_pdf,descripcion)VALUES($id_idea,NULL,NULL,NULL)"			
			}elseif ($cant_NoAprobados == 0 && $cantAprobados < 4) {
				$calificarIdea = "UPDATE idea SET estado=2 WHERE id = $id_idea;";
			}

	    	$calificarIdea .= "UPDATE ideaxprofesor SET ideaaprobada=TRUE, visto=TRUE, fecha_calif='$fecha' WHERE id = $id_IdeaXprofe;";

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
				if ($iec == 1) {
					echo '<script language="JavaScript"> window.location = "enCurso.php";</script>';
				}else{
					echo '<script language="JavaScript"> window.location = "calificarIdea.php";</script>';
				}
			}
	    }
}else{
	echo '<script language="JavaScript"> window.location = "calificarIdea.php";</script>';
}

include_once "cerrar_conexion.php";
?>