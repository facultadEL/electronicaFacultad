<body>
	<div id="formulario">
	<?php
		echo '<h2>Seguimiento del informe final</h2>';
		include_once "menuPasante.html";
	?>
	<form class="nueva_idea" name="con_idea" id="nueva_idea" action="" method="post" enctype="multipart/form-data">	
	<div id="tablaCuerpo">
		<table id="tablaImagen" align="left">
			<tr>
				<td>
					<label><img id="imagen2" src="img/uploaded-idea.png"></label>
				</td>
			</tr>
		</table>
		<table id="tablaDatos">
			<tr width="100%">
				<td width="70%" id="textoCI" colspan="2">
					<h1>Existe un informe final!</h1>
				</td>
			</tr>
			<tr>
				<td width="5%" id="textoCI">
					<label for="nombre">Archivo: </label>
				</td>
				<td width="18%" id="campoCI">
					<l1><?php echo $archivo; ?></l1>
				</td>
			</tr>
			<tr>
				<td width="5%" id="textoCI">
					<label for="nombre">Nombre Inf. Final: </label>
				</td>
				<td width="18%" id="campoCI">
					<l1><?php echo $nombre_informe; ?></l1>
				</td>
			</tr>
			<tr>
				<td width="5%" id="textoCI">
					<label for="estado">Estado: </label>
				</td>
				<td width="18%" id="campoCI">
				<?php
					$estado_informe=traerSqlCondicion('estado, estado_idea.nombre','informe_final INNER JOIN estado_idea ON estado_idea.id = informe_final.estado','informe_final.id ='.$id_informe);
					$row_estado_informe=pg_fetch_array($estado_informe);
					echo '<l1>'.$row_estado_informe['nombre'].'</l1>';
				?>
				</td>
			</tr>
			<tr>
				<td width="3%" id="textoCI">
					<label for="nombre">Fecha Registro: </label>
				</td>
				<td width="20%" id="campoCI">
					<l1><?php echo $fecha_registro = setDate($fecha_registro); ?></l1>
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
				$sql = traerSqlCondicion('informexprofesor.id,informe,profesor,informeaprobado,visto','informexprofesor INNER JOIN profesor ON profesor.id = informexprofesor.profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','informe = '.$id_informe.' AND rol_fk <> 2 ORDER BY id');
				while ($rowInfXProfe = pg_fetch_array($sql)){
					$calificacion = $rowInfXProfe['informeaprobado'];
					if ($rowInfXProfe['visto'] == 'f') {
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
				$cont = 0;
				//$sql = traerSqlCondicion('ixp.id,idea,profesor,ideaaprobada','ideaxprofesor ixp INNER JOIN profesor p ON ixp.profesor = p.id','idea = '.$id_Idea);
				$sql = traerSqlCondicion('informexprofesor.id,informe,informeaprobado,visto,fecha_calif','informexprofesor INNER JOIN profesor ON profesor.id = informexprofesor.profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','informe = '.$id_informe.' AND rol_fk <> 2 ORDER BY id');
				while ($rowIdeaXProfe = pg_fetch_array($sql)){
					$calificacion = $rowIdeaXProfe['informeaprobado'];
					$fecha_calif = $rowIdeaXProfe['fecha_calif'];
					if ($rowIdeaXProfe['visto'] == 't') {
						echo '<td class="fecha td">'.$fecha_calif = setDate($fecha_calif).'</td>';
					}else{
						echo '<td class="fecha td"><l2></l2></td>';
					}
					$cont++;
				}
			?>
			</tr>

			<tr>
			<?php
				$cont = 0;
				//$sql = traerSqlCondicion('ixp.id,idea,profesor,ideaaprobada','ideaxprofesor ixp INNER JOIN profesor p ON ixp.profesor = p.id','idea = '.$id_Idea);
				$sql = traerSqlCondicion('informexprofesor.id,informe,informeaprobado,visto, observacion','informexprofesor INNER JOIN profesor ON profesor.id = informexprofesor.profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','informe = '.$id_informe.' AND rol_fk <> 2 ORDER BY id');
				while ($rowIdeaXProfe = pg_fetch_array($sql)){
					$calificacion = $rowIdeaXProfe['informeaprobado'];
					$observacion = $rowIdeaXProfe['observacion'];
					if ($rowIdeaXProfe['visto'] == 't') {
						echo '<td class="observa td">'.$observacion.'</td>';
					}else{
						echo '<td class="observa td"><l2></l2></td>';
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