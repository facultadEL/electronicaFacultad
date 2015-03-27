<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<?php
//Aca van todos los links a los formularios o paginas que vayamos haciendo
//Aca se comenta para git
//Prueba con Slack y Notificaciones
include_once "libreria.php";
//Ejemplo obtener codigos para mandar por correo
$var2 = getCode(6);
echo "Codigo para mail: ".$var2;
?>
<body>
<br>
	<a href="login.php">Login electrónica</a>
</body>
</html>
