<?php
	session_start();
/*	echo 'Rol: '.$_SESSION['rol_fk'].'<br>';
	echo 'id: '.$_SESSION['id'].'<br>';*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' src="jquery-1.11.3.min.js"></script>
<link rel="stylesheet" href="css/cambiarPassGenerado.css">
<title>Restaurar Contrase&ntilde;a</title>
<script>

	function checkPass(){
		var pass_nuevo = $('#pass_nuevo').val();
		var pass_repetido = $('#pass_repetido').val();
		//alert(pass_nuevo);
		//alert(pass_repetido);
		if(pass_nuevo != pass_repetido){
			alert("Las contraseñas no son iguales. Deben coincidir.");
			$('#pass_repetido').val("");
			$('#pass_repetido').focus();
			return false;
		}else{
			if (pass_repetido.length < 6) {
				alert("La nueva contraseña debe ser mayor a 6 caracteres");
				$('#pass_nuevo').val("");
				$('#pass_repetido').val("");
				$('#pass_nuevo').focus();	
				return false;
			}else{
				return true;
				//$('#nueva_idea').attr('action', 'guardarCambioPass.php');
				//$('#nueva_idea').submit();
			}
		}
	}
</script>
</head>
<body>
<?php

$codigo_personal = (empty($_GET['pass'])) ? 0 : $_GET['pass'];

include_once "conexion.php";
include_once "libreria.php";

if ($codigo_personal != 0) {
	//echo 'mail2: '.$recuperarPass;
    $sqlDatos = traerSqlCondicion('fecha_sol,pasante_fk','recupera_pass',"codigo_personal = '$codigo_personal'");
    $rowDatos = pg_fetch_array($sqlDatos);
        $fecha_sol = $rowDatos['fecha_sol'];
        $id_pasante = $rowDatos['pasante_fk'];
}
$fecha_actual = date('Y-m-d H:i');
if (!empty($fecha_sol)) {
	$diferencia = dateTime_diff('h',$fecha_sol,$fecha_actual);
	if ($diferencia > 2) {
		echo '<script language="JavaScript"> window.location="login.php";   alert("El tiempo de la solicitud para restaurar la contraseña ha expirado."); </script>';
	}
}

//echo 'id: '.$id_pasante;
?>

<div id="formulario">
<h2>Cambiar Contrase&ntilde;a</h2>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="guardarCambioPass.php" onsubmit="return checkPass();" method="post" enctype="multipart/form-data">
<input type="hidden" name="idPasante" value="<?php echo $id_pasante; ?>" />
<table id="tabla" align="center">
	<tr>
		<td align="center"><input type="password" id="pass_nuevo" name="pass_nuevo" value="" placeholder="Ingrese su contrase&ntilde;a nueva" autocomplete="off" autofocus required/></td>
	</tr>
	<tr>
		<td align="center"><input type="password" id="pass_repetido" name="nuevoPass" value="" placeholder="Repita la contrase&ntilde;a" autocomplete="off" required/></td>
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