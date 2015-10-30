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

$id_Profesor = (empty($_REQUEST['idProfesor'])) ? 0 : $_REQUEST['idProfesor'];
//$vernotas = (empty($_REQUEST['vernotas'])) ? 0 : $_REQUEST['vernotas'];
//$vernotasadmin = (empty($_REQUEST['vernotasadmin'])) ? 0 : $_REQUEST['vernotasadmin'];
$idIdea = (empty($_REQUEST['informe'])) ? 0 : $_REQUEST['informe'];
//echo 'notasAdm: '.$vernotasadmin.'<br>';
//echo 'notas: '.$vernotas.'<br>';

//$enviado = $_REQUEST['enviado'];
//if (isset($_REQUEST['enviado'])) { //para que no se ejecute el código en caso de no tener un archivo cargado

?>
<body>
<div id="formulario">
<h2>Consultas</h2>
<?php include_once "menuPasante.html";?>
<form class="nueva_idea" name="consulta" id="nueva_idea" action="envioMailProfe_if.php" method="post" enctype="multipart/form-data">
<table class="mail">
	<tr>
		<td class="label">
			<label for="nombre">Para: </label>
		</td>
		<td class="campo">
			<?php
				$sql = traerSqlCondicion('id, nombre, apellido','profesor','id='.$id_Profesor);
				$rowNombre = pg_fetch_array($sql);
				echo '<l1> '.$rowNombre['apellido'].', '.$rowNombre['nombre'].'</l1>';
				echo '<input type="hidden" name="idProfesor" value="'.$rowNombre['id'].'"/>';

				include_once "cerrar_conexion.php";
			?>
		</td>
	</tr>
	<tr>
		<td class="label">
			<label for="nombre">Mensaje: </label>
		</td>
		<td class="campo">
			<textarea name="msj" class="msj" autofocus></textarea>
		</td>
	</tr>
</table>
<center>
<table id="tablaBtn">
	<tr>	
		<td>
			<?php 
				if ($_SESSION['rol_fk'] == 3) {
					echo '<td width="50%" align="right"><a href="ver_notas_if.php?informe='.$idIdea.'"><input type="button" id="btn_cancelar" value="Cancelar"></a></td>';
				}elseif ($_SESSION['rol_fk'] == 2){
					echo '<td width="50%" align="right"><a href="ver_notas_admin_if.php?informe='.$idIdea.'"><input type="button" id="btn_cancelar" value="Cancelar"></a></td>';
				}elseif ($_SESSION['rol_fk'] == 1){
					echo '<td width="50%" align="right"><a href="escritorioPasante.php"><input type="button" id="btn_cancelar" value="Cancelar"></a></td>';
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