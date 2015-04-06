<?php
	session_start();
/*	echo 'Rol: '.$_SESSION['rol_fk'].'<br>';
	echo 'id: '.$_SESSION['id'].'<br>';*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="jquery.mask.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/confirmarPasante.css">
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


//$enviado = $_REQUEST['enviado'];
//if ($enviado == 1) { //para que no se ejecute el código en caso de no tener un archivo cargado
//$nombre_idea = ucwords($_REQUEST['nombre']);
$id_Pasante = $_REQUEST['idPasante'];

	//$destino = loadFileToServer('aca va la carpeta destino');
	//$destino = '/electronica/archivo.pdf';
	//$newAlumno="INSERT INTO idea(nombre, archivo, estado, pasante_fk)VALUES('$nombre_idea','$destino',1,'$id');";
	//$error=0;
	//	if (!pg_query($conn, $newIdea)){
	//		$errorpg = pg_last_error($conn);
	//		$termino = "ROLLBACK";
	//		$error=1;
	//	}else{
	//		$termino = "COMMIT";
	//	}
	//	pg_query($termino);
	//		
	//	if ($error==1){
	//		echo '<script language="JavaScript"> alert("Los datos no se guardaron correctamente. Pongase en contacto con el administrador");</script>';
			//echo $errorpg;
	//	}else{
	//		echo '<script language="JavaScript"> alert("Los datos se guardaron correctamente."); window.location = "escritorioPasante.php";</script>';
	//	}
//}else{
	//$hayIdea = 0;

//$id = $_SESSION['id'];
//$hayIdea = 0;
//}
?>
<body>
<div id="formulario">
<h2>Confirmar Alumno</h2>
<nav id="menu">
	<ul> 
		<li><a href="enDesarrollo.php">Perfil</a></li>
		<li><a href="enDesarrollo.php">Menú2</a></li>
		<li><a href="enDesarrollo.php">Cerrar Sesi&oacute;n</a></li>
	</ul>
</nav>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="?enviado=1" method="post" enctype="multipart/form-data">
<center>
<div id="fila">
	<div id="columnaNombre">
		<label>Pasante</label>
	</div>
	<div id="columnaBtnConfirm">
		<label>Confirmado</label>
	</div>
</div>
	<?php
		$nuevoAlumno = pg_query("SELECT id, nombre, apellido, confirmado FROM pasante WHERE confirmado = false;");
		while($rowNewPasante=pg_fetch_array($nuevoAlumno,NULL,PGSQL_ASSOC)){
			$id = $rowNewPasante['id'];
			$nombre = $rowNewPasante['nombre'];
			$apellido = $rowNewPasante['apellido'];
			$confirmado = $rowNewPasante['confirmado'];
			echo '<div id="fila">';
				echo '<div id="columnaNombre"><label>'.$apellido.', '.$nombre.'</label></div>';
				echo '<div id="columnaBtnConfirm"><label>'.$confirmado.'</label></div>';
			echo '</div>';
		}
	?>
</center>
<table id="tablaBtn" align="center">
	<tr width="100%">	
		<td width="100%" align="center">
			<input class="submit" type="submit" value="Guardar"/>
		</td>
	</tr>
</table>
</form>
</div>
</body>
</html>