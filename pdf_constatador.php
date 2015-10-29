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
$id_idea = (empty($_REQUEST['idea'])) ? 0 : $_REQUEST['idea'];
//if (isset($_REQUEST['enviado'])) { //para que no se ejecute el código en caso de no tener un archivo cargado
if ($enviado == 1) {
	$id_idea = (empty($_REQUEST['idea'])) ? 0 : $_REQUEST['idea'];
	$archivo = $_REQUEST['add_idea'];
	$destino = loadFileToServer('electronicaFacultad');
	$fecha_registro = date(Ymd);
	$id_Constatador = $_SESSION['id_Constatador'];
	$esFinal = ($_REQUEST['esFinal'] == 0) ? 'FALSE' : 'TRUE';
	$newPDF="INSERT INTO informe_idea(idea, archivo_pdf, fecha_registro_pdf, constatador, es_final)VALUES($id_idea,'$destino','$fecha_registro',$id_Constatador,$esFinal);";
	if($_REQUEST['esFinal'] == 1){
		$cant_mails = 6;
		$mail_profe = '';
		$mail_pasante = traer_dato('mail','idea INNER JOIN pasante ON pasante.id = idea.pasante_fk','idea.id = '.$id_idea).';';
	}else{
		$mail_profe = traer_dato('mail','idea INNER JOIN pasante ON pasante.id = idea.pasante_fk','idea.id = '.$id_idea).';';
		$cant_mails = 7;
	}
	$profe = traerSqlCondicion('profesor.id,profesor.mail,rol_fk','profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','rol_fk IN(2,3)');
	while($rowIdP=pg_fetch_array($profe,NULL,PGSQL_ASSOC)){
		$mail_profe .= $rowIdP['mail'].';';
    }
    //$mail_profe = "lucas.peraltam@outlook.com;lpm19.2009@gmail.com;eze.olea.f@gmail.com;";
    //echo 'lista: '.$mail_profe.'<br>';
    //echo 'destino: '.$destino.'<br>';
    $cuerpo = "
		<div align='left'>
		    <div align='left'>
		        <strong>Nuevo Seguimiento de la Idea</strong><br/><br/>

		        Se agreg&oacute; un nuevo seguimiento sobre una idea en ejecuci&oacute;n.<br/><br />
		        
				Presione aqu&iacute; para ver la idea, <a href=".'"http://extension.frvm.utn.edu.ar/electronicaFacultad/login.php" target="_blank"'.">Ver</a>.<br /><br />
		    </div>
		</div>
	";
	$asunto = "Seguimiento de la idea";
	$sendFrom = "dpto-electronica@frvm.utn.edu.ar";
	$from_name = "Dpto Electronica";

	$sendFrom = "dpto-electronica@frvm.utn.edu.ar";
	$from_name = "Dpto Electronica";
	//$to2 = "etell@frvm.utn.edu.ar";
	$to = $mail_profe.'<br>';
	//$to2 = "lucas.peraltam@outlook.com";

	enviarMail($cuerpo,$asunto,$sendFrom,$from_name,$to,NULL,$cant_mails);
	
	if($_REQUEST['esFinal'] == 0){
		$error = GuardarSql($newPDF);
		if ($error==1){
			//echo '<script language="JavaScript"> alert("Los datos no se guardaron correctamente. Pongase en contacto con el administrador");</script>';
			//echo $errorpg;
		}else{
			echo '<script language="JavaScript"> alert("Los datos se guardaron correctamente."); window.location = "escritorioConstatador.php";</script>';
		}
	}else{
		//es final
		$cuerpo2 = "
			<div align='left'>
			    <div align='left'>
			        <strong>Final del seguimiento</strong><br/><br/>

			        Se agreg&oacute; el &uacute;ltimo PDF con el seguimiento. El siguiente paso es que subas tu informe final.
			    </div>
			</div>
		";
		$asunto2 = "Final del Seguimiento de la idea";
		enviarMail($cuerpo2,$asunto2,$sendFrom,$from_name,$mail_pasante,NULL,1);
		$newPDF .= "UPDATE idea SET estado=6 WHERE id = $id_idea;";
		$error = GuardarSql($newPDF);
		if ($error==0){
			//echo '<script language="JavaScript"> alert("Los datos no se guardaron correctamente. Pongase en contacto con el administrador");</script>';
			//echo $errorpg;
			//}else{
			echo '<script language="JavaScript"> alert("Los datos se guardaron correctamente."); window.location = "escritorioConstatador.php";</script>';
		}
	}
}
include_once "cerrar_conexion.php";
?>
<body>
<div id="formulario">
<h2>Seguimiento de la Idea</h2>
<?php include_once "menuConstatador.html"; ?>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="?enviado=1&idea=<?php echo $id_idea; ?>" method="post" enctype="multipart/form-data">

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
				<h1>&nbsp;</h1>
			</td>
		</tr>
		<tr>
			<td width="3%" align="right">
				<label for="nombre">Archivo </label>
			</td>
			<td width="20%" align="left">
				<input id="path" name="path" type="text" class="campoText" value="" readonly="true"/>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td width="3%" align="right">
				<label for="nombre">&iquest;Es final&quest; </label>
			</td>
			<td width="20%" align="left">
				&nbsp;<input id="esFinal" name="esFinal" type="radio" value="1" />S&iacute;&nbsp;&nbsp;
				<input id="esFinal" name="esFinal" type="radio" value="0" checked />No
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
</html>