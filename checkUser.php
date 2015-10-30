<script type='text/javascript' src="cryptor.js"></script>
<?php

include_once "conexion.php";
include_once "libreria.php";
	$sql = traerSql('mail,password','usuario ORDER BY id');
	while($rowData=pg_fetch_array($sql,NULL,PGSQL_ASSOC)){
		$dataToPass = strtolower($rowData['mail']).'/--/'.$rowData['password'];
		echo "<script>setData('".$dataToPass."')</script>";
	}

//Traigo los datos
$user = $_POST["user"];
$pass = $_POST["pass"];

$condicion = "mail='".$user."' LIMIT 1";

$sql = traerSqlCondicion("password","usuario",$condicion);
$rowSql = pg_fetch_array($sql);

include_once "cerrar_conexion.php";
?>