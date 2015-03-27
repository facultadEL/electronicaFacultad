<?php
session_start();
$usuario = $_REQUEST['usuario'];
$password = $_REQUEST['password'];
//echo 'usuario: '.$usuario.'<br>';
//echo 'password: '.$password.'<br>';



include_once "conexion.php";

//verifico si el usuario y password están en la base de datos
$hayDatosBD = 0;
$usuario_encontrado = 0;
$password_encontrado = 0;

//verifico que exista al menos un pasante
$existeUsuario=pg_query("SELECT id FROM pasante");
$rowId=pg_fetch_array($existeUsuario,NULL,PGSQL_ASSOC);

if ($rowId['id'] == NULL) {
	echo '<script language="JavaScript"> alert("no tienes cuenta"); window.location ="login.php"; </script>';
}else{
	$usuario_bd=pg_query("SELECT p.id,mail,password,logueado,p.nombre,apellido,rol_fk FROM pasante p INNER JOIN rol r ON p.rol_fk = r.id WHERE UPPER(mail) LIKE UPPER('{$_REQUEST['usuario']}') OR UPPER(password) LIKE UPPER('{$_REQUEST['password']}') LIMIT 1");
	while($rowLogin=pg_fetch_array($usuario_bd,NULL,PGSQL_ASSOC)){
	$id_Pasante = $rowLogin['id'];
	$logueado = $rowLogin['logueado'];
		if ($usuario == $rowLogin['mail']){
			$usuario_encontrado = 1;
			//echo 'usuario_bd: '.$rowLogin['mail'].'<br>';
		}else{
			$usuario_encontrado = 0;
		}
		if ($password == $rowLogin['password']){
			$password_encontrado = 1;
			//echo 'pass_bd: '.$rowLogin['password'].'<br>';
		}else{
			$password_encontrado = 0;
		}

		if ($usuario_encontrado == 1 && $password_encontrado == 1) {

			$_SESSION['usuario'] = $rowLogin['mail'];
		    $_SESSION['logueado'] = TRUE;
		    $_SESSION['nombre'] = $rowLogin['nombre'];
		    $_SESSION['apellido'] = $rowLogin['apellido'];
		    $_SESSION['rol_fk'] = $rowLogin['rol_fk'];
		    $_SESSION['id'] = $rowLogin['id'];
		    //echo $_SESSION['rol_fk'];

			if ($rowLogin['rol_fk'] == 1 ) { // 1 = rol Alumno
				echo '<script language="JavaScript"> location ="escritorioPasante.php?enviado=0"	</script>';
				//echo 'logueado alumno';
			}
		}
		echo '<script language="JavaScript"> alert("Datos incorrectos"); window.location ="login.php"; </script>';
	}
}
?>