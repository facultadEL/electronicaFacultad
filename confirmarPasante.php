<?php
	session_start();
	include_once "chekearLogin.php";
/*	echo 'Rol: '.$_SESSION['rol_fk'].'<br>';
	echo 'id: '.$_SESSION['id'].'<br>';*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="jquery.mask.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/confirmarPasante.css">
<title><?php echo 'Bienvenido, '.$_SESSION['nombre'];?></title>
</head>

<?php
include_once "conexion.php";
include_once "libreria.php";
?>
<body>
<div id="formulario">
<h2>Confirmar Alumno</h2>
<?php include_once "menuAdmin.html";?>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="" method="post" enctype="multipart/form-data">

<center>
<div id="tablaGral">
<table id="tablaTitulo" align="center">
	<tr>
		<td id="tdTitulo"><label>Pasante</label></td>
		<td id="tdTitulo"><label>Legajo</label></td>
		<td id="tdTitulo"><label>Confirmar</label></td>
	</tr>
</table>
<table id="tablaCampos" align="center">
	<?php
		$noConfirmado = traerSqlCondicion('id, nombre, apellido, nro_legajo','pasante','confirmado = false');
		while($rowNoConfirmado=pg_fetch_array($noConfirmado,NULL,PGSQL_ASSOC)){
			$id = $rowNoConfirmado['id'];
			$nombre = $rowNoConfirmado['nombre'];
			$apellido = $rowNoConfirmado['apellido'];
			//$confirmado = $rowNoConfirmado['confirmado'];
			$nro_legajo = $rowNoConfirmado['nro_legajo'];
			echo '<tr>';
				echo '<td id="tdTitulo"><l1>'.$apellido.', '.$nombre.'</l1></td>';
				echo '<td id="tdTitulo"><l1>'.$nro_legajo.'</l1></td>';
				echo '<td id="tdTitulo"><a href="confirmado.php?idPasante='.$id.'"><input type="button" id="btn_confirm" value="No Confirmado"></a></td>';
			echo '</tr>';
		}
	?>
</table>
</div>
<hr width="100%">
<legend>Agregados Recientemente</legend>
<div id="tablaGral">
<table id="tablaTitulo" align="center">
	<tr>
		<td id="tdTitulo"><label>Pasante</label></td>
		<td id="tdTitulo"><label>Legajo</label></td>
		<td id="tdTitulo"><label>Cancelar Confirmaci&oacute;n</label></td>
	</tr>
</table>
<table id="tablaCampos" align="center">
	<?php
		//Utilizar la función diasRestantes y solo mostrar lo agregados en el último mes
		$confirmado = traerSqlCondicion('id, nombre, apellido, nro_legajo, fecreg','pasante','confirmado = true');
		while($rowConfirmado=pg_fetch_array($confirmado,NULL,PGSQL_ASSOC)){
			if (diasRestantes($rowConfirmado['fecreg']) < 30)
			{
				$id = $rowConfirmado['id'];
				$nombre = $rowConfirmado['nombre'];
				$apellido = $rowConfirmado['apellido'];
				$nro_legajo = $rowConfirmado['nro_legajo'];

				echo '<tr>';
					echo '<td id="tdTitulo"><l1>'.$apellido.', '.$nombre.'</l1></td>';
					echo '<td id="tdTitulo"><l1>'.$nro_legajo.'</l1></td>';
					echo '<td id="tdTitulo"><a href="confirmado.php?idPasante='.$id.'"><input type="button" id="btn_cancelar" value="Confirmado"></a></td>';
				echo '</tr>';
			}
		}

		include_once "cerrar_conexion.php";
	?>
</table>
</div>
</center>
</form>
</div>
</body>
</html>