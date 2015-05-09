<?php
	session_start();
	if(!isset($_SESSION['usuario']))
		echo '<script type="text/javascript">window.location="login.php"</script>';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' src="jquery.min-1.9.1.js"></script>
<script src="jquery.mask.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/escritorioPasante.css">
<title><?php echo 'Bienvenido, '.$_SESSION['nombre'];?></title>

</head>
<body>
<div id="formulario">
<h2>Administrador</h2>
<?php include_once "menuAdmin.html";?>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="" method="post" enctype="multipart/form-data">
	<?php
		include_once "conexion.php";
		include_once "libreria.php";

			$cantNuevasIdeas = contarRegistro('id','ideaxprofesor','profesor ='.$_SESSION['id_Profesor'].' AND visto = false');
			echo '<center><h1>Hay <strong>'.$cantNuevasIdeas.'</strong> ideas nuevas</h1></center>';
		include_once "cerrar_conexion.php";
	?>
<div id="tablaCuerpo">
</div>
</center>
</form>
</div>
</body>
</html>