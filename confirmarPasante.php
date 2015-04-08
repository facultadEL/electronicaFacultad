<?php
	session_start();
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
<nav id="menu">
	<ul> 
		<li><a href="enDesarrollo.php">Perfil</a></li>
		<li><a href="enDesarrollo.php">Menú2</a></li>
		<li><a href="enDesarrollo.php">Cerrar Sesi&oacute;n</a></li>
	</ul>
</nav>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="?enviado=1" method="post" enctype="multipart/form-data">

<table id="tablaTitulo" align="center">
	<tr>
		<td id="tdTitulo"><label>Pasante</label></td>
		<td id="tdTitulo"><label>Legajo</label></td>
		<td id="tdTitulo"><label>Confirmado</label></td>
	</tr>
</table>
<table id="tablaCampos" align="center">
	<?php
		$nuevoAlumno = pg_query("SELECT id, nombre, apellido, confirmado, nro_legajo FROM pasante WHERE confirmado = false;");
		while($rowNewPasante=pg_fetch_array($nuevoAlumno,NULL,PGSQL_ASSOC)){
			$id = $rowNewPasante['id'];
			$nombre = $rowNewPasante['nombre'];
			$apellido = $rowNewPasante['apellido'];
			$confirmado = $rowNewPasante['confirmado'];
			$nro_legajo = $rowNewPasante['nro_legajo'];
			echo '<tr>';
				echo '<td id="tdTitulo"><l1>'.$apellido.', '.$nombre.'</l1></td>';
				echo '<td id="tdBtn"><l1>'.$nro_legajo.'</l1></td>';
				//hacer un if para que diferencie los botones segun el estado del alumno --> $confirmado
				echo '<td id="tdBtn"><a href="confirmado.php"><input type="button" id="btn_confirm" value="Confirmar"></a></td>';
			echo '</tr>';
		}
	?>
</table>
<!-- <table id="tablaBtn" align="center">
	<tr width="100%">	
		<td width="100%" align="center">
			<input class="submit" type="submit" value="Guardar"/>
		</td>
	</tr>
</table> -->
</form>
</div>
</body>
</html>