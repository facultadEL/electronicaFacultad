<?php
	session_start();
/*	echo 'Rol: '.$_SESSION['rol_fk'].'<br>';
	echo 'id: '.$_SESSION['id'].'<br>';*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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


$enviado = $_REQUEST['enviado'];
if ($enviado == 1) { //para que no se ejecute el código en caso de no tener un archivo cargado
$nombre_idea = ucwords($_REQUEST['nombre']);
$archivo = $_REQUEST['add_idea'];
$id = $_SESSION['id'];

	//$destino = loadFileToServer('aca va la carpeta destino');
	$destino = '/electronica/archivo.pdf';
	$newIdea="INSERT INTO idea(nombre, archivo, estado, pasante_fk)VALUES('$nombre_idea','$destino',1,'$id');";
	$error=0;
		if (!pg_query($conn, $newIdea)){
			$errorpg = pg_last_error($conn);
			$termino = "ROLLBACK";
			$error=1;
		}else{
			$termino = "COMMIT";
		}
		pg_query($termino);
			
		if ($error==1){
			echo '<script language="JavaScript"> alert("Los datos no se guardaron correctamente. Pongase en contacto con el administrador");</script>';
			//echo $errorpg;
		}else{
			echo '<script language="JavaScript"> alert("Los datos se guardaron correctamente."); window.location = "escritorioPasante.php";</script>';
		}
}else{
	//$hayIdea = 0;

$id = $_SESSION['id'];
$hayIdea = 0;
	$consultarIdea = pg_query("SELECT i.id, pasante_fk, i.nombre, archivo, estado FROM idea i INNER JOIN pasante p ON i.pasante_fk = p.id WHERE pasante_fk = $id;");
	while($rowIdea=pg_fetch_array($consultarIdea,NULL,PGSQL_ASSOC)){
		$id_Pasante = $rowIdea['pasante_fk'];
		$id_Idea = $rowIdea['id'];
		$nombre_idea = $rowIdea['nombre'];
		$estado = $rowIdea['estado'];
		$archivo = $rowIdea['archivo'];
		
		if ($id_Idea != 0 && $enviado == 0  || $id_Idea != NULL && $enviado == 0) {
			$hayIdea = 1;
		}
	}
}
if ($hayIdea == 0) { 
?>
<body>
<div id="formulario">
<h2>Seguimiento de la Idea</h2>
<?php include_once "menuPasante.html";?>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="" method="post" enctype="multipart/form-data">
<!-- <table id="tablaCuerpo" align="center">
	<tr width="100%">
		<td width="1%" align="center" rowspan="4">
			<label for="add_idea"><img id="imagen" src="img/add-idea.png" width="180" height="180"></label>
			<input id="add_idea" name="add_idea" type="file" onchange="validarArchivo();directorio();" required/>
		</td>
		<td width="40%" colspan="2">
			<h1>No tienes ninguna idea subida</h1>
		</td>
	</tr>
		<tr>
		<td width="2%" align="right">
			<label for="nombre">Archivo: </label>
		</td>
		<td width="10%" align="left">
			<input id="path" name="path" type="text" class="campoText" value="" disabled="true" />
		</td>
	</tr>
	<tr>
		<td width="2%" align="right">
			<label for="nombre">Nombre: </label>
		</td>
		<td width="10%" align="left">
			<input id="nombre" name="nombre" type="text" class="campoText" value="" required/>
		</td>
	</tr>
	<tr>
		<td width="2%" align="right">
			<label for="estado" class="lbl_estado">Estado: </label>
		</td>
		<td width="10%" align="left">
			<?php
				//$consultaEstado=pg_query("SELECT id,nombre FROM estado_idea");
				//while($rowEstado=pg_fetch_array($consultaEstado)){
				//	if ($rowEstado['id'] == 1){
                //    	echo '<l1>'.$rowEstado['nombre'].'</l1>';
				//	}
					//echo '<input id="carrera_alumno" name="carrera_alumno" type="hidden" value="'.$carrera_alumno.'"/>';
				//}
			?>
		</td>
	</tr>
</table> -->

<div id="tablaCuerpo">
		<table id="tablaImagen" align="left">
			<tr>
				<td>
					<label for="add_idea">
						<img id="imagen" src="img/add-idea2.png" title="Click aqu&iacute; para subir un PDF">
					</label>
					<input id="add_idea" name="add_idea" type="file" onchange="validarArchivo();directorio();" required/>
				</td>
			</tr>
		</table>
		<table id="tablaDatos">
			<tr width="100%">
				<td width="70%" colspan="2">
					<h1>No tienes ninguna idea subida</h1>
				</td>
			</tr>
				<tr>
				<td width="3%" align="right">
					<label for="nombre">Archivo: </label>
				</td>
				<td width="20%" align="left">
					<input id="path" name="path" type="text" class="campoText" value="" disabled="true" />
				</td>
			</tr>
			<tr>
				<td width="3%" align="right">
					<label for="nombre">Nombre: </label>
				</td>
				<td width="20%" align="left">
					<input id="nombre" name="nombre" type="text" class="campoText" value="" required/>
				</td>
			</tr>
			<tr>
				<td width="3%" align="right">
					<label for="estado">Estado: </label>
				</td>
				<td width="20%" class="lbl_estado" align="left">
					<?php
						$consultaEstado=pg_query("SELECT id,nombre FROM estado_idea");
						while($rowEstado=pg_fetch_array($consultaEstado)){
							if ($rowEstado['id'] == 1){
		                    	echo '<l1>'.$rowEstado['nombre'].'</l1>';
							}
							echo '<input id="carrera_alumno" name="carrera_alumno" type="hidden" value="'.$carrera_alumno.'"/>';
						}
					?>
				</td>
			</tr>
		</table>
</div>
</center>
<table id="tablaBtn" align="center">
	<tr width="100%">	
		<td width="100%" align="center">
			<input id="enviar" class="submit" type="submit" value=""/>
 		</td>
	</tr>
</table>
</form>
</div>
</body>
<?php }else{ ?>
	<body>
	<div id="formulario">
	<h2>Seguimiento de la Idea</h2>
	<?php include_once "menuPasante.html";?>
	<form class="nueva_idea" name="con_idea" id="nueva_idea" action="" method="post" enctype="multipart/form-data">
		
	<div id="tablaCuerpo">
		<table id="tablaImagen" align="left">
			<tr>
				<td>
					<label>
						<img id="imagen2" src="img/uploaded-idea.png" title="Click aqu&iacute; para subir un PDF">
					</label>
				</td>
			</tr>
		</table>
		<table id="tablaDatos">
			<tr width="100%">
				<td width="70%" id="textoCI" colspan="2">
					<h1>Existe una idea!</h1>
				</td>
			</tr>
				<tr>
				<td width="3%" id="textoCI">
					<label for="nombre">Archivo: </label>
				</td>
				<td width="20%" id="campoCI">
					<l1><?php echo $archivo; ?></l1>
				</td>
			</tr>
			<tr>
				<td width="3%" id="textoCI">
					<label for="nombre">Nombre: </label>
				</td>
				<td width="20%" id="campoCI">
					<l1><?php echo $nombre_idea; ?></l1>
				</td>
			</tr>
			<tr>
				<td width="3%" id="textoCI">
					<label for="estado">Estado: </label>
				</td>
				<td width="20%" id="campoCI">
					<?php
						$consultaEstado=traerSql('id,nombre','idea');
						while($rowEstado=pg_fetch_array($consultaEstado)){
							if ($rowEstado['id'] == $estado){
		                    	echo '<l1>'.$rowEstado['nombre'].'</l1>';
							}
							//echo '<input id="carrera_alumno" name="carrera_alumno" type="hidden" value="'.$carrera_alumno.'"/>';
						}
					?>
				</td>
			</tr>
		</table>
</div>		
	<table id="tablaBtn" align="center">
		<tr width="100%">
			<tr><td><br></td></tr>
			<td width="100%" align="center">
				<l1>Para hacer: Acá poner la calificación de cada profesor de la idea. </l1>
				<!-- <input class="submit" type="submit" value="Guardar"/>  ver si se va a poner un botón y cual?--> 
			</td>
		</tr>
	</table>
	</form>
	</div>
	</body>

<?php	} ?>
</html>