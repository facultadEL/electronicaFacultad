<?php
	session_start();

	include_once "chekearLogin.php";

?>
<!DOCTYPE>
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
//$enviado = $_REQUEST['enviado'];
//if (isset($_REQUEST['enviado'])) { //para que no se ejecute el código en caso de no tener un archivo cargado
if ($enviado == 1) {
$nombre_idea = ucwords($_REQUEST['nombre']);
//echo 'nombre idea: '.$nombre_idea;
$archivo = $_REQUEST['add_idea'];
$id = $_SESSION['id_Pasante'];
$id_new_idea = traerId('idea');
	//$destino = loadFileToServer('aca va la carpeta destino');
	$destino = '/electronica/archivo.pdf';
	$cont = 0;
	$newIdea="INSERT INTO idea(id,nombre, archivo, estado, pasante_fk)VALUES('$id_new_idea','$nombre_idea','$destino',2,'$id');";

	$profe = traerSqlCondicion('profesor.id, rol_fk','profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','rol_fk = 3');
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
			echo '<script language="JavaScript"> alert("Los datos no se guardaron correctamente. Pongase en contacto con el administrador");</script>';
			//echo $errorpg;
		}else{
			echo '<script language="JavaScript"> alert("Los datos se guardaron correctamente."); window.location = "escritorioPasante.php";</script>';
		}
}else{
	$id = $_SESSION['id_Pasante'];
	$hayIdea = 0;
		$consultarIdea = pg_query("SELECT i.id, pasante_fk, i.nombre, archivo, estado FROM idea i INNER JOIN pasante p ON i.pasante_fk = p.id WHERE pasante_fk = $id;");
		while($rowIdea=pg_fetch_array($consultarIdea,NULL,PGSQL_ASSOC)){
			$id_Pasante = $rowIdea['pasante_fk'];
			$id_Idea = (empty($rowIdea['id'])) ? 0 : $rowIdea['id'];
			$nombre_idea = $rowIdea['nombre'];
			$estado = $rowIdea['estado'];
			$archivo = $rowIdea['archivo'];

			if ($id_Idea != 0) {
				$hayIdea = 1;
			}
		}
	}
