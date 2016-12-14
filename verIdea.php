<?php
	session_start();
	include_once "chekearLogin.php";

?>
<!DOCTYPE html5>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' src="jquery.min-1.9.1.js"></script>
<link rel="stylesheet" href="css/calificarIdea.css">
<link rel="stylesheet" href="css/sendToProfe.css">
<title><?php echo 'Bienvenido, '.$_SESSION['nombre'];?></title>

</head>
<body>
<div id="formulario">
<h2>Ideas Aprobadas</h2>
<?php include_once "menuAdmin.html";?>
<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="" method="post" enctype="multipart/form-data">
	<div class="calificarIdea">
		<table id="tablaIdeas" align="center">
			<tr>
				<th>Nombre</th>
                <th>Alumno</th>
				<th>Registro</th>
                <?php
                    include_once "conexion.php";
                    include_once "libreria.php";
                    $c = "select nombre,apellido from profesor where usuario_fk in (select id from usuario where rol_fk=3) order by id asc";
                    $s = pg_query($c);
                    while($r = pg_fetch_array($s)) {
                        echo "<th>".$r['apellido'].", ".$r['nombre'],"</th>";
                    }
                ?>
			</tr>
			<?php
                $id = $_REQUEST['id'];
					//$NuevasIdeas = traerSqlCondicion('ideaxprofesor.id, idea.nombre as nomidea, pasante.nombre as nompasante, apellido, nro_legajo, mail, archivo, visto','ideaxprofesor INNER JOIN idea ON ideaxprofesor.idea = idea.id INNER JOIN pasante ON idea.pasante_fk = pasante.id','profesor ='.$_SESSION['id_Profesor'].' AND visto = false');
                $cI = "select i.id as idea,i.nombre as nombreidea, i.fecha_registro as fechaidea, p.apellido || ', ' || p.nombre as pasante, p.mail from idea i inner join pasante p on(i.pasante_fk = p.id) where i.id=$id";

                $sI = pg_query($cI);
                $rI = pg_fetch_array($sI);
                $idIdea = $rI['idea'];
                $mail = $rI['mail'];
                $pasante = $rI['pasante'];
                echo '<tr>';
                echo '<td>'.$rI['nombreidea'].'</td>';
                echo '<td>'.$rI['pasante'].'</td>';
                echo '<td>'.$rI['fechaidea'].'</td>';

                $cP = "select fecha_calif as f from ideaxprofesor where idea=$idIdea and profesor in (select id from usuario where rol_fk=3) order by profesor asc";
                $sP = pg_query($cP);

                while($rP = pg_fetch_array($sP)) {
                    echo '<td>'.implode('/',array_reverse(explode('-',$rP['f']))).'</td>';
                }

                echo '</tr>';
					
				include_once "cerrar_conexion.php";
			?>
		</table>
	</div>
<div id="tablaCuerpo">
</div>
</center>
</form>
<form class="nueva_idea" name="consulta" id="nueva_idea" action="envioMailPasante.php" method="post" enctype="multipart/form-data">
<table class="mail">
	<tr>
		<td class="label">
			<label for="nombre">Para: </label>
		</td>
		<td class="campo">
			<?php
				echo '<l1> '.$pasante.'</l1>';
                echo '<input type="hidden" name="mail" value="'.$mail.'"/>';
			?>
		</td>
	</tr>
    <tr>
		<td class="label">
			<label for="asunto">Asunto: </label>
		</td>
		<td class="campo">
			<input type="text" id="asunto" name="asunto" value="" required />
		</td>
	</tr>
	<tr>
		<td class="label">
			<label for="nombre">Mensaje: </label>
		</td>
		<td class="campo">
			<textarea name="msj" class="msj" autofocus></textarea>
		</td>
	</tr>
</table>
<center>
<table id="tablaBtn">
	<tr>	
		<td>
			<td width="50%" align="right"><a href="ideas_aprob.php"><input type="button" id="btn_cancelar" value="Cancelar"></a></td>
			<td width="50%" align="left"><input class="submit" type="submit" value="Enviar"/></td>
 		</td>
	</tr>
</table>
</center>
</form>
</div>
</body>
</html>