<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
include_once "conexion.php";
include_once "libreria.php";

$id_Pasante = $_REQUEST['idPasante'];
	if ($id_Pasante == 0){
		$nombre = ucwords($_REQUEST['nombre']);
		$apellido = ucwords($_REQUEST['apellido']);
		$nro_legajo = $_REQUEST['nro_legajo'];
		$tipodni = $_REQUEST['tipodni'];
		$nrodni = $_REQUEST['nrodni'];
		$fec_nacimiento = $_REQUEST['fec_nacimiento'];
		$loc_nacimiento = ucwords($_REQUEST['loc_nacimiento']);
		$prov_viviendo = ucwords($_REQUEST['prov_viviendo']);
		$loc_viviendo = ucwords($_REQUEST['loc_viviendo']);
		$codpos = $_REQUEST['codpos'];
		$calle = ucwords($_REQUEST['calle']);
		$nrocalle = $_REQUEST['nrocalle'];
		$piso = $_REQUEST['piso'];
		$dpto = ucwords($_REQUEST['dpto']);
		//$carrera_fk = $_REQUEST['carrera_fk'];
		$caracfijo = $_REQUEST['caracfijo'];
		$nrofijo = $_REQUEST['nrofijo'];
		$caraccel = $_REQUEST['caraccel'];
		$nrocelular = $_REQUEST['nrocelular'];
		$mail = $_REQUEST['mail'];
		$mail2 = $_REQUEST['mail2'];
		$facebook = ucwords($_REQUEST['facebook']);
		$twitter = ucwords($_REQUEST['twitter']);
		$password = $_REQUEST['password'];
		$prov_trabajo = ucwords($_REQUEST['prov_trabajo']);
		$loc_trabajo = ucwords($_REQUEST['loc_trabajo']);
		$codpos2 = $_REQUEST['codpos2'];
		$empresa_trabaja = ucwords($_REQUEST['empresa_trabaja']);
		$perfil_laboral = ucfirst($_REQUEST['perfil_laboral']);

		$traerId = traerId('pasante');
		$cuerpo = "
        <div align='left'>
            <div align='left'>
                <strong>Nuevo Alumno registrado</strong><br/><br/>

                La persona <strong>$nombre $apellido</strong> complet&oacute; el formulario de inscripci&oacute;n.<br/><br />
                
                Presione aqu&iacute; para confirmarlo, <a href=".'"confirmarAlumno.php?idPasante='.$traerId.'" target="_blank"'.">Confirmar</a>.<br /><br />
                <br />
            </div>
        </div>
        ";
        $asunto = "Confirmar Alumno";
        $sendFrom = "lucaspm_2005@hotmail.com";
        $from_name = "Dpto Electronica";
        $to = "eze.olea.f@gmail.com";
		
		// $consultaMax = pg_query("SELECT max(id) FROM pasante");
		// $rowMax = pg_fetch_array($consultaMax);
		// $maximoAlumno = $rowMax['max'];
		// $maximoAlumno = $maximoAlumno + 1;
		// $id_Alumno = $maximoAlumno;

		$newPasante="INSERT INTO pasante(nombre, apellido, nro_legajo, tipodni, nrodni, fec_nacimiento, loc_nacimiento, prov_viviendo, loc_viviendo, codpos, calle, nrocalle, piso, dpto, carrera_fk, caracfijo, nrofijo, caraccel, nrocelular, mail, mail2, facebook, twitter, password, prov_trabajo, loc_trabajo, codpos2, empresa_trabaja, perfil_laboral,rol_fk)VALUES('$nombre','$apellido','$nro_legajo','$tipodni','$nrodni','$fec_nacimiento','$loc_nacimiento','$prov_viviendo','$loc_viviendo','$codpos','$calle','$nrocalle','$piso','$dpto',2,'$caracfijo','$nrofijo','$caraccel','$nrocelular','$mail','$mail2','$facebook','$twitter','$password','$prov_trabajo','$loc_trabajo','$codpos2','$empresa_trabaja','$perfil_laboral',1);";
			$error=0;
			if (!pg_query($conn, $newPasante)){
				$errorpg = pg_last_error($conn);
				$termino = "ROLLBACK";
				$error=1;
			}else{
				$termino = "COMMIT";
			}
		   pg_query($termino);

				
		if ($error==1){
			echo '<script language="JavaScript"> 	alert("Los datos no se guardaron correctamente. Pongase en contacto con el administrador");</script>';
			//echo $errorpg;
		}else{
			enviarMail($cuerpo,$asunto,$sendFrom,$from_name,$to);
			echo '<script language="JavaScript"> alert("Los datos se guardaron correctamente."); window.location = "login.php?registrado=1";</script>';
		}
	}else{
		//aca va el update


		$nombre = ucwords($_REQUEST['nombre']);
		$apellido = ucwords($_REQUEST['apellido']);
		$nro_legajo = $_REQUEST['nro_legajo'];
		$tipodni = $_REQUEST['tipodni'];
		$nrodni = $_REQUEST['nrodni'];
		$fec_nacimiento = $_REQUEST['fec_nacimiento'];
		$loc_nacimiento = ucwords($_REQUEST['loc_nacimiento']);
		$prov_viviendo = ucwords($_REQUEST['prov_viviendo']);
		$loc_viviendo = ucwords($_REQUEST['loc_viviendo']);
		$codpos = $_REQUEST['codpos'];
		$calle = ucwords($_REQUEST['calle']);
		$nrocalle = $_REQUEST['nrocalle'];
		$piso = $_REQUEST['piso'];
		$dpto = ucwords($_REQUEST['dpto']);
		$carrera_fk = $_REQUEST['carrera_fk'];
		$caracfijo = $_REQUEST['caracfijo'];
		$nrofijo = $_REQUEST['nrofijo'];
		$caraccel = $_REQUEST['caraccel'];
		$nrocelular = $_REQUEST['nrocelular'];
		$mail = $_REQUEST['mail'];
		$mail2 = $_REQUEST['mail2'];
		$facebook = ucwords($_REQUEST['facebook']);
		$twitter = ucwords($_REQUEST['twitter']);
		$password = $_REQUEST['password'];
		$prov_trabajo = ucwords($_REQUEST['prov_trabajo']);
		$loc_trabajo = ucwords($_REQUEST['loc_trabajo']);
		$codpos2 = $_REQUEST['codpos2'];
		$empresa_trabaja = ucwords($_REQUEST['empresa_trabaja']);
		$perfil_laboral = ucfirst($_REQUEST['perfil_laboral']);

		//update
		// $sqlMaxId = pg_query("SELECT max(id_seguimiento) FROM seguimiento");
		// $rowMaxId = pg_fetch_array($sqlMaxId);
		// 	$maxId = $rowMaxId['max'] + 1;

		
		// $cont = 0;
		// $sqlCarrera = pg_query("SELECT carrera_fk FROM seguimiento WHERE alumno_fk = '$id_Alumno'");
		// //$rowCarrera = pg_fetch_array($sqlCarrera);
		// while($rowCarrera = pg_fetch_array($sqlCarrera)){
		// 	if($carrera_alumno == $rowCarrera['carrera_fk']){
		// 		$cont++;
		// 	}
		// }
		$modifPasante="UPDATE pasante SET nombre='$nombre', apellido='$apellido', nro_legajo='$nro_legajo', tipodni='$tipodni', nrodni='$nrodni', fec_nacimiento='$fec_nacimiento',loc_nacimiento='$loc_nacimiento', prov_viviendo='$prov_viviendo', loc_viviendo='$loc_viviendo', codpos='$codpos', calle='$calle', nrocalle='$nrocalle', piso='$piso', dpto='$dpto', carrera_fk=2, caracfijo='$caracfijo', nrofijo='$nrofijo', caraccel='$caraccel', nrocelular='$nrocelular', mail='$mail', mail2='$mail2', facebook='$facebook', twitter='$twitter', password='$password', prov_trabajo='$prov_trabajo', loc_trabajo='$loc_trabajo', codpos2='$codpos2', empresa_trabaja='$empresa_trabaja', perfil_laboral='$perfil_laboral' WHERE id = $id_Pasante;";
		// if($cont == 0){
		// 	$nuevoSeguimiento = "INSERT INTO seguimiento(id_seguimiento, alumno_fk, carrera_fk, num_res_cd_fk, num_nota_fk, num_res_cs_fk) VALUES('$maxId','$id_Alumno','$carrera_alumno',1,1,1);";
		// 	$sql = $modAlumno.$nuevoSeguimiento;
		// }else{
		// 	$sql= $modAlumno;
		// }
			$error=0;

			if (!pg_query($conn, $modifPasante)){
				$errorpg = pg_last_error($conn);
				$termino = "ROLLBACK";
				$error=1;
			}else{
				$termino = "COMMIT";
			}
		   pg_query($termino);
				
		if ($error==1){
			echo '<script language="JavaScript"> alert("Los datos no se modificaron correctamente. Pongase en contacto con el administrador");</script>';
		}else{
			echo '<script language="JavaScript"> alert("Los datos se actualizaron correctamente."); window.location = "escritorioPasante.php?idPasante='.$id_Pasante.'";</script>';
		}
}
?>
</body>
</html>