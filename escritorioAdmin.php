<?php
	session_start();
	include_once "chekearLogin.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' src="jquery.min-1.9.1.js"></script>
<link rel="stylesheet" href="css/escritorioPasante.css">
<title><?php echo 'Bienvenido, '.$_SESSION['nombre'];?></title>
<script>
	function recordar(){

		//var parametros = {};

		$.ajax({
			type: "POST",
			url: "recordar.php",
			//data: parametros,
			async: false,
			success:  function (response) { //Funcion que ejecuta si todo pasa bien. El response es los datos que manda el otro archivo
				alert("Recordatorios enviados");
            },
			error: function (msg) {
				$('#error_cod').attr('hidden', false);
				//alert("No se pudo validar el usuario. Contactarse con el equipo de mantenimiento");
			}
		});
	}
</script>
</head>
<body>
<div id="formulario">
<h2>Administrador</h2>
<?php include_once "menuAdmin.html"; ?>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="" method="post" enctype="multipart/form-data">
	<?php
		include_once "conexion.php";
		include_once "libreria.php";

			$cantNuevasIdeas = contarRegistro('id','ideaxprofesor','profesor ='.$_SESSION['id_Profesor'].' AND visto = false');
			$cantNuevosInformes = contarRegistro('id','informexprofesor','profesor ='.$_SESSION['id_Profesor'].' AND visto = false');
			echo '<center><h1>Hay <strong>'.$cantNuevasIdeas.'</strong> ideas nuevas</h1></center>';
			echo '<center><h1>Hay <strong>'.$cantNuevosInformes.'</strong> informes finales nuevos</h1></center>';

			echo '<div><input type="button" onclick="recordar();" id="btn_recordar" value="Recordar" title="Enviar recordatorios"></div>';
		include_once "cerrar_conexion.php";
	?>
<div id="tablaCuerpo">
</div>
</center>
</form>
</div>
</body>
</html>