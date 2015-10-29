<?php
	session_start();

	include_once "chekearLogin.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script type='text/javascript' src="jquery.min-1.9.1.js"></script>
	<link rel="stylesheet" href="css/ver_notas.css">
	<title><?php echo 'Bienvenido, '.$_SESSION['nombre'];?></title>
</head>

<?php
include_once "conexion.php";
include_once "libreria.php";

$idIdea = (empty($_REQUEST['informe'])) ? 0 : $_REQUEST['informe'];
//echo 'id: '.$idIdea;
		$consultarIdea = traerSqlCondicion('i.id, pasante_fk, i.nombre, archivo, estado, fecha_registro', 'informe_final i INNER JOIN pasante p ON i.pasante_fk = p.id', 'i.id = '.$idIdea);
		//$consultarIdea = pg_query("SELECT i.id, pasante_fk, i.nombre, archivo, estado, fecha_registro FROM idea i INNER JOIN pasante p ON i.pasante_fk = p.id WHERE i.id = $idIdea;");
		while($rowIdea=pg_fetch_array($consultarIdea,NULL,PGSQL_ASSOC)){
			$id_Pasante = $rowIdea['pasante_fk'];
			$id_Idea = (empty($rowIdea['id'])) ? 0 : $rowIdea['id'];
			$nombre_idea = $rowIdea['nombre'];
			$estado = $rowIdea['estado'];
			$archivo = $rowIdea['archivo'];
			$fecha_registro = $rowIdea['fecha_registro'];
		}
		//echo 'nombre: '.$nombre_idea;
?>
	<body>
	<div id="formulario">
	<h2>Seguimiento del Informe Final</h2>
	<?php include_once "menuProfe.html"; ?>
	<form class="nueva_idea" name="con_idea" id="nueva_idea" action="" method="post" enctype="multipart/form-data">
		
	<!-- <div id="tablaCuerpo"> -->
		
		<table id="tablaDatos">
			<!-- <tr>
				<td width="3%" id="textoCI">
					<label for="nombre">Archivo: </label>
				</td>
				<td width="20%" id="campoCI">
					<l1><?php //echo $archivo; ?></l1>
				</td>
			</tr> -->
			<tr>
				<td width="5%" id="textoCI">
					<label for="nombre">Nombre Inf. Final: </label>
				</td>
				<td width="18%" id="campoCI">
					<l1><?php echo $nombre_idea; ?></l1>
				</td>
			</tr>
			<tr>
				<td width="5%" id="textoCI">
					<label for="estado">Estado Inf. Final: </label>
				</td>
				<td width="18%" id="campoCI">
					<?php
						$estado_idea=traerSqlCondicion('estado, estado_idea.nombre','informe_final INNER JOIN estado_idea ON estado_idea.id = informe_final.estado','informe_final.id ='.$idIdea);
						$row_estado_idea=pg_fetch_array($estado_idea);
						echo '<l1>'.$row_estado_idea['nombre'].'</l1>';
					?>
				</td>
			</tr>
			<tr>
				<td width="5%" id="textoCI">
					<label for="nombre">Fecha Registro: </label>
				</td>
				<td width="18%" id="campoCI">
					<l1><?php echo $fecha_registro = setDate($fecha_registro); ?></l1>
				</td>
			</tr>
		</table>
<!-- </div>		 -->
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
			$visto = 0;
			//$sql = traerSqlCondicion('ixp.id,idea,profesor,ideaaprobada','ideaxprofesor ixp INNER JOIN profesor p ON ixp.profesor = p.id','idea = '.$id_Idea);
			$sql = traerSqlCondicion('informexprofesor.id,informe,profesor,informeaprobado,visto','informexprofesor INNER JOIN profesor ON profesor.id = informexprofesor.profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','informe = '.$idIdea.' AND rol_fk <> 2 ORDER BY id');
			while ($rowIdeaXProfe = pg_fetch_array($sql)){
				$calificacion = $rowIdeaXProfe['informeaprobado'];
				if ($rowIdeaXProfe['visto'] == 'f') {
					echo '<td class="azul td"><l2>No Evaluado</l2></td>';
				}else{
					$visto = 1;
					$cantObserva = contarRegistro('observacion','informexprofesor','informe = '.$idIdea);
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
			$cont = 0;
			if ($visto == 1) {
				$sql = traerSqlCondicion('informexprofesor.id,informe,informeaprobado,visto,fecha_calif','informexprofesor INNER JOIN profesor ON profesor.id = informexprofesor.profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','informe = '.$idIdea.' AND rol_fk <> 2 ORDER BY id');
				while ($rowIdeaXProfe = pg_fetch_array($sql)){
					$calificacion = $rowIdeaXProfe['informeaprobado'];
					$fecha_calif = $rowIdeaXProfe['fecha_calif'];
					if ($rowIdeaXProfe['visto'] == 't') {
						//if ($calificacion == 't') {
							echo '<td class="fecha td">'.$fecha_calif = setDate($fecha_calif).'</td>';
						//}else{
						//	echo '<td class="fecha td">'.$fecha_desaprobada = setDate($fecha_desaprobada).'</td>';
						//}
					}else{
						echo '<td class="fecha td"><l2></l2></td>';
					}
					$cont++;
				}
			}
		?>
		</tr>

		<tr>
		<?php
			$cont = 0;
			if ($visto == 1) {
				if ($cantObserva > 0) {
					$sql = traerSqlCondicion('informexprofesor.id,informe,informeaprobado,visto, observacion','informexprofesor INNER JOIN profesor ON profesor.id = informexprofesor.profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','informe = '.$idIdea.' AND rol_fk <> 2 ORDER BY id');
					while ($rowIdeaXProfe = pg_fetch_array($sql)){
						$calificacion = $rowIdeaXProfe['informeaprobado'];
						$observacion = $rowIdeaXProfe['observacion'];
						//if ($rowIdeaXProfe['visto'] == 't') {
								echo '<td class="observa td">'.$observacion.'</td>';
						//}else{
							//echo '<td class="observa td"><l2></l2></td>';
						//}
						$cont++;
					}
				}
			}
		?>
		</tr>


		<tr>
			<?php
				$sql = traerSqlCondicion('profesor.id, profesor.nombre, rol_fk','profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','rol_fk = 3');
				//$sql = traerSql('id,nombre','profesor');
				while ($rowIdeaXProfe = pg_fetch_array($sql)){
					echo '<td class="contactar"><a href="sendToProfe_if.php?vernotas=1&informe='.$idIdea.'&idProfesor='.$rowIdeaXProfe['id'].'"><img class="msj" src="img/msj.png" title="Click aqu&iacute; para enviar un mail al profesor '.$rowIdeaXProfe['nombre'].'"><l3>  Contactar</l3></a></td>';
				}
			?>
		</tr>
		</tbody>
	</table>
	</form>
	</div>
	</body>

<?php
include_once "cerrar_conexion.php";
 ?>
</html>