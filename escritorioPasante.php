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
		<li>button 1</li>
		<li>button 2</li>
		<li>button 3</li>
	</ul>
</nav>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="" method="post" enctype="multipart/form-data">
<table align="center" width="100%" border="1">
	<tr width="100%">
		<td width="10%" align="center" rowspan="3">
			<label for="add_idea"><img id="imagen" src="img/add-idea.png" width="200" height="200"></label>
			<input id="add_idea" name="add_idea" type="file" onchange="directorio();" required/>
		</td>
		<td width="40%" align="center" colspan="2">
			<h1>No tienes ninguna idea subida</h1>
		</td>
	</tr>
	<tr>
		<td width="2%" align="right">
			<label for="nombre">Nombre: </label>
		</td>
		<td width="23%" align="left">
			<input id="nombre" name="nombre" type="text" class="campoText" value="" required/>
		</td>
	</tr>
	<tr>
		<td width="2%" align="right">
			<label for="estado">Estado: </label>
		</td>
		<td width="23%" align="left">
			<input id="estado" name="estado" type="text" class="campoText" value="" required/>
		</td>
	</tr>
</table>
</form>
</div>
</body>
<?php } ?>
</html>