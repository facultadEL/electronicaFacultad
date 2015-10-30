<?php
session_start();

include_once "conexion.php";
include_once "libreria.php";

$id_IdeaXprofe = $_REQUEST['idIdeaXprofe'];
$aprobar = $_REQUEST['aprobar'];
$iec = (empty($_REQUEST['iec'])) ? 0 : $_REQUEST['iec'];

if ($id_IdeaXprofe != 0) {

	$sql = traerSqlCondicion('informexprofesor.id,informeaprobado,fecha_calif,observacion,informe,profesor,pasante_fk','informexprofesor INNER JOIN informe_final ON informexprofesor.informe = informe_final.id','informexprofesor.id ='.$id_IdeaXprofe);
	$rowIdea=pg_fetch_array($sql,NULL,PGSQL_ASSOC);
	    $idea_aprobada = $rowIdea['informeaprobado'];
	    $id_idea = $rowIdea['informe'];
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
				$calificarIdea = "UPDATE informe_final SET estado=4 WHERE id = $id_idea;";
	    		$calificarIdea .= "UPDATE informexprofesor SET informeaprobado=FALSE, visto=TRUE, fecha_calif='$fecha' WHERE informexprofesor.id = $id_IdeaXprofe;";

	    		$cuerpo = "
					<div align='left'>
					    <div align='left'>
					        <strong>Informe no aprobado</strong><br/><br/>

					        Su informe no ha sido aprobado, a continuaci&oacute;n se describen los errores y como deber&iacute;a proceder: .<br/><br />
					        
					        1) <strong>Comentarios del profesor: </strong> $correciones.<br /><br />
							2) <strong>Profesor que calific&oacute; el informe: </strong> $profesor. Por favor, p&oacute;ngase en contacto con el para mas informaci&oacute;n.<br /><br />
							3) <strong>Nuevo informe: </strong> paso siguiente deber&aacute; subir un nuevo PDF con las correciones realizadas.<br/><br />
					    </div>
					</div>
				";
				$asunto = "Informaci&oacute;n sobre el informe final";
				$sendFrom = "dpto-electronica@frvm.utn.edu.ar";
				$from_name = "Dpto Electronica";
				$to = $mail_pasante;
				$to2 = ADMIN;

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
				enviarMail($cuerpo,$asunto,$sendFrom,$from_name,$to,$to2,1);
				if ($iec == 1) {
					echo '<script language="JavaScript"> window.location = "enCurso_if.php";</script>';
				}else{
					echo '<script language="JavaScript"> window.location = "calificarInformeF.php";</script>';
				}
			}
	    }else{ //IDEA APROBADA
	    	//Veo si la calificación tiene 5 aprobados para cambiarle el estado
	    	$cantAprobados = contarRegistro('informeaprobado','informexprofesor','informe = '.$id_idea.' AND informeaprobado = TRUE AND profesor != '.$id_profesor);

	    	$cant_NoAprobados = contarRegistro('informeaprobado','informexprofesor','informe = '.$id_idea.' AND informeaprobado = FALSE AND profesor != '.$id_profesor);

			if ($cantAprobados == 4) {//pregunto por 4 porque como se van a ejecutar las consultas al mismo tiempo si entró a este if quiere decir que la aprobó y que es el quinto aprobado.

				$cuerpo = "
					<div align='left'>
					    <div align='left'>
					        <strong>Informe aprobado</strong><br/><br/>

					        Su informe ha sido aprobado, la pr&aacute;ctica supervisada ha finalizado.<br/><br />
					    </div>
					</div>
				";
				$asunto = "Informaci&oacute;n sobre informe final";
				$sendFrom = "dpto-electronica@frvm.utn.edu.ar";
				$from_name = "Dpto Electronica";
				$to = $mail_pasante;

				//$f_a = date(Ymd);
				//$calificarIdea = "UPDATE informe_final SET estado=3,fecha_aprobada='$f_a' WHERE id = $id_idea;";
				$calificarIdea = "UPDATE informe_final SET estado=7 WHERE id = $id_idea;";
				enviarMail($cuerpo,$asunto,$sendFrom,$from_name,$to,'',1);

				$sqlPasante = traerSqlCondicion('nombre,apellido,nro_legajo','pasante','pasante.id= '.$rowIdea['pasante_fk']);
				$rowP=pg_fetch_array($sqlPasante,NULL,PGSQL_ASSOC);
					$nombreC = $rowP['apellido'].', '.$rowP['nombre'];
					$legajo = $rowP['nro_legajo'];
				$cuerpo2 = "
					<div align='left'>
					    <div align='left'>
					        <strong>Informe Final Aprobado</strong><br/><br/>

					        El pasante $nombreC con legajo: $legajo, ha finalizado la pr&aacute;ctica supervisada ya que su informe final ha sido aprobado.<br/><br />
					    </div>
					</div>
				";
				$to2 = ADMIN;
				$to22 = DEPTO;
				enviarMail($cuerpo2,$asunto2,$sendFrom,$from_name,$to2,$to22,1);
			}elseif ($cant_NoAprobados == 0 && $cantAprobados < 4) {
				$calificarIdea = "UPDATE informe_final SET estado=2 WHERE id = $id_idea;";
			}

	    	$calificarIdea .= "UPDATE informexprofesor SET informeaprobado=TRUE, visto=TRUE, fecha_calif='$fecha' WHERE id = $id_IdeaXprofe;";

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
					echo '<script language="JavaScript"> window.location = "enCurso_if.php";</script>';
				}else{
					echo '<script language="JavaScript"> window.location = "calificarInformeF.php";</script>';
				}
			}
	    }
}else{
	echo '<script language="JavaScript"> window.location = "calificarInformeF.php";</script>';
}

include_once "cerrar_conexion.php";
?>