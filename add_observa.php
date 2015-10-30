<?php
	session_start();

	include_once "chekearLogin.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' src="jquery.min-1.9.1.js"></script>
<link rel="stylesheet" href="css/sendToProfe.css">
<title><?php echo 'Bienvenido, '.$_SESSION['nombre'];?></title>
</head>

<?php
include_once "conexion.php";
include_once "libreria.php";

$idIdeaXprofe = (empty($_REQUEST['idIdeaXprofe'])) ? 0 : $_REQUEST['idIdeaXprofe'];
?>
<body>
<div id="formulario">
<h2>Observaciones de la Idea</h2>
<?php include_once "menuProfe.html";?>
<form class="nueva_idea" name="consulta" id="nueva_idea" action="save_observa.php" method="post" enctype="multipart/form-data">
<table class="mail">
	<tr>
		<td class="label">
			<label for="nombre">Idea: </label>
		</td>
		<td class="campo">
			<?php
				$sql = traerSqlCondicion('ideaxprofesor.id, idea.nombre nom_idea','ideaxprofesor INNER JOIN idea ON ideaxprofesor.idea = idea.id','ideaxprofesor.id='.$idIdeaXprofe);
				$rowNombre = pg_fetch_array($sql);
				echo '<l1> '.$rowNombre['nom_idea'].'</l1>';
				echo '<input type="hidden" name="ideaxprofesor" value="'.$idIdeaXprofe.'"/>';

				include_once "cerrar_conexion.php";
			?>
		</td>
	</tr>
	<tr>
		<td class="label">
			<label for="nombre">Observaci&oacute;n: </label>
		</td>
		<td class="campo">
			<textarea name="observa" class="msj" autofocus></textarea>
		</td>
	</tr>
</table>
<center>
<table id="tablaBtn">
	<tr>	
		<td>
			<?php
				if ($_SESSION['rol_fk'] == 2) {
					echo '<td width="50%" align="right"><a href="enCursoAdmin.php"><input type="button" id="btn_cancelar" value="Cancelar"></a></td>';
				}elseif ($_SESSION['rol_fk'] == 3) {
					echo '<td width="50%" align="right"><a href="calificarIdea.php"><input type="button" id="btn_cancelar" value="Cancelar"></a></td>';
				}
			?>

			<td width="50%" align="left"><input class="submit" type="submit" value="Enviar"/></td>
 		</td>
	</tr>
</table>
</center>
</form>
</div>
</body>
</html>