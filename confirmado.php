<?php
session_start();

include_once "conexion.php";
include_once "libreria.php";

$id_Pasante = $_REQUEST['idPasante'];

$sql = traerSqlCondicion('pasante.id,confirmado,usuario.mail as mailuser,password, enviado','pasante INNER JOIN usuario ON pasante.usuario_fk = usuario.id','pasante.id='.$id_Pasante);
$rowPasante=pg_fetch_array($sql,NULL,PGSQL_ASSOC);
    $confirmado = $rowPasante['confirmado'];
    $mail = $rowPasante['mailuser'];
    $password = $rowPasante['password'];
    $enviado = $rowPasante['enviado'];
    // echo 'pass: '.$password;
    // echo 'usuario:'.$mail;
    // echo 'confirmado: '.$confirmado;

    $traerId = traerId('pasante');
	$cuerpo = "
    <div align='left'>
        <div align='left'>
            <strong>Confirmaci&oacute;n de inscripci&oacute;n</strong><br/><br/>

            Su inscripci&oacute;n ha sido confirmada, sus datos de usuario son los siguientes:<br>
            <br>
            Usuario: <strong>$mail</strong><br><br>
            Contrase&ntilde;a: <strong>$password</strong><br><br>

            Para iniciar sesi&oacute;n use estos datos.<br/><br />
            
            Presione aqu&iacute; para ir a la plataforma, <a href=".'"http://extension.frvm.utn.edu.ar/electronicaFacultad/login.php" target="_blank"'.">Ir a la plataforma</a>.<br /><br />
            <br />
        </div>
    </div>
    ";
    $asunto = "Dpto Electronica";
    $sendFrom = "dpto-electronica@frvm.utn.edu.ar";
    $from_name = "Dpto Electronica";
    $to = $mail;
    
    if ($confirmado == 'f'){
    	if ($enviado == 'f') {
    		$confirmPasante = "UPDATE pasante SET confirmado=TRUE, enviado=TRUE WHERE id = $id_Pasante;";
    	}elseif ($enviado == 't') {
    		$confirmPasante = "UPDATE pasante SET confirmado=TRUE WHERE id = $id_Pasante;";
    	}
    	
			$error=0;
			if (!pg_query($conn, $confirmPasante)){
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
			if ($enviado == 'f'){
				enviarMail($cuerpo,$asunto,$sendFrom,$from_name,$to,NULL);
			}
			echo '<script language="JavaScript"> window.location = "confirmarPasante.php";</script>';
		}
    }else{
    	$cancelarConfirmPasante = "UPDATE pasante SET confirmado=FALSE WHERE id = $id_Pasante;";
			$error=0;
			if (!pg_query($conn, $cancelarConfirmPasante)){
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
			echo '<script language="JavaScript"> window.location = "confirmarPasante.php";</script>';
		}
    }

include_once "cerrar_conexion.php";
?>