<?php
	session_start();

	include_once "chekearLogin.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' src="jquery.min-1.9.1.js"></script>
<script src="jquery.mask.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/escritorioPasante.css">
<title><?php echo 'Bienvenido, '.$_SESSION['nombre'];?></title>
<script type="text/javascript">
	function directorio(){
		var nombreArchivo = $('#add_idea').val(); 
		nombreArchivoSeparado = nombreArchivo.split('\\');
		nombreArchivoFinal = nombreArchivoSeparado[nombreArchivoSeparado.length - 1];
		nombreArchivoFinal = $('#path').val(nombreArchivoFinal);
		//alert(filename);
	}

	function validarArchivo(){
		nombreArchivoValidar = $('#add_idea').val();
		if(nombreArchivoValidar != ""){
			vNombreArchivoValidar = nombreArchivoValidar.split('.');
			extension = vNombreArchivoValidar[vNombreArchivoValidar.length - 1];
			if(extension != "pdf"){
				alert("Debe ingresar un archivo pdf!");
				$('#add_idea').val("");
			}
		}
	}

	function validarForm(){
		nombreArchivoValidar = $('#add_idea').val();
		if(nombreArchivoValidar != ""){
			vNombreArchivoValidar = nombreArchivoValidar.split('.');
			extension = vNombreArchivoValidar[vNombreArchivoValidar.length - 1];
			if(extension == "pdf"){
				return true;
			}
		}
		return false;
	}
</script>
</head>

<?php
include_once "conexion.php";
include_once "libreria.php";

$enviado = (empty($_REQUEST['enviado'])) ? 0 : $_REQUEST['enviado'];
$inf_fin = (empty($_REQUEST['inf_fin'])) ? 0 : $_REQUEST['inf_fin'];

$id = $_SESSION['id_Pasante'];

$cant_ideas = contarRegistro('id','idea','pasante_fk = '.$id);
$cant_informes = contarRegistro('id','informe_final','pasante_fk = '.$id);
echo 'cant_ideas: '.$cant_ideas.'<br>';
echo 'cant_informes: '.$cant_informes.'<br>';

$cargar_idea = 0;
$consulta_idea = 0;
//$tiene_idea = 0;

$cargar_informe = 0;
$consulta_informe_final = 0;
if ($cant_ideas == 0) {
	$cargar_idea = 1;
}
if ($cant_ideas > 0 && $cant_informes == 0) {
	$sqlEst = traerSqlCondicion('id,estado','idea','pasante_fk = '.$id.' ORDER BY id desc');
	$rowEI=pg_fetch_array($sqlEst);
		$id_Idea = $rowEI['id'];
		$estado_idea = $rowEI['estado'];
	if ($estado_idea == 4) {
		//echo 'entra 4';
		$cargar_idea = 1; //cargar nueva idea ya que no está aprobada la anterior
	}elseif($estado_idea == 6){
		//echo 'entra 6';
		$cargar_informe = 1;
	}elseif($estado_idea == 2){
		//echo 'entra 2';
		$consulta_idea = 1;
	}else{
		//echo 'entra';
		$consulta_idea = 1;
	}
	//$tiene_idea = 1;
	//$tiene_informe = 0;
}
if ($cant_informes > 0) {
	$estado_informe = traer_dato('estado','informe_final','pasante_fk = '.$id);
	if ($estado_informe == 4) {
		$cargar_informe = 1; //cargar nuevo informe ya que no está aprobada la anterior
	}else{
		$consulta_informe_final = 1;
	}

	//$tiene_idea = 0;
	//$informe_final = 1;
}


