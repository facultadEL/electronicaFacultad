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
//$conn = pg_connect("host=localhost port=5432 user=postgres password=postgres dbname=ppselectronica") or die("Error de conexion.".pg_last_error());//conexion local
include_once "conexion.php";
//$conn = pg_connect("host=190.114.198.126 port=5432 user=extension password=newgenius dbname=ppselectronica") or die("Error de conexion.".pg_last_error()); //conexion facu

$mail = $_POST["mail"];

$control = 0;

$sql = pg_query("SELECT count(*) as total_mail FROM pasante WHERE UPPER(mail) = UPPER('{$mail}') ");
while($rowSql = pg_fetch_array($sql)){
	$total_mail = $rowSql['total_mail'];
}

//Cierro conexión
include_once "cerrar_conexion.php";
echo $total_mail;

?>