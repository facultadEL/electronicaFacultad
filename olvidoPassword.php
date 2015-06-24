<?php
	session_start();
	//include_once "chekearLogin.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' src="jquery-1.11.3.min.js"></script>
<link rel="stylesheet" href="css/olvidoPassword.css">
<title><?php echo 'Bienvenido, '.$_SESSION['nombre'];?></title>
<script>
	var mailDictionary = [];

	function setMail(mailToSet)
	{
		mailDictionary.push(mailToSet);
	}

	function checkMail()
	{
		var mailABuscar = $('#mail').val();
		if($.inArray(mailABuscar, mailDictionary) == -1)
		{
			alert("El mail ingresado no se encuentra registrado. Intente otra vez en caso de error de escritura.");
			$('#mail').val("");
			$('#mail').focus();
		}
	}
</script>
</head>
<body>
<?php
include_once "conexion.php";
include_once "libreria.php";

$sql = traerSql('mail', 'pasante');
while ($rowVerifMail = pg_fetch_array($sql,NULL,PGSQL_ASSOC)) {
	echo "<script>setMail('".$rowVerifMail['mail']."')</script>";
}

include_once "cerrar_conexion.php";
?>
<div id="formulario">
<h2>Recuperar Contrase&ntilde;a</h2>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="mailOlvidoPass.php" method="post" enctype="multipart/form-data">
<table id="tabla" align="center">
	<tr>
		<td align="center"><input type="email" id="mail" name="recuperarPass" onchange="checkMail();" value="" placeholder="Ingrese su E-mail" autocomplete="off" autofocus required/></td>
	</tr>
</table>
<table id="tablaBtn" align="center">
	<tr width="100%">	
		<td width="50%" align="right"><a href="login.php"><input type="button" id="btn_cancelar" value="Cancelar"></a></td>
		<td width="50%" align="left"><input class="submit" type="submit" value="Recuperar"/></td>
	</tr>
</table>
</form>
</div>
</body>
</html>