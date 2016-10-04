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
				<!-- <th>Archivo</th> -->
				<!-- <th>Observaciones</th> -->
				<th>Calificaciones</th>
			</tr>
			<?php
				include_once "conexion.php";
				include_once "libreria.php";

				$calificacion = $_REQUEST['calificacion'];

					//$NuevasIdeas = traerSqlCondicion('ideaxprofesor.id, idea.nombre as nomidea, pasante.nombre as nompasante, apellido, nro_legajo, mail, archivo, visto','ideaxprofesor INNER JOIN idea ON ideaxprofesor.idea = idea.id INNER JOIN pasante ON idea.pasante_fk = pasante.id','profesor ='.$_SESSION['id_Profesor'].' AND visto = false');
				$NuevasIdeas = traerSqlCondicion('ideaxprofesor.id, idea, idea.nombre as nomidea, pasante.nombre as nompasante, apellido, nro_legajo, mail, archivo, visto, ideaaprobada','ideaxprofesor INNER JOIN idea ON ideaxprofesor.idea = idea.id INNER JOIN pasante ON idea.pasante_fk = pasante.id','estado = 2 AND profesor ='.$_SESSION['id_Profesor'].' AND pasante.deleted IS FALSE ORDER BY idea.id DESC');
					while($rowNuevasIdeas = pg_fetch_array($NuevasIdeas)){
						$id_IdeaXprofe = (empty($rowNuevasIdeas['id'])) ? 0 : $rowNuevasIdeas['id'];
						

						//if ($rowNuevasIdeas['visto'] == 't') {

							echo '<tr>';
								echo '<td>'.$rowNuevasIdeas['apellido'].', '.$rowNuevasIdeas['nompasante'].'</td>';
								echo '<td>'.$rowNuevasIdeas['nro_legajo'].'</td>';
								echo '<td>'.$rowNuevasIdeas['mail'].'</td>';
								echo '<td>'.$rowNuevasIdeas['nomidea'].'</td>';
								echo '<td><a href="ver_notas_admin.php?idea='.$rowNuevasIdeas['idea'].'"><input type="button" id="btn_verincs" value="Ver" title="Ver las calificaciones de los dem&aacute;s profesores"></a></td>';
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