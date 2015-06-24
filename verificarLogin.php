<?php
session_start();
$usuario = $_REQUEST['usuario'];
$password = $_REQUEST['password'];

//echo 'usuario: '.$usuario.'<br>';
//echo 'password: '.$password.'<br>';

echo '<meta charset="UTF-8"/>';

include_once "conexion.php";
include_once "libreria.php";
//los datos del login que llegan ya estan validados entonces se cargan las variable SESSION y se decide el comportamiento de redireccionamiento
//$usuario_bd=pg_query("SELECT p.id,mail,password,logueado,p.nombre,apellido,rol_fk,primera_vez,confirmado FROM pasante WHERE UPPER(mail) LIKE UPPER('{$_REQUEST['usuario']}') AND UPPER(password) LIKE UPPER('{$_REQUEST['password']}') LIMIT 1");

//$usuario_bd=pg_query("SELECT u.id,u.mail,u.password,u.rol_fk,primera_vez,habilitado,p.nombre as nombrep ,pr.nombre as nombrepr, p.apellido as apep, pr.apellido as apepr, p.id as idPasante, pr.id as idProfesor, confirmado FROM usuario u INNER JOIN pasante p ON u.id = p.usuario_fk INNER JOIN profesor pr ON pr.usuario_fk = u.id WHERE UPPER(mail) LIKE UPPER('{$_REQUEST['usuario']}') AND UPPER(password) LIKE UPPER('{$_REQUEST['password']}') LIMIT 1");
$usuario_bd=pg_query("SELECT id,mail,password,rol_fk,primera_vez,habilitado FROM usuario WHERE UPPER(mail) LIKE UPPER('{$usuario}') AND UPPER(password) LIKE UPPER('{$password}') LIMIT 1");
while($rowLogin=pg_fetch_array($usuario_bd,NULL,PGSQL_ASSOC)){
	//echo 'encuentra';
	$_SESSION['usuario'] = $usuario;
	$_SESSION['rol_fk'] = $rowLogin['rol_fk'];
	$habili = $rowLogin['habilitado'];
	$primera_vez = $rowLogin['primera_vez'];
	$idUsuario = $rowLogin['id'];
}
    if ($_SESSION['rol_fk'] == 1) {
    	$otrosDatos = traerSqlCondicion('nombre,apellido,confirmado,id,usuario_fk','pasante','usuario_fk='.$idUsuario);
    	$rowOD = pg_fetch_array($otrosDatos);
    	$_SESSION['nombre'] = $rowOD['nombre'];
    	$_SESSION['apellido'] = $rowOD['apellido'];
    	$_SESSION['id_Pasante'] = $rowOD['id'];
    	$confirmado = $rowOD['confirmado'];
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
    }else{
    	echo '<script language="JavaScript"> alert("Su cuenta está deshabilitada"); window.location ="login.php" </script>';
    }

    if ($_SESSION['rol_fk'] == 2) {
    	echo '<script language="JavaScript"> window.location ="escritorioAdmin.php" </script>';
    }

    if ($_SESSION['rol_fk'] == 3) {
    	echo '<script language="JavaScript"> window.location ="escritorioProfe.php" </script>';
    }

    if ($_SESSION['rol_fk'] == 4) {
    	echo '<script language="JavaScript"> window.location ="escritorioSeguidor.php" </script>';
    }

    //Hacer un menú para las opciones del administrador


//verifico si el usuario y password están en la base de datos
// $hayDatosBD = 0;
// $usuario_encontrado = 0;
// $password_encontrado = 0;

//verifico que exista al menos un pasante
// $existeUsuario=pg_query("SELECT id FROM pasante");
// $rowId=pg_fetch_array($existeUsuario,NULL,PGSQL_ASSOC);

// if ($rowId['id'] == NULL) {
// 	echo '<script language="JavaScript"> alert("no tienes cuenta"); window.location ="login.php"; </script>';
// }else{
//	$usuario_bd=pg_query("SELECT p.id,mail,password,logueado,p.nombre,apellido,rol_fk FROM pasante p INNER JOIN rol r ON p.rol_fk = r.id WHERE UPPER(mail) LIKE UPPER('{$_REQUEST['usuario']}') OR UPPER(password) LIKE UPPER('{$_REQUEST['password']}') LIMIT 1");
//	while($rowLogin=pg_fetch_array($usuario_bd,NULL,PGSQL_ASSOC)){
//	$id_Pasante = $rowLogin['id'];
	// $logueado = $rowLogin['logueado'];
	// 	if ($usuario == $rowLogin['mail']){
	// 		$usuario_encontrado = 1;
	// 		//echo 'usuario_bd: '.$rowLogin['mail'].'<br>';
	// 	}else{
	// 		$usuario_encontrado = 0;
	// 	}
	// 	if ($password == $rowLogin['password']){
	// 		$password_encontrado = 1;
	// 		//echo 'pass_bd: '.$rowLogin['password'].'<br>';
	// 	}else{
	// 		$password_encontrado = 0;
	// 	}

	// 	if ($usuario_encontrado == 1 && $password_encontrado == 1) {

//			$_SESSION['usuario'] = $rowLogin['mail'];
//		    $_SESSION['logueado'] = TRUE;
//		    $_SESSION['nombre'] = $rowLogin['nombre'];
//		    $_SESSION['apellido'] = $rowLogin['apellido'];
//		    $_SESSION['rol_fk'] = $rowLogin['rol_fk'];
//		    $_SESSION['id'] = $rowLogin['id'];
		    //echo $_SESSION['rol_fk'];

//			if ($rowLogin['rol_fk'] == 1 ) { // 1 = rol Alumno
//				echo '<script language="JavaScript"> location ="escritorioPasante.php?enviado=0"	</script>';
				//echo 'logueado alumno';
//			}
	//	}
//		echo '<script language="JavaScript"> alert("Datos incorrectos"); window.location ="login.php"; </script>';
//	}
//}
include_once "cerrar_conexion.php";

?>