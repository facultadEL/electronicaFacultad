<?php
session_start();
$usuario = $_REQUEST['usuario'];
$password = $_REQUEST['password'];
echo 'usuario: '.$usuario.'<br>';
echo 'password: '.$password.'<br>';



include_once "conexion.php";

//verifico si el usuario y password están en la base de datos
$hayDatosBD = 0;
$usuario_encontrado = 0;
$password_encontrado = 0;
$usuario_bd = pg_query("SELECT p.id,mail,password,logueado,p.nombre,apellido,rol_fk FROM pasante p INNER JOIN rol r ON p.rol_fk = r.id WHERE UPPER(mail) LIKE UPPER('{$_REQUEST['usuario']}') OR UPPER(password) LIKE UPPER('{$_REQUEST['password']}') LIMIT 1");
while($rowLogin=pg_fetch_array($usuario_bd,NULL,PGSQL_ASSOC)){
$id_Pasante = $rowLogin['id'];
$logueado = $rowLogin['logueado'];

	if ($usuario == $rowLogin['mail']){
		$usuario_encontrado = 1;
		echo 'usuario_bd: '.$rowLogin['mail'].'<br>';
	}
	if ($password == $rowLogin['password']){
		$password_encontrado = 1;
		echo 'pass_bd: '.$rowLogin['password'].'<br>';
	}

	if ($usuario_encontrado == 1 && $password_encontrado == 1) {

		$_SESSION['usuario'] = $rowLogin['mail'];
	    $_SESSION['logueado'] = TRUE;
	    $_SESSION['nombre'] = $rowLogin['nombre'];
	    $_SESSION['apellido'] = $rowLogin['apellido'];
	    $_SESSION['rol_fk'] = $rowLogin['rol_fk'];
	    $_SESSION['id'] = $rowLogin['id'];
	    echo $_SESSION['rol_fk'];

		if ($rowLogin['rol_fk'] == 1 ) { // 1 = rol Alumno
			echo '<script language="JavaScript"> location ="escritorioPasante.php"	</script>';
			//echo 'logueado alumno';
		}
	}else{
		echo 'no estas logueado';
	}
}
?>