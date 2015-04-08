<?php
include_once "conexion.php";
include_once "libreria.php";

$recuperarPass = $_REQUEST['recuperarPass'];

//$sql = traerSqlCondicion('mail','pasante', 'UPPER(mail) LIKE UPPER("'.$recuperarPass.'")'); //no me funciona la libreria para este caso. Tal vez tengo mal la sintaxis
//echo $sql;

$buscarPass = pg_query("SELECT mail,password FROM pasante WHERE UPPER(mail) LIKE UPPER('{$recuperarPass}')");
$rowbuscarPass = pg_fetch_array($buscarPass,NULL,PGSQL_ASSOC);
	$passRecuperado = $rowbuscarPass['password'];
	$cuerpo = "
    <div align='left'>
        <div align='left'>
            <strong>Datos del login</strong><br/><br/>

            Usted solicit&oacute; que le recuerden su contrase&ntilde;a:<br/><br />
            
            <u><strong>Usuario:<strong></u> '.$recuperarPass.'<br/>
            <u><strong>Contrase&ntilde;a:<strong></u> '.$passRecuperado.'<br/>
            <br />
        </div>
    </div>
    ";
    $asunto = "Recordatorio de contraseña";
    $sendFrom = "dpto-electronica@frvm.utn.edu.ar"; //seguramente va otro mail, hay que crear un gmail
    $from_name = "Dpto Electronica";
    $to = $recuperarPass;

    enviarMail($cuerpo,$asunto,$sendFrom,$from_name,$to);
    echo '<script language="JavaScript"> alert("Verifique su casilla de correo, le enviamos un mail con los datos solicitados"); window.location ="login.php"; </script>';
?>