if ($hayIdea == 0) { 
?>
<body>
<div id="formulario">
<h2>Seguimiento de la Idea</h2>
<?php include_once "menuPasante.html"; ?>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="?enviado=1" method="post" enctype="multipart/form-data">

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
					<input id="path" name="path" type="text" class="campoText" value="" readonly="true"/>
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
			<!-- <tr>
				<td width="3%" align="right">
					<label for="estado">Estado: </label>
				</td>
				<td width="20%" class="lbl_estado" align="left">
					<?php
						//$consultaEstado=traerSqlCondicion('id,nombre','estado_idea','id=1');
						//$consultaEstado=pg_query("SELECT id,nombre FROM estado_idea");
						//while($rowEstado=pg_fetch_array($consultaEstado)){
							//if ($rowEstado['id'] == 1){
		                //    	echo '<l1>'.$rowEstado['nombre'].'</l1>';
							//}
							//echo '<input id="carrera_alumno" name="carrera_alumno" type="hidden" value="'.$carrera_alumno.'"/>';
						//}
					?>
				</td>
			</tr> -->
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
						<img id="imagen2" src="img/uploaded-idea.png">
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
						$contAP = 0;
						$visto = 0;
						$estXprofe=traerSqlCondicion('ideaaprobada,visto','ideaxprofesor','idea='.$id_Idea);
						while($rowEstXProfe=pg_fetch_array($estXprofe)){
							if ($rowEstXProfe['ideaaprobada'] == 't') {
		                    	$contAP++;
		                    }
		                    if ($rowEstXProfe['visto'] == 't') {
		                    	$visto++;
		                    }
		                }
						//echo 'contNA: '.$contAP.'<br>';
						if ($contAP == 5 && $visto == 5) {
							$consultaEstado=traerSqlCondicion('id,nombre','estado_idea','id=3');
							$rowEstado=pg_fetch_array($consultaEstado);
								echo '<l1>'.$rowEstado['nombre'].'</l1>';
						}
						if ($visto > 0 && $visto == $contAP && $contAP != 5) {
							$consultaEstado=traerSqlCondicion('id,nombre','estado_idea','id=2');
							$rowEstado=pg_fetch_array($consultaEstado);
								echo '<l1>'.$rowEstado['nombre'].'</l1>';		
						}else{
							if ($visto > 0 && $contAP < 5) {
									$consultaEstado=traerSqlCondicion('id,nombre','estado_idea','id=4');
									$rowEstado=pg_fetch_array($consultaEstado);
										echo '<l1>'.$rowEstado['nombre'].'</l1>';
							}	
						}
						if ($visto == 0) {
							$consultaEstado=traerSqlCondicion('id,nombre','estado_idea','id=2');
								$rowEstado=pg_fetch_array($consultaEstado);
									echo '<l1>'.$rowEstado['nombre'].'</l1>';
						}
					?>
				</td>
			</tr>
		</table>
</div>		
	<table id="tablaCalif" align="center" width="100%" border="0">
		<thead>
			<tr width="100%">
				<th class="td" width="100%" colspan="5" align="center">
					<l2>CALIFICACIONES</l2>
					<!-- <input class="submit" type="submit" value="Guardar"/>  ver si se va a poner un botón y cual?--> 
				</th>
			</tr>
		
		<tr>
			<?php
				//$sql = traerSql('id,nombre,apellido','profesor');
				$sql = traerSqlCondicion('profesor.id, profesor.nombre, apellido, rol_fk','profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','rol_fk = 3');
				while ($rowIdeaXProfe = pg_fetch_array($sql)){
					echo '<td class="td" width="20%"><l2>'.$rowIdeaXProfe['nombre'].', '.$rowIdeaXProfe['apellido'].'</l2></td>';
				}
			?>
		</tr>
		</thead>
		<tbody>
		<tr>
		<?php
			$cont = 0;
			//$sql = traerSqlCondicion('ixp.id,idea,profesor,ideaaprobada','ideaxprofesor ixp INNER JOIN profesor p ON ixp.profesor = p.id','idea = '.$id_Idea);
			$sql = traerSqlCondicion('id,idea,profesor,ideaaprobada,visto','ideaxprofesor','idea = '.$id_Idea.' ORDER BY id');
			while ($rowIdeaXProfe = pg_fetch_array($sql)){
				$calificacion = $rowIdeaXProfe['ideaaprobada'];
				if ($rowIdeaXProfe['visto'] == 'f') {
					echo '<td class="azul td"><l2>No Evaluado</l2></td>';
				}else{
					if ($calificacion == 't') {
						echo '<td class="verde td"><l2>Aprobada</l2></td>';
					}else{
						echo '<td class="rojo td"><l2>No Aprobada</l2></td>';
					}
				}
				$cont++;
			}
		?>
		</tr>
		<tr>
			<?php
				$sql = traerSqlCondicion('profesor.id, profesor.nombre, rol_fk','profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','rol_fk = 3');
				//$sql = traerSql('id,nombre','profesor');
				while ($rowIdeaXProfe = pg_fetch_array($sql)){
					echo '<td class="contactar"><a href="sendToProfe.php?idProfesor='.$rowIdeaXProfe['id'].'"><img class="msj" src="img/msj.png" title="Click aqu&iacute; para enviar un mail al profesor '.$rowIdeaXProfe['nombre'].'"><l3>  Contactar</l3></a></td>';
				}
			?>
		</tr>
		</tbody>
	</table>
	</form>
	</div>
	</body>

<?php	}
include_once "cerrar_conexion.php";
 ?>
</html>