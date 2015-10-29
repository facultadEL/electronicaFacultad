<?php
session_start();

include_once "conexion.php";
include_once "libreria.php";

$idea = (empty($_REQUEST['idea'])) ? 0 : $_REQUEST['idea'];
$id_constatador = traerUltimo('constatador');
$mail_constatador = traer_dato('mail','constatador','id = '.$id_constatador);

$cuerpo = "
	<div align='left'>
	    <div align='left'>
	        <strong>Idea en Ejecuci&oacute;n</strong><br/><br/>

	        Tiene una idea nueva en ejecuci&oacute;n.<br/><br />

	        Presione aqu&iacute; para ir a la idea, <a href=".'"http://extension.frvm.utn.edu.ar/electronicaFacultad/escritorioConstatador.php" target="_blank"'.">Ir</a>.<br /><br />
	    </div>
	</div>
";
$asunto = "Nueva idea";
$sendFrom = "dpto-electronica@frvm.utn.edu.ar";
$from_name = "Dpto Electronica";
//$to2 = "etell@frvm.utn.edu.ar";
$to = $mail_constatador;
$to2 = "lucas.peraltam@outlook.com";


$cuerpo_pasante = "
	<div align='left'>
	    <div align='left'>
	        <strong>Idea en Ejecuci&oacute;n</strong><br/><br/>

	        Finalizado el tr&aacute;mite de los convenios. A partir de este momento tiene 1 a&ntilde;o para subir el informe final.<br/><br />
	        De lo contrario deber&aacute; presentar una nueva idea.
	    </div>
	</div>
";

if ($idea != 0) {

	$aEjecucion = "UPDATE idea SET estado=5 WHERE id = $idea;";
	$error = guardarSql($aEjecucion);
					
	if ($error==1){
		echo '<script language="JavaScript"> alert("Los datos no se actualizaron correctamente. Pongase en contacto con el programador");</script>';
	}else{
		enviarMail($cuerpo,$asunto,$sendFrom,$from_name,$to,$to2);
		enviarMail($cuerpo_pasante,$asunto2,$sendFrom,$from_name,$to,$to2);
		echo '<script language="JavaScript"> window.location = "ideas_aprob.php";</script>';
	}
}else{
	echo '<script language="JavaScript"> window.location = "ideas_aprob.php";</script>';
}

include_once "cerrar_conexion.php";
?>