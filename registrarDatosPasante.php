<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/loaders.css"/>
</head>
<body>
<!-- <div style="width: 140px; height: 120px;" class="loader">
	<div class="loader-inner ball-rotate">
		<div style="background: #444;">  		
		</div>
	</div>
</div> -->
<?php
include_once "conexion.php";
include_once "libreria.php";

$id_Pasante = $_REQUEST['idPasante'];
	if ($id_Pasante == 0){
		$nombre = ucwords(trim($_REQUEST['nombre']));
		$apellido = ucwords(trim($_REQUEST['apellido']));
		$nro_legajo = trim($_REQUEST['nro_legajo']);
		$tipodni = trim($_REQUEST['tipodni']);
		$nrodni = trim($_REQUEST['nrodni']);
		$fec_nacimiento = trim($_REQUEST['fec_nacimiento']);
		$loc_nacimiento = ucwords(trim($_REQUEST['loc_nacimiento']));
		$prov_viviendo = ucwords(trim($_REQUEST['prov_viviendo']));
		$loc_viviendo = ucwords(trim($_REQUEST['loc_viviendo']));
		$codpos = trim($_REQUEST['codpos']);
		$calle = ucwords(trim($_REQUEST['calle']));
		$nrocalle = trim($_REQUEST['nrocalle']);
		$piso = trim($_REQUEST['piso']);
		$dpto = ucwords(trim($_REQUEST['dpto']));
		//$carrera_fk = trim($_REQUEST['carrera_fk']);
		$caracfijo = trim($_REQUEST['caracfijo']);
		$nrofijo = trim($_REQUEST['nrofijo']);
		$caraccel = trim($_REQUEST['caraccel']);
		$nrocelular = trim($_REQUEST['nrocelular']);
		$mail = trim($_REQUEST['mail']);
		$mail2 = trim($_REQUEST['mail2']);
		$facebook = ucwords(trim($_REQUEST['facebook']));
		$twitter = ucwords(trim($_REQUEST['twitter']));
		$password = md5($nrodni);
		$prov_trabajo = ucwords(trim($_REQUEST['prov_trabajo']));
		$loc_trabajo = ucwords(trim($_REQUEST['loc_trabajo']));
		$codpos2 = trim($_REQUEST['codpos2']);
		$empresa_trabaja = ucwords(trim($_REQUEST['empresa_trabaja']));
		$perfil_laboral = ucfirst(trim($_REQUEST['perfil_laboral']));
		$fecreg = date(Ymd);
		//echo 'password: '.$password;

		$error = 0;
		$sql = "INSERT INTO usuario(mail,password,rol_fk)VALUES('$mail','$password',1);";
		//echo $sql;
		$error = guardarSql($sql);
		if ($error == 1) {
			echo '<script language="JavaScript"> 	alert("Los datos no se guardaron correctamente. Pongase en contacto con el administrador");</script>';
		}else{
			$usuario_fk = traerUltimo('usuario');	
			//echo 'usuario: '.$usuario_fk;
		}


		$traerId = traerId('pasante');
		$cuerpo = "
        <div align='left'>
            <div align='left'>
                <strong>Nuevo Alumno registrado</strong><br/><br/>

                La persona <strong>$nombre $apellido</strong> complet&oacute; el formulario de inscripci&oacute;n.<br/><br />
                
                Presione aqu&iacute; para confirmarlo, <a href=".'"http://extension.frvm.utn.edu.ar/electronicaFacultad/confirmarPasante.php?idPasante='.$traerId.'" target="_blank"'.">Confirmar</a>.<br /><br />
                <br />
            </div>
        </div>
        ";
        $asunto = "Confirmar Pasante";
        $sendFrom = "dpto-electronica@frvm.utn.edu.ar";
        $from_name = "Dpto Electronica";
        $to = ADMIN;

		$cuerpo2 = "
        <div align='left'>
            <div align='left'>
                <strong>Usted se ha inscripto correctamente</strong><br/><br/>

                Por favor espere la confirmaci&oacute;n de su registro, se le enviar&aacute; un mail con sus datos de usuario.<br /><br />
                
                Muchas Gracias.<br /><br />
                <br />
            </div>
        </div>
        ";
        $asunto2 = "Dpto Electronica";
        $sendFrom2 = "dpto-electronica@frvm.utn.edu.ar";
        $from_name2 = "Dpto Electronica";
        $to2 = $mail;
		
		// $consultaMax = pg_query("SELECT max(id) FROM pasante");
		// $rowMax = pg_fetch_array($consultaMax);
		// $maximoAlumno = $rowMax['max'];
		// $maximoAlumno = $maximoAlumno + 1;
		// $id_Alumno = $maximoAlumno;

		$newPasante="INSERT INTO pasante(nombre, apellido, nro_legajo, tipodni, nrodni, fec_nacimiento, loc_nacimiento, prov_viviendo, loc_viviendo, codpos, calle, nrocalle, piso, dpto, carrera_fk, caracfijo, nrofijo, caraccel, nrocelular, mail, mail2, facebook, twitter, prov_trabajo, loc_trabajo, codpos2, empresa_trabaja, perfil_laboral,fecreg,usuario_fk)VALUES('$nombre','$apellido','$nro_legajo','$tipodni','$nrodni','$fec_nacimiento','$loc_nacimiento','$prov_viviendo','$loc_viviendo','$codpos','$calle','$nrocalle','$piso','$dpto',2,'$caracfijo','$nrofijo','$caraccel','$nrocelular','$mail','$mail2','$facebook','$twitter','$prov_trabajo','$loc_trabajo','$codpos2','$empresa_trabaja','$perfil_laboral','$fecreg','$usuario_fk');";
		//echo 'newPasante: '.$newPasante;
			$error=0;
			if (!pg_query($conn, $newPasante)){
				$errorpg = pg_last_error($conn);
				$termino = "ROLLBACK";
				$error=1;
			}else{
				$termino = "COMMIT";
			}
		   pg_query($termino);

		include "cerrar_conexion.php";
		if ($error==1){
			echo '<script language="JavaScript"> 	alert("Los datos no se guardaron correctamente. Pongase en contacto con el administrador");</script>';
			//echo $errorpg;
		}else{
			enviarMail($cuerpo,$asunto,$sendFrom,$from_name,$to,NULL,1);
			enviarMail($cuerpo2,$asunto2,$sendFrom2,$from_name2,$to2,NULL,1);
			echo '<script language="JavaScript"> alert("Verifique su casilla de mail, le enviamos un correo."); window.location = "login.php?registrado=1";</script>';
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
		//$password = $_REQUEST['password'];
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
		$modifPasante="UPDATE pasante SET nombre='$nombre', apellido='$apellido', nro_legajo='$nro_legajo', tipodni='$tipodni', nrodni='$nrodni', fec_nacimiento='$fec_nacimiento',loc_nacimiento='$loc_nacimiento', prov_viviendo='$prov_viviendo', loc_viviendo='$loc_viviendo', codpos='$codpos', calle='$calle', nrocalle='$nrocalle', piso='$piso', dpto='$dpto', carrera_fk=2, caracfijo='$caracfijo', nrofijo='$nrofijo', caraccel='$caraccel', nrocelular='$nrocelular', mail='$mail', mail2='$mail2', facebook='$facebook', twitter='$twitter', prov_trabajo='$prov_trabajo', loc_trabajo='$loc_trabajo', codpos2='$codpos2', empresa_trabaja='$empresa_trabaja', perfil_laboral='$perfil_laboral' WHERE id = $id_Pasante;";
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
		
		include "cerrar_conexion.php";				
		if ($error==1){
			echo '<script language="JavaScript"> alert("Los datos no se modificaron correctamente. Pongase en contacto con el administrador");</script>';
		}else{
			echo '<script language="JavaScript"> alert("Los datos se actualizaron correctamente."); window.location = "escritorioPasante.php?idPasante='.$id_Pasante.'";</script>';
		}
}
?>
</body>
</html>