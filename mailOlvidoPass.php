<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
include_once "conexion.php";
include_once "libreria.php";

$recuperarPass = (empty($_REQUEST['recuperarPass'])) ? '/--/' : $_REQUEST['recuperarPass'];
//echo 'mail: '.$recuperarPass;
//$sqlGuardar .= "INSERT INTO telefonos_del_alumno(id_telefonos_del_alumno,caracteristica_alumno,telefono_alumno,duenio_del_telefono,alumno_fk) VALUES($ultimo_id,'$vTel[1]','$vTel[2]','$vTel[0]','$id_Alumno');";
if ($recuperarPass != '/--/') {
	//echo 'mail2: '.$recuperarPass;
    $sqlDatos = traerSqlCondicion('id,nro_legajo,nrodni','pasante',"mail = '$recuperarPass'");
    $rowDatos = pg_fetch_array($sqlDatos);
        $id_pasante = $rowDatos['id'];
        $nro_legajo = $rowDatos['nro_legajo'];
        $nrodni = $rowDatos['nrodni'];
}

//$idPasante = $id_pasante;

date_default_timezone_set("America/Argentina/Buenos_Aires");
if (!empty($id_pasante)) {
    $codper = md5($id_pasante.$nro_legajo.$nrodni);

    $fecha_sol = date('Y-m-d H:i');

    $fecha_vto = date('Y-m-d ');
    if (date(H) >= 23) {
    	$fecha_vto .= 01;//date('H');// + 2;
    }else{
    	$fecha_vto .= date('H');// + 2;
    }
    $fecha_vto .= ':'.date('i');

    $sqlGuardar = "INSERT INTO recupera_pass (codigo_personal,fecha_sol,fecha_vto,pasante_fk) VALUES ('$codper','$fecha_sol','$fecha_vto',$id_pasante);";
    //$sqlGuardar = "INSERT INTO recupera_pass (codigo_personal,fecha_sol,fecha_vto) VALUES ('$codper','$fecha_sol','$fecha_vto');";
    //echo $sqlGuardar;
	$error = guardarSql($sqlGuardar);
}
if ($error == 1){
    echo '<script language="JavaScript"> window.location="login.php";   alert("Hubo un problema con la solicitud. Por favor, intente otra vez."); </script>';
}else{


// $sqlDatos2 = traerSqlCondicion('codigo_personal','recupera_pass','pasante_fk = '.$id_pasante);
// $rowDatos2 = pg_fetch_array($sqlDatos2);
//     $id_pasante = $rowDatos2['codigo_personal'];

//$buscarPass = pg_query("SELECT mail,password FROM usuario WHERE UPPER(mail) = UPPER('{$recuperarPass}')");
//$rowbuscarPass = pg_fetch_array($buscarPass,NULL,PGSQL_ASSOC);
// 	$passRecuperado = $rowbuscarPass['password'];
 $cuerpo = "
    <div align='left'>
        <div align='left'>
            <strong>Datos del login</strong><br/><br/>

            Usted solicit&oacute; recuperar su contrase&ntilde;a:<br/><br />
            
            Para poder proseguir con la solicitud, haga click aqu&iacute;.
            <a href=".'"http://extension.frvm.utn.edu.ar/electronicaFacultad/cambiarPassGenerado.php?pass='.$codper.'" target="_blank"'.">Restaurar</a>.<br /><br />

            Esta solicitud tiene una vigencia de 2 horas por cuesti&oacute;n de seguridad.
        </div>
    </div>
    ";
$asunto = "Restaurar password";
$sendFrom = "dpto-electronica@frvm.utn.edu.ar"; //seguramente va otro mail, hay que crear un gmail
$from_name = "Dpto Electronica";
$to = $recuperarPass;

enviarMail($cuerpo,$asunto,$sendFrom,$from_name,$to,NULL,1);

include_once "cerrar_conexion.php";
echo '<script language="JavaScript"> alert("Verifique su casilla de correo, le enviamos un mail con los datos solicitados"); window.location ="login.php"; </script>';

}
//<a href=".'"localhost/lpm19/electronicaFacultad/cambiarPassGenerado.php?pass='.$codper.'" target="_blank"'.">Restaurar</a>.<br /><br />
?>