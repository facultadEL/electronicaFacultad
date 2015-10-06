<?php
	session_start();
	include_once "chekearLogin.php";

?>
<!DOCTYPE html>
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
<h2>Calificar Ideas</h2>
<?php include_once "menuConstatador.html";?>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="" method="post" enctype="multipart/form-data">
	<div class="calificarIdea">
		<table id="tablaIdeas" align="center">
			<tr>
				<th>Pasante</th>
				<th>Legajo</th>
				<th>Mail</th>
				<th>Idea</th>
				<th>Archivo</th>
				<th>Seguimiento</th>
			</tr>
			<?php
				include_once "conexion.php";
				include_once "libreria.php";

					//$NuevasIdeas = traerSqlCondicion('ideaxprofesor.id, idea.nombre as nomidea, pasante.nombre as nompasante, apellido, nro_legajo, mail, archivo, visto','ideaxprofesor INNER JOIN idea ON ideaxprofesor.idea = idea.id INNER JOIN pasante ON idea.pasante_fk = pasante.id','profesor ='.$_SESSION['id_Profesor'].' AND visto = false');
				$NuevasIdeas = traerSqlCondicion('idea.id, idea.nombre as nomidea, archivo, pasante_fk, pasante.nombre as nompasante, apellido, nro_legajo, mail','idea INNER JOIN pasante ON idea.pasante_fk = pasante.id','estado = 5 ORDER BY idea.id DESC');
					while($rowNuevasIdeas = pg_fetch_array($NuevasIdeas)){
						$id_idea = (empty($rowNuevasIdeas['id'])) ? 0 : $rowNuevasIdeas['id'];
						
						echo '<tr>';
							echo '<td>'.$rowNuevasIdeas['apellido'].', '.$rowNuevasIdeas['nompasante'].'</td>';
							echo '<td>'.$rowNuevasIdeas['nro_legajo'].'</td>';
							echo '<td>'.$rowNuevasIdeas['mail'].'</td>';
							echo '<td>'.$rowNuevasIdeas['nomidea'].'</td>';
							echo '<td><a href="'.$rowNuevasIdeas['archivo'].'"><input type="button" id="btn_verincs" value="Ver" title="Ver archivo de la Idea" alt="ver"></a></td>';
							echo '<td><a href="pdf_constatador.php?idea='.$id_idea.'"><input type="button" id="btn_subpdf" value="Subir PDF" title="Subir seguimiento de la Idea" alt="Subir PDF"></a></td>';
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