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
<link rel="stylesheet" href="css/escritorioPasante.css">
<title><?php echo 'Bienvenido, '.$_SESSION['nombre'];?></title>
<script type="text/javascript">
	function directorio(){
		var filename = document.getElementById('add_idea').value; document.getElementById('path').value = filename;
		//alert(filename);
	}
</script>
</head>

<?php
include_once "conexion.php";
include_once "libreria.php";


$enviado = $_REQUEST['enviado'];
if ($enviado == 1) { //para que no se ejecute el código en caso de no tener un archivo cargado
$nombre_idea = ucwords($_REQUEST['nombre']);
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
}

$hayIdea = 0;
	$consultarIdea = pg_query("SELECT i.id, pasante_fk, i.nombre, archivo, estado FROM idea i INNER JOIN pasante p ON i.pasante_fk = p.id;");
	while($rowIdea=pg_fetch_array($consultarIdea,NULL,PGSQL_ASSOC)){
		$id_Pasante = $rowIdea['pasante_fk'];
		$id_Idea = $rowIdea['id'];
		$nombre_idea = $rowIdea['nombre'];
		$estado = $rowIdea['estado'];
		
		if ($id_Idea != 0 || $id_Idea != NULL) {
			$hayIdea = 1;
		}
	}
if ($hayIdea == 0) { 
?>
<body>
<div id="formulario">
<h2>Seguimiento de la Idea</h2>
<nav id="menu">
	<ul> 
		<li><a href="">Perfil</a></li>
		<li><a href="">Menú2</a></li>
		<li><a href="">Cerrar Sesi&oacute;n</a></li>
	</ul>
</nav>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="?enviado=1" method="post" enctype="multipart/form-data">
<table align="center" width="100%">
	<tr width="100%">
		<td width="10%" align="center" rowspan="3">
			<label for="add_idea"><img id="imagen" src="img/add-idea.png" width="180" height="180"></label>
			<input id="add_idea" name="add_idea" type="file" onchange="directorio();" required/>
		</td>
		<td width="40%"  colspan="2">
			<h1>No tienes ninguna idea subida</h1>
			<label id="archivo">Archivo: </label><input id="path" name="path" type="text" class="campoTextArc" value="" disabled="true" />
		</td>
	</tr>
	<tr>
		<td width="6%" align="right">
			<label for="nombre">Nombre idea: </label>
		</td>
		<td width="19%" align="left">
			<input id="nombre" name="nombre" type="text" class="campoText" value="" required/>
		</td>
	</tr>
	<tr>
		<td width="6%" align="right">
			<label for="estado" class="lbl_estado">Estado: </label>
		</td>
		<td width="19%" align="left">
			<?php
				$consultaEstado=pg_query("SELECT * FROM estado_idea");
				while($rowEstado=pg_fetch_array($consultaEstado)){
					if ($rowEstado['id'] == 1){
                    	echo '<l1>'.$rowEstado['nombre'].'</l1>';
					}
					//echo '<input id="carrera_alumno" name="carrera_alumno" type="hidden" value="'.$carrera_alumno.'"/>';
				}
			?>
		</td>
	</tr>
</table>
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
<?php }else{
	echo 'hay idea';
	} ?>
</html>