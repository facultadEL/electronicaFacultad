<?php
	session_start();
	include_once "chekearLogin.php"

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' src="jquery.min-1.9.1.js"></script>
<script src="jquery.mask.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/escritorioSeguidor.css">
<title><?php echo 'Bienvenido, '.$_SESSION['nombre'];?></title>

</head>
<body>
<div id="formulario">
<h2><?php echo 'Hola, '.$_SESSION['nombre'];?></h2>
<?php include_once "menuSeguidor.html";?>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="" method="post" enctype="multipart/form-data">
	<?php
		//include_once "conexion.php";
		//include_once "libreria.php";

			//$cantNuevasIdeas = contarRegistro('idea','ideaxprofesor INNER JOIN idea ON ideaxprofesor.idea = idea.id','profesor ='.$_SESSION['id_Profesor'].' AND visto = false AND estado = 3');
			//echo '<center><h1>Hay <strong>'.$cantNuevasIdeas.'</strong> ideas nuevas</h1></center>';
		//include_once "cerrar_conexion.php";
	?>
<div id="tablaCuerpo">
</div>
</center>
</form>
</div>
</body>
</html>