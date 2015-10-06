<?php
session_start();

$usuario = $_REQUEST['usuario'];
$password = md5($_REQUEST['password']);

//echo 'usuario: '.$usuario.'<br>';
//echo 'password: '.$password.'<br>';

echo '<meta charset="UTF-8"/>';

include_once "conexion.php";
include_once "libreria.php";

$condicion = " UPPER(mail) LIKE UPPER('{$usuario}') AND password LIKE '{$password}' LIMIT 1";

$usuario_bd = traerSqlCondicion('id,mail,password,rol_fk,primera_vez,habilitado', 'usuario', $condicion);
while($rowLogin=pg_fetch_array($usuario_bd)){
	//echo 'encuentra';
	$_SESSION['usuario'] = $usuario;
	$_SESSION['rol_fk'] = $rowLogin['rol_fk'];
	$habili = $rowLogin['habilitado'];
	$primera_vez = $rowLogin['primera_vez'];
	$idUsuario = $rowLogin['id'];
}
//echo 'usu: '.$idUsuario;
    if ($_SESSION['rol_fk'] == 1){
    	$otrosDatos = traerSqlCondicion('nombre,apellido,confirmado,id,usuario_fk','pasante','usuario_fk='.$idUsuario);
    	$rowOD = pg_fetch_array($otrosDatos);
    	$_SESSION['nombre'] = $rowOD['nombre'];
    	$_SESSION['apellido'] = $rowOD['apellido'];
    	$_SESSION['id_Pasante'] = $rowOD['id'];
    	$confirmado = $rowOD['confirmado'];
    }elseif($_SESSION['rol_fk'] == 4){
        $otrosDatos = traerSqlCondicion('nombre,apellido,id,usuario_fk','constatador','usuario_fk='.$idUsuario);
        $rowOD = pg_fetch_array($otrosDatos);
        $_SESSION['nombre'] = $rowOD['nombre'];
        $_SESSION['apellido'] = $rowOD['apellido'];
        $_SESSION['id_Constatador'] = $rowOD['id'];
        //echo 'profe';
    }else{
    	$otrosDatos = traerSqlCondicion('nombre,apellido,id,usuario_fk','profesor','usuario_fk='.$idUsuario);
    	$rowOD = pg_fetch_array($otrosDatos);
    	$_SESSION['nombre'] = $rowOD['nombre'];
    	$_SESSION['apellido'] = $rowOD['apellido'];
    	$_SESSION['id_Profesor'] = $rowOD['id'];
    	//echo 'profe';
    }
    
    
    if ($habili == 't') {
    	if ($primera_vez == 't'){
	    	if ($_SESSION['rol_fk'] == 1) {
	    		echo '<script language="JavaScript"> window.location ="cambiarPassGenerado.php" </script>';
	    	}
	    }else{
	    	if ($_SESSION['rol_fk'] == 1) {
		    	if ($confirmado == 't') {
		    		//echo '<script language="JavaScript"> window.location ="escritorioPasante.php?enviado=0"	</script>';
		    		echo '<script language="JavaScript"> window.location ="escritorioPasante.php"	</script>';
		    	}else{
			    	echo '<script language="JavaScript"> alert("Su solicitud está en espera de aprobación"); window.location ="login.php" </script>';
			    }
			}
	    }
    }

    if ($_SESSION['rol_fk'] == 2) {
    	echo '<script language="JavaScript"> window.location ="escritorioAdmin.php" </script>';
    }

    if ($_SESSION['rol_fk'] == 3) {
    	echo '<script language="JavaScript"> window.location ="escritorioProfe.php" </script>';
    }

    if ($_SESSION['rol_fk'] == 4) {
    	echo '<script language="JavaScript"> window.location ="escritorioConstatador.php" </script>';
    }

    //Hacer un menú para las opciones del administrador

include_once "cerrar_conexion.php";

?>