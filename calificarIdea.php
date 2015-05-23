<?php
	session_start();
	include_once "chekearLogin.php"

?>
<!DOCTYPE>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' src="jquery.min-1.9.1.js"></script>
<script src="jquery.mask.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/calificarIdea.css">
<link rel="stylesheet" href="css/font-awesome-4.3.0/css/font-awesome.css">
<title><?php echo 'Bienvenido, '.$_SESSION['nombre'];?></title>

</head>
<body>
<div id="formulario">
<h2>Calificar Ideas</h2>
<?php include_once "menuProfe.html";?>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="" method="post" enctype="multipart/form-data">
	<div class="calificarIdea">
		<table id="tablaIdeas" align="center">
			<tr>
				<th>Pasante</th>
				<th>Legajo</th>
				<th>Mail</th>
				<th>Idea</th>
				<th>Archivo</th>
				<th>Aprobar</th>
			</tr>
			<?php
				include_once "conexion.php";
				include_once "libreria.php";

				$calificacion = $_REQUEST['calificacion'];

					//$NuevasIdeas = traerSqlCondicion('ideaxprofesor.id, idea.nombre as nomidea, pasante.nombre as nompasante, apellido, nro_legajo, mail, archivo, visto','ideaxprofesor INNER JOIN idea ON ideaxprofesor.idea = idea.id INNER JOIN pasante ON idea.pasante_fk = pasante.id','profesor ='.$_SESSION['id_Profesor'].' AND visto = false');
				$NuevasIdeas = traerSqlCondicion('ideaxprofesor.id, idea.nombre as nomidea, pasante.nombre as nompasante, apellido, nro_legajo, mail, archivo, visto','ideaxprofesor INNER JOIN idea ON ideaxprofesor.idea = idea.id INNER JOIN pasante ON idea.pasante_fk = pasante.id','profesor ='.$_SESSION['id_Profesor']);
					while($rowNuevasIdeas = pg_fetch_array($NuevasIdeas)){
						$id_Idea = (empty($rowNuevasIdeas['id'])) ? 0 : $rowNuevasIdeas['id'];
						
						echo '<tr>';
							echo '<td>'.$rowNuevasIdeas['apellido'].', '.$rowNuevasIdeas['nompasante'].'</td>';
							echo '<td>'.$rowNuevasIdeas['nro_legajo'].'</td>';
							echo '<td>'.$rowNuevasIdeas['mail'].'</td>';
							echo '<td>'.$rowNuevasIdeas['nomidea'].'</td>';
							echo '<td><a href="'.$rowNuevasIdeas['archivo'].'"><input type="button" id="btn_verincs" value="Ver" title="Ver archivo de la Idea" alt="ver"></a></td>';
							if ($rowNuevasIdeas['visto'] == 'f') {
								echo '<td><a href="calificada.php?aprobar=0&idIdea='.$id_Idea.'"><input type="button" id="btn_confirm" value="No"></a>';
								echo '<a href="calificada.php?aprobar=1&idIdea='.$id_Idea.'"><input type="button" id="btn_confirm" value="Si"></a></td>';
							}else{
								if ($calificacion == 0) {
									echo '<td><a href="calificada.php?aprobar=1&idIdea='.$id_Idea.'"><input type="button" id="btn_confirm" value="No Aprobado"></a></td>';
								}else{
									echo '<td><a href="calificada.php?aprobar=0&idIdea='.$id_Idea.'"><input type="button" id="btn_confirm" value="Aprobado"></a></td>';
								}
							}
						echo '</tr>';
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