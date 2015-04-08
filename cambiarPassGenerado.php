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
<link rel="stylesheet" href="css/cambiarPassGenerado.css">
<title><?php echo 'Bienvenido, '.$_SESSION['nombre'];?></title>
<script>

	function checkPass()
	{
		var passActual = $('#passGenerado').val();
		var passNuevo = $('#passNuevo').val();
		if(passActual == passNuevo)
		{
			alert("La nueva contraseña es igual a la anterior. Por favor ingrese una distinta");
			$('#passNuevo').val("");
			$('#passNuevo').focus();
		}
	}
</script>
</head>
<body>
<div id="formulario">
<h2>Cambiar Contrase&ntilde;a</h2>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="guardarCambioPass.php" method="post" enctype="multipart/form-data">
<table id="tabla" align="center">
	<tr>
		<td align="center"><input type="password" id="passGenerado" name="passGenerado" value="" placeholder="Ingrese su contrase&ntilde;a actual" autocomplete="off" autofocus required/></td>
	</tr>
	<tr>
		<td align="center"><input type="password" id="passNuevo" name="nuevoPass" onchange="checkPass();" value="" placeholder="Ingrese su nueva contrase&ntilde;a" autocomplete="off" required/></td>
	</tr>
</table>
<table id="tablaBtn" align="center">
	<tr width="100%">	
		<td width="50%" align="right"><a href="login.php"><input type="button" id="btn_cancelar" value="Cancelar"></a></td>
		<td width="50%" align="left"><input class="submit" type="submit" value="Guardar"/></td>
	</tr>
</table>
</form>
</div>
</body>
</html>