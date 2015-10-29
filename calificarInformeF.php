<?php
	session_start();
	include_once "chekearLogin.php";

?>
<!DOCTYPE html5>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' src="jquery.min-1.9.1.js"></script>
<script src="jquery.mask.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/calificarIdea.css">
<title><?php echo 'Bienvenido, '.$_SESSION['nombre'];?></title>

</head>
<body>
<div id="formulario">
<h2>Calificar Informes Finales</h2>
<?php include_once "menuProfe.html";?>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="" method="post" enctype="multipart/form-data">
	<div class="calificarIdea">
		<table id="tablaIdeas" align="center">
			<tr>
				<th>Pasante</th>
				<th>Legajo</th>
				<th>Mail</th>
				<th>Inf. Final</th>
				<th>Archivo</th>
				<th>Observaciones</th>
				<th>Calificaciones</th>
				<th>Aprobar</th>
			</tr>
			<?php
				include_once "conexion.php";
				include_once "libreria.php";

				$calificacion = $_REQUEST['calificacion'];

				$NuevasIdeas = traerSqlCondicion('informexprofesor.id, informe, informe_final.nombre as nominforme, pasante.nombre as nompasante, apellido, nro_legajo, mail, archivo, visto, informeaprobado','informexprofesor INNER JOIN informe_final ON informexprofesor.informe = informe_final.id INNER JOIN pasante ON informe_final.pasante_fk = pasante.id','profesor ='.$_SESSION['id_Profesor'].' ORDER BY informe_final.id DESC');
					while($rowNuevasIdeas = pg_fetch_array($NuevasIdeas)){
						$id_IdeaXprofe = (empty($rowNuevasIdeas['id'])) ? 0 : $rowNuevasIdeas['id'];

						if ($rowNuevasIdeas['visto'] == 'f') {
							echo '<tr>';
								echo '<td>'.$rowNuevasIdeas['apellido'].', '.$rowNuevasIdeas['nompasante'].'</td>';
								echo '<td>'.$rowNuevasIdeas['nro_legajo'].'</td>';
								echo '<td>'.$rowNuevasIdeas['mail'].'</td>';
								echo '<td>'.$rowNuevasIdeas['nominforme'].'</td>';
								echo '<td><a href="http://extension.frvm.utn.edu.ar/electronicaFacultad/'.$rowNuevasIdeas['archivo'].'" target="_blank"><input type="button" id="btn_verincs" value="Ver" title="Ver archivo de la Idea" alt="ver"></a></td>';
								echo '<td><a href="add_observa_if.php?idIdeaXprofe='.$id_IdeaXprofe.'"><input type="button" id="btn_observa" value="Agregar" title="Agregar Observaciones sobre la informe"></a></td>';
								echo '<td><a href="ver_notas_if.php?informe='.$rowNuevasIdeas['informe'].'"><input type="button" id="btn_verincs" value="Ver" title="Ver las calificaciones de los dem&aacute;s profesores"></a></td>';
								
									echo '<td><a href="calificada_if.php?aprobar=0&idIdeaXprofe='.$id_IdeaXprofe.'"><input type="button" id="btn_confirm" value="No"></a>';
									echo '<a href="calificada_if.php?aprobar=1&idIdeaXprofe='.$id_IdeaXprofe.'"><input type="button" id="btn_confirm" value="Si"></a></td>';
							echo '</tr>';
						}
					}
					
				include_once "cerrar_conexion.php";
			?>
		</table>
	</div>
<div id="tablaCuerpo">
</div>
</center>
</form>
</div>
</body>
</html>