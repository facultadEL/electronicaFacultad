<?php
	session_start();
	include_once "chekearLogin.php";

?>
<!DOCTYPE html5>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' src="jquery.min-1.9.1.js"></script>
<link rel="stylesheet" href="css/escritorioProfe.css">
<title><?php echo 'Bienvenido, '.$_SESSION['nombre'];?></title>

</head>
<body>
<div id="formulario">
<h2><?php echo 'Hola, '.$_SESSION['nombre'];?></h2>
<?php include_once "menuProfe.html";?>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="" method="post" enctype="multipart/form-data">
	<?php
		include_once "conexion.php";
		include_once "libreria.php";

			$cantNuevasIdeas = contarRegistro('id','ideaxprofesor','profesor ='.$_SESSION['id_Profesor'].' AND visto = false');
			$cantNuevosInformes = contarRegistro('id','informexprofesor','profesor ='.$_SESSION['id_Profesor'].' AND visto = false');
			echo '<center><h1>Hay <strong>'.$cantNuevasIdeas.'</strong> Ideas nuevas</h1></center>';
			echo '<center><h1>Hay <strong>'.$cantNuevosInformes.'</strong> Informes finales nuevos</h1></center>';
		include_once "cerrar_conexion.php";
	?>
<div id="tablaCuerpo">
</div>
</center>
</form>
</div>
</body>
</html>