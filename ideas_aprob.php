<?php
	session_start();
	include_once "chekearLogin.php";

?>
<!DOCTYPE html5>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' src="jquery.min-1.9.1.js"></script>
<link rel="stylesheet" href="css/calificarIdea.css">
<title><?php echo 'Bienvenido, '.$_SESSION['nombre'];?></title>

</head>
<body>
<div id="formulario">
<h2>Ideas en Curso</h2>
<?php include_once "menuAdmin.html";?>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="" method="post" enctype="multipart/form-data">
	<div class="calificarIdea">
		<table id="tablaIdeas" align="center">
			<tr>
				<th>Pasante</th>
				<th>Legajo</th>
				<th>Mail</th>
				<th>Idea</th>
				<th>Archivo</th>
				<!-- <th>Observaciones</th> -->
				<th>Convenios</th>
			</tr>
			<?php
				include_once "conexion.php";
				include_once "libreria.php";

				$calificacion = $_REQUEST['calificacion'];

					//$NuevasIdeas = traerSqlCondicion('ideaxprofesor.id, idea.nombre as nomidea, pasante.nombre as nompasante, apellido, nro_legajo, mail, archivo, visto','ideaxprofesor INNER JOIN idea ON ideaxprofesor.idea = idea.id INNER JOIN pasante ON idea.pasante_fk = pasante.id','profesor ='.$_SESSION['id_Profesor'].' AND visto = false');
				$NuevasIdeas = traerSqlCondicion('ideaxprofesor.id, idea, idea.nombre as nomidea, pasante.nombre as nompasante, apellido, nro_legajo, mail, archivo, visto, ideaaprobada, estado','ideaxprofesor INNER JOIN idea ON ideaxprofesor.idea = idea.id INNER JOIN pasante ON idea.pasante_fk = pasante.id','profesor ='.$_SESSION['id_Profesor'].' AND estado IN(3,5,6) AND pasante.deleted IS FALSE ORDER BY idea.id DESC');
					while($rowNuevasIdeas = pg_fetch_array($NuevasIdeas)){
						$id_IdeaXprofe = (empty($rowNuevasIdeas['id'])) ? 0 : $rowNuevasIdeas['id'];
						$estado = $rowNuevasIdeas['estado'];
						//if ($rowNuevasIdeas['visto'] == 't') {
							echo '<tr>';
								echo '<td>'.$rowNuevasIdeas['apellido'].', '.$rowNuevasIdeas['nompasante'].'</td>';
								echo '<td>'.$rowNuevasIdeas['nro_legajo'].'</td>';
								echo '<td>'.$rowNuevasIdeas['mail'].'</td>';
								echo '<td><a href="verIdea.php?id='.$rowNuevasIdeas['idea'].'">'.$rowNuevasIdeas['nomidea'].'</a></td>';
								echo '<td><a href="'.$rowNuevasIdeas['archivo'].'" target="_blank"><input type="button" id="btn_verincs" value="Ver" title="Ver archivo de la Idea" alt="ver"></a></td>';
								//echo '<td><a href="add_observa.php?idIdeaXprofe='.$id_IdeaXprofe.'"><input type="button" id="btn_observa" value="Agregar" title="Agregar Observaciones sobre la idea"></a></td>';
								if ($estado == 5) {
									echo '<td>En Ejecuci&oacute;n</td>';
								}elseif($estado == 3){
									echo '<td><a href="pasar_ejecucion.php?idea='.$rowNuevasIdeas['idea'].'"><input type="button" id="btn_verincs" value="OK" title="Pasa la idea a estado (en ejecuci&oacute;n) si tiene los convenios finalizados"></a></td>';
								}elseif($estado == 6){
									echo '<td>Finalizada</td>';
								}
									//echo '<td><a href="calificada.php?aprobar=0&idIdeaXprofe='.$id_IdeaXprofe.'"><input type="button" id="btn_confirm" value="No"></a>';
									//echo '<a href="calificada.php?aprobar=1&idIdeaXprofe='.$id_IdeaXprofe.'"><input type="button" id="btn_confirm" value="Si"></a></td>';
								 //}//else{
								// 	if ($rowNuevasIdeas['ideaaprobada'] == 'f') {
								// 		echo '<td><a href="calificada.php?aprobar=1&idIdeaXprofe='.$id_IdeaXprofe.'"><input type="button" id="btn_confirm" value="No Aprobado"></a></td>';
								// 	}else{
								// 		echo '<td><a href="calificada.php?aprobar=0&idIdeaXprofe='.$id_IdeaXprofe.'"><input type="button" id="btn_confirm" value="Aprobado"></a></td>';
								// 	}
								//}
							echo '</tr>';
						//}
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