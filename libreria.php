<?php
//Actualizada a la fecha 30/09/2014 
error_reporting(E_ALL);
//Guarda la consulta de base de datos, siempre y cuando se le envie el sql y la conexion a la base;
    //Devuelve el error para hacer el javascript para mostrar los mensajes segun el guardado
function guardarSql($sqlGuardar){
    $error = 0;
    if(!pg_query($sqlGuardar)){
        $termino = "ROLLBACK";
        $error = 1;
    }else{
        $termino = "COMMIT";
    }
    
    pg_query($termino);
    
    return $error;
}

function setDate($f){
    $vF = explode('-', $f);
    return $vF[2].'/'.$vF[1].'/'.$vF[0];
}

function contarRegistro($columna,$tabla,$condicion){
    if($condicion==NULL){
        $sqlContar = pg_query("SELECT count($columna)".' AS "contar"'." FROM ".$tabla);
    }else{
        $sqlContar = pg_query("SELECT count($columna)".' AS "contar"'." FROM $tabla WHERE ".$condicion);
    }
    $rowContar = pg_fetch_array($sqlContar);
    return $rowContar['contar'];
}

function traerSql($rango,$tabla){
    $sql = pg_query('SELECT '.$rango.' FROM '.$tabla);
    return $sql;
}

function traerSqlCondicion($rango,$tabla,$condicion){
    $sql = pg_query('SELECT '.$rango.' FROM '.$tabla.' WHERE '.$condicion);
    return $sql;
}

function traerId($tabla){
	$sqlId = pg_query('SELECT max(id_'.$tabla.') FROM '.$tabla);
	$rowId = pg_fetch_array($sqlId);
	$maxId = $rowId['max'] + 1;
	return $maxId;
}

//Muestra el mensaje javascript y redirecciona a los lugares que le mandemos
function mostrarMensaje($msg,$redireccion){
    echo '<script type="text/javascript">alert("'.$msg.'")
        location.href="'.$redireccion.'"
        </script>';
}

//Muestra la diferencia de dias entre dos fechas
function diasRestantes($f){
        //if ((ano % 4 == 0) && ((ano % 100 != 0) || (ano % 400 == 0))
        $diaActual = date('d');
        $mesActual = date('m');
        $anioActual = date('Y');
        $fechaActual = $anioActual.'-'.$mesActual.'-'.$diaActual;
        //$vFecha = explode('-', $f);
        //if(())
        $datetime1 = date_create($fechaActual);
        $datetime2 = date_create($f);
        $interval = date_diff($datetime1, $datetime2);
        return $interval->format('%R%a días');
}

function cambiarDni($dni){
  $largoDni = strlen($dni);
  switch ($largoDni) {
    case '7':
      $dniFormateado = $dni[0].'.'.$dni[1].$dni[2].$dni[3].'.'.$dni[4].$dni[5].$dni[6];
      break;
    case 8:
      $dniFormateado = $dni[0].$dni[1].'.'.$dni[2].$dni[3].$dni[4].'.'.$dni[5].$dni[6].$dni[7];
      break;
  }
  return $dniFormateado;
}
/*
require ("PHPMailer_5.2.1/class.phpmailer.php");

function enviarMail($c,$a){
        
    $cuerpo = $c;
    $asunto = $a;
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl"; 
    $mail->Host = "smtp.gmail.com"; // dirección del servidor
    $mail->Username = "eze.olea.f@gmail.com"; // Usuario

    $mail->Password = "8fF6zcPg86"; // Contraseña

    $mail->Port = 465; // Puerto a utilizar
    $mail->From = "vencimientos@transportedoncarlosvm.com"; // dirección remitente
    $mail->FromName = "Vencimientos Transporte Don Carlos"; // nombre remitente

    $mail->AddAddress("eze.olea.f@gmail.com",''); // Esta es la dirección a donde enviamos

    //$mail->AddCC("cuenta@dominio.com"); // Copia
    //$mail->AddBCC("cuenta@dominio.com"); // Copia oculta
    $mail->IsHTML(true); // El correo se envía como HTML
    $mail->Subject = $asunto; // Asunto
    $mail->Body = $cuerpo; // Mensaje a enviar
    //$mail->AltBody = "Hola mundo. Esta es la primer línean Acá continuo el mensaje"; // cuerpo alternativo del mensaje
    //$mail->AddAttachment("imagenes/imagen.jpg", "imagen.jpg");
    $exito = $mail->Send(); // Envía el correo.
    


//
//if($exito){
//	echo '<script language="JavaScript"> 
//		alert("Verifique su casilla de correo, le hemos enviado un mail.");
//		location ="enviarMail.php";
//		</script>';	
//}else{
//	echo '<script language="JavaScript"> 
//		alert("No se puedo enviar el correo, comuniquese con el administrador");
//		location ="enviarMail.php";
//		</script>';
//}

    }
    */