if ($enviado == 1) {
	$nombre_idea = ucwords($_REQUEST['nombre']);
//echo 'nombre idea: '.$nombre_idea;
	$archivo = $_REQUEST['add_idea'];
//$id = $_SESSION['id_Pasante'];
	$id_new_idea = traerId('idea');
	$destino = loadFileToServer('electronicaFacultad');
	$fecha_registro = date(Ymd);
	//$destino = '/electronica/archivo.pdf';
	$cont = 0;
	$newIdea="INSERT INTO idea(id,nombre, archivo, estado, pasante_fk, fecha_registro)VALUES('$id_new_idea','$nombre_idea','$destino',2,'$id','$fecha_registro');";
	//echo $newIdea;
	$profe = traerSqlCondicion('profesor.id, rol_fk','profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','rol_fk IN(2,3)');
	while($rowIdP=pg_fetch_array($profe,NULL,PGSQL_ASSOC)){
		$id_profe[$cont] = $rowIdP['id'];
    	//echo 'idProfesor: '.$id_profe[$cont];
    	$cont++;
    }
    
	for ($i=0; $i < $cont ; $i++) { 
		$newIdea .= "INSERT INTO ideaxprofesor(idea, profesor)VALUES('$id_new_idea',$id_profe[$i]);";
	}

	$error = GuardarSql($newIdea);
		if ($error==1){
			//echo '<script language="JavaScript"> alert("Los datos no se guardaron correctamente. Pongase en contacto con el administrador");</script>';
		}else{
			echo '<script language="JavaScript"> alert("Los datos se guardaron correctamente."); window.location = "escritorioPasante.php";</script>';
		}
}else{
	//$id = $_SESSION['id_Pasante'];
	if ($consulta_informe_final == 1) {
		$consultarInforme = pg_query("SELECT i.id, pasante_fk, i.nombre, archivo, estado, fecha_registro FROM informe_final i INNER JOIN pasante p ON i.pasante_fk = p.id WHERE pasante_fk = $id;");
		while($rowInforme=pg_fetch_array($consultarInforme,NULL,PGSQL_ASSOC)){
			$id_Pasante = $rowInforme['pasante_fk'];
			$id_informe = (empty($rowInforme['id'])) ? 0 : $rowInforme['id'];
			$nombre_informe = $rowInforme['nombre'];
			$estado = $rowInforme['estado'];
			$archivo = $rowInforme['archivo'];
			$fecha_registro = $rowInforme['fecha_registro'];
		}
	}
	if ($consulta_idea == 1) {
		$consultarIdea = pg_query("SELECT i.id, pasante_fk, i.nombre, archivo, estado, fecha_registro FROM idea i INNER JOIN pasante p ON i.pasante_fk = p.id WHERE pasante_fk = $id;");
		while($rowIdea=pg_fetch_array($consultarIdea,NULL,PGSQL_ASSOC)){
			$id_Pasante = $rowIdea['pasante_fk'];
			$id_Idea = (empty($rowIdea['id'])) ? 0 : $rowIdea['id'];
			$nombre_idea = $rowIdea['nombre'];
			$estado = $rowIdea['estado'];
			$archivo = $rowIdea['archivo'];
			$fecha_registro = $rowIdea['fecha_registro'];
		}
	}
}

if ($inf_fin == 1) {
	$nombre_idea = ucwords($_REQUEST['nombre']);
	//echo 'nombre idea: '.$nombre_idea;
	$archivo = $_REQUEST['add_idea'];
	//$id = $_SESSION['id_Pasante'];
	$id_new_informe = traerId('informe_final');
		$destino = loadFileToServer('electronicaFacultad');
		$fecha_registro = date(Ymd);
		//$destino = '/electronica/archivo.pdf';
		$cont = 0;
		$newIdea="INSERT INTO informe_final(id,nombre, archivo, estado, pasante_fk, fecha_registro)VALUES('$id_new_informe','$nombre_idea','$destino',2,'$id','$fecha_registro');";
		//echo $newIdea;
		$profe = traerSqlCondicion('profesor.id, rol_fk','profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','rol_fk IN(2,3)');
		while($rowIdP=pg_fetch_array($profe,NULL,PGSQL_ASSOC)){
			$id_profe[$cont] = $rowIdP['id'];
	    	//echo 'idProfesor: '.$id_profe[$cont];
	    	$cont++;
	    }
	    
		for ($i=0; $i < $cont ; $i++) { 
			$newIdea .= "INSERT INTO informexprofesor(informe, profesor)VALUES('$id_new_informe',$id_profe[$i]);";
		}

		$error = GuardarSql($newIdea);
		if ($error==1){
			//echo '<script language="JavaScript"> alert("Los datos no se guardaron correctamente. Pongase en contacto con el administrador");</script>';
			//echo $errorpg;
		}else{
			echo '<script language="JavaScript"> alert("Los datos se guardaron correctamente."); window.location = "escritorioPasante.php";</script>';
		}
}

	if ($cargar_idea == 1) {
		include_once "cargar_idea.php";
	}
	if($consulta_idea == 1){ 
		include_once "consultar_idea_vigente.php";
	}
	if ($cargar_informe == 1) { 
		include_once "cargar_informe_final.php";
	}
	if ($consulta_informe_final == 1) { 
		include_once "consultar_informe_final_vig.php";
	}

	include_once "cerrar_conexion.php"; ?>
</html>