<?php
include_once "conexion.php";
include_once "libreria.php";


//PROFESORES QUE TIENEN IDEAS PENDIENTES DE VER
$cant = 1;
$sqlProfesores = traerSqlCondicion('profesor,profesor.mail as mail', 'ideaxprofesor INNER JOIN profesor ON profesor.id = ideaxprofesor.profesor INNER JOIN usuario ON usuario.id = profesor.usuario_fk', 'visto = FALSE AND rol_fk = 3 GROUP BY profesor,profesor.mail ORDER BY profesor');
while($rowProfe = pg_fetch_array($sqlProfesores)){
	$id_prof = $rowProfe['profesor'];
	$mail_profesor[$id_prof] = $rowProfe['mail'];
	$idP[$cant] = $rowProfe['profesor'];
	//echo '<script> alert('.$profesor[$id_prof].'); </script>';
	// echo $mail_profesor[$id_prof].'<br>';
	// echo $idP[$cant].'<br>';
	$cant++;
}
//echo 'cant: '.$cant.'<br>';
//VERIFICAR SI ALGUNA DE ESAS IDEAS SUPERA LAS FECHAS PACTADAS PARA ENVIAR EL AVISO A LOS PROFESORES.
$entra = 0;
$mail_aviso = '';
$tot_mail = 0;
for ($i=1; $i < $cant; $i++) {
	$condicion = 'profesor = '.$idP[$i].' AND visto = false';
	$sqlFechas = traerSqlCondicion('fecha_registro', 'idea INNER JOIN ideaxprofesor ON ideaxprofesor.idea = idea.id INNER JOIN profesor ON profesor.id = ideaxprofesor.profesor', $condicion);
	while($rowFecha = pg_fetch_array($sqlFechas)){
		if (diasRestantes($rowFecha['fecha_registro']) == 7 || diasRestantes($rowFecha['fecha_registro']) == 12 || diasRestantes($rowFecha['fecha_registro']) > 14){
			$entra = 1;
		}
	}
	if ($entra == 1) {
		$mail_aviso .= $mail_profesor[$idP[$i]].';';
		$entra = 0;
		$tot_mail++;
	}
}

// echo $mail_aviso.'<br>';
// echo 't: '.$tot_mail.'<br>';

$cuerpo = "
    <div align='left'>
        <div align='left'>
            <strong>Tiene ideas sin revisar</strong><br/><br/>

            A&uacute;n tiene ideas pendientes de evaluar:<br>
            <br>
            Para acceder a calificarlas. Haga click en el siguiente enlace<br/><br />
            
            <a href=".'"http://extension.frvm.utn.edu.ar/electronicaFacultad/login.php" target="_blank"'.">Calificar ideas</a>.<br /><br />
            <br />
        </div>
    </div>
    ";
$asunto = "Dpto Electronica";
$sendFrom = "dpto-electronica@frvm.utn.edu.ar";
$from_name = "Dpto Electronica";
$to = $mail_aviso;
enviarMail($cuerpo,$asunto,$sendFrom,$from_name,$to,NULL,$tot_mail);

//-----------------------------------------------------------------------------------------------------------------------------------------------

//PROFESORES QUE TIENEN IDEAS PENDIENTES DE VER
$cant = 1;
$sqlProfesores = traerSqlCondicion('profesor,profesor.mail as mail', 'informexprofesor INNER JOIN profesor ON profesor.id = informexprofesor.profesor INNER JOIN usuario ON usuario.id = profesor.usuario_fk', 'visto = FALSE AND rol_fk = 3 GROUP BY profesor,profesor.mail ORDER BY profesor');
while($rowProfe = pg_fetch_array($sqlProfesores)){
	$id_prof = $rowProfe['profesor'];
	$mail_profesor[$id_prof] = $rowProfe['mail'];
	$idP[$cant] = $rowProfe['profesor'];
	$cant++;
}

//VERIFICAR SI ALGUNA DE ESAS IDEAS SUPERA LAS FECHAS PACTADAS PARA ENVIAR EL AVISO A LOS PROFESORES.
$entra = 0;
$mail_aviso = '';
$tot_mail = 0;
for ($i=1; $i < $cant; $i++) {
	$condicion = 'profesor = '.$idP[$i].' AND visto = false';
	$sqlFechas = traerSqlCondicion('fecha_registro', 'informe_final INNER JOIN informexprofesor ON informexprofesor.informe = informe_final.id INNER JOIN profesor ON profesor.id = informexprofesor.profesor', $condicion);
	while($rowFecha = pg_fetch_array($sqlFechas)){
		if (diasRestantes($rowFecha['fecha_registro']) == 7 || diasRestantes($rowFecha['fecha_registro']) == 12 || diasRestantes($rowFecha['fecha_registro']) > 14){
			$entra = 1;
		}
	}
	if ($entra == 1) {
		$mail_aviso .= $mail_profesor[$idP[$i]].';';
		$entra = 0;
		$tot_mail++;
	}
}

$cuerpo2 = "
    <div align='left'>
        <div align='left'>
            <strong>Tiene informes finales sin revisar</strong><br/><br/>

            A&uacute;n tiene informes finales pendientes de evaluar:<br>
            <br>
            Para acceder a calificarlos. Haga click en el siguiente enlace<br/><br />
            
            <a href=".'"http://extension.frvm.utn.edu.ar/electronicaFacultad/login.php" target="_blank"'.">Calificar informes</a>.<br /><br />
            <br />
        </div>
    </div>
    ";
$asunto = "Dpto Electronica";
$sendFrom = "dpto-electronica@frvm.utn.edu.ar";
$from_name = "Dpto Electronica";
$to = $mail_aviso;
enviarMail($cuerpo2,$asunto,$sendFrom,$from_name,$to,NULL,$tot_mail);

//-----------------------------------------------------------------------------------------------------------------------------------------------

//ALUMNOS QUE TIENEN 1 AÑO SIN PRESENTAR EL INFORME FINAL
$tot_mail = 0;
$mail_aviso = '';
$sqlPasante = traerSqlCondicion('fecha_aprobada, pasante_fk, mail', 'idea INNER JOIN pasante ON pasante.id = idea.pasante_fk','fecha_aprobada IS NOT NULL');
while($rowPasante = pg_fetch_array($sqlPasante)){
	$pasante_fk = $rowPasante['pasante_fk'];
	$mail_pasante = $rowPasante['mail'];
	$fecha_aprobada = $rowPasante['fecha_aprobada'];
	$tot_mail++;
	if (diasRestantes($fecha_aprobada) == 365){
		$mail_aviso .= $mail_pasante.';';
	}
}
$cuerpo3 = "
    <div align='left'>
        <div align='left'>
            <strong>Idea Vencida</strong><br/><br/>

            Se ha cumplido 1 a&ntilde;o desde que su idea ha sido aprobada, deber&aacute; presentar una nueva idea.<br>
            <br>
        </div>
    </div>
    ";
$asunto = "Dpto Electronica";
$sendFrom = "dpto-electronica@frvm.utn.edu.ar";
$from_name = "Dpto Electronica";
$to = $mail_aviso;
if ($tot_mail > 0) {
	enviarMail($cuerpo3,$asunto,$sendFrom,$from_name,$to,NULL,$tot_mail);
}

include_once "cerrar_conexion.php";

?>