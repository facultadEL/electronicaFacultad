<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<?php
//Aca van todos los links a los formularios o paginas que vayamos haciendo
//Aca se comenta para git
//Prueba con Slack y Notificaciones
include_once "conexion.php";
include_once "libreria.php";

$sql = traerSqlCondicion('idea, visto, fecha_registro, profesor, mail', 'ideaxprofesor INNER JOIN idea ON idea.id = ideaxprofesor.idea INNER JOIN profesor ON profesor.id = ideaxprofesor.profesor', 'visto = FALSE');
while($rowVisto = pg_fetch_array($sql)){
	if (diasRestantes($rowConfirmado['fecha_registro']) > 10){
		$idProfesor = $rowConfirmado['profesor'];
		$mail = $rowConfirmado['mail'];

	$cuerpo = "
	    <div align='left'>
	        <div align='left'>
	            <strong>Tiene ideas sin revisar</strong><br/><br/>

	            A&uacute;n tiene ideas pendientes de evaluar:<br>
	            <br>
	            Para acceder a calificarlas. Haga click en el siguiente enlace<br/><br />
	            
	            <a href=".'"http://extension.frvm.utn.edu.ar/electronicaFacultad/calificarIdea.php" target="_blank"'.">Calificar ideas</a>.<br /><br />
	            <br />
	        </div>
	    </div>
	    ";
    $asunto = "Dpto Electronica";
    $sendFrom = "dpto-electronica@frvm.utn.edu.ar";
    $from_name = "Dpto Electronica";
    $to = $mail;

	    enviarMail($cuerpo,$asunto,$sendFrom,$from_name,$to);
    }
}
include_once "cerrar_conexion.php";

include_once "chekearLogin.php";

?>
<body>

</body>
</html>
