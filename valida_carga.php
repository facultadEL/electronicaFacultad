<?php

//Control usuario va a devolver una serie de numeros que representan exito o errores
/*
0 - Usuario no encontrado
1 - Usuario y contraseña encontrados correctamente
2 - Contraseña incorrecta
3 - Usuario deshabilitado
4 - Usuario incorrecto
*/

//Abro conexión
$conn = pg_connect("host=localhost port=5432 user=postgres password=postgres dbname=ppselectronica") or die("Error de conexion.".pg_last_error());//conexion local

//$conn = pg_connect("host=190.114.198.126 port=5432 user=extension password=newgenius dbname=ppselectronica") or die("Error de conexion.".pg_last_error()); //conexion facu

$usu_nombre = $_POST["usuario"];
$usu_password = md5($_POST["password"]);

$control = 0;

$sql = pg_query("SELECT mail,password,habilitado FROM usuario WHERE UPPER(mail) like UPPER('{$usu_nombre}') or UPPER(password) like UPPER('{$usu_password}')");
while($rowSql = pg_fetch_array($sql)){
	$usuarioDB = $rowSql['mail'];
	if($usu_nombre == $usuarioDB){

		if($rowSql['habilitado'] == 't'){
			if($usu_password == $rowSql['password']){
				$control = 1;
				echo '1';
				//Cierro conexión
				pg_close($conn);
				break;
			}elseif($usu_password != $rowSql['password']){
				$control = 1;
				echo '2';
				//Cierro conexión
				pg_close($conn);
				break;
			}
		}else{
			$control = 1;
			echo '3';
			//Cierro conexión
			pg_close($conn);
			break;
		}
		//$control = 1;
	}else{
		$control = 1;
		echo '4';
		//Cierro conexión
		pg_close($conn);
		break;
	}
}
if ($control == 0) {
	echo '5';
	//Cierro conexión
	pg_close($conn);
	break;
}

?>