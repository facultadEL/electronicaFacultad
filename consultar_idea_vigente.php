<body>
	<div id="formulario">
	<?php
		if ($informe_final == 1) {
			echo '<h2>Seguimiento del informe final</h2>';
		}else{
			echo '<h2>Seguimiento de la Idea</h2>';
		}
		include_once "menuPasante.html";
	?>
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
							if ($informe_final == 1) {
								$id_Idea = $id_informe;
							}
							$estado_idea=traerSqlCondicion('estado, estado_idea.nombre','idea INNER JOIN estado_idea ON estado_idea.id = idea.estado','idea.id ='.$id_Idea);
							$row_estado_idea=pg_fetch_array($estado_idea);
							echo '<l1>'.$row_estado_idea['nombre'].'</l1>';
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
				if ($informe_final == 1) {
					$sql = traerSqlCondicion('informexprofesor.id,informe_final,profesor,informeaprobado,visto','informexprofesor INNER JOIN profesor ON profesor.id = informexprofesor.profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','informe_final = '.$id_informe.' AND rol_fk <> 2 ORDER BY id');
					while ($rowIdeaXProfe = pg_fetch_array($sql)){
						$calificacion = $rowIdeaXProfe['informeaprobado'];
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
				}else{
					$sql = traerSqlCondicion('ideaxprofesor.id,idea,profesor,ideaaprobada,visto','ideaxprofesor INNER JOIN profesor ON profesor.id = ideaxprofesor.profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','idea = '.$id_Idea.' AND rol_fk <> 2 ORDER BY id');
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
				}
			?>
			</tr>

			<tr>
			<?php
				$cont = 0;
				//$sql = traerSqlCondicion('ixp.id,idea,profesor,ideaaprobada','ideaxprofesor ixp INNER JOIN profesor p ON ixp.profesor = p.id','idea = '.$id_Idea);
				if ($informe_final == 1) {
					$sql = traerSqlCondicion('informexprofesor.id,informe_final,informeaprobado,visto,fecha_calif','informexprofesor INNER JOIN profesor ON profesor.id = informexprofesor.profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','informe_final = '.$id_informe.' AND rol_fk <> 2 ORDER BY id');
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
				}else{
					$sql = traerSqlCondicion('ideaxprofesor.id,idea,ideaaprobada,visto,fecha_calif','ideaxprofesor INNER JOIN profesor ON profesor.id = ideaxprofesor.profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','idea = '.$id_Idea.' AND rol_fk <> 2 ORDER BY id');
					while ($rowIdeaXProfe = pg_fetch_array($sql)){
						$calificacion = $rowIdeaXProfe['ideaaprobada'];
						$fecha_calif = $rowIdeaXProfe['fecha_calif'];
						if ($rowIdeaXProfe['visto'] == 't') {
							echo '<td class="fecha td">'.$fecha_calif = setDate($fecha_calif).'</td>';
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
				//$sql = traerSqlCondicion('ixp.id,idea,profesor,ideaaprobada','ideaxprofesor ixp INNER JOIN profesor p ON ixp.profesor = p.id','idea = '.$id_Idea);
				if ($informe_final == 1) {
					$sql = traerSqlCondicion('informexprofesor.id,informe_final,informeaprobado,visto, observacion','informexprofesor INNER JOIN profesor ON profesor.id = informexprofesor.profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','informe_final = '.$id_informe.' AND rol_fk <> 2 ORDER BY id');
					while ($rowIdeaXProfe = pg_fetch_array($sql)){
						$calificacion = $rowIdeaXProfe['informeaprobado'];
						$observacion = $rowIdeaXProfe['observacion'];
						if ($rowIdeaXProfe['visto'] == 't') {
							//if ($calificacion == 't') {
								echo '<td class="observa td">'.$observacion.'</td>';
							// }else{
							// 	echo '<td class="observa td">'.$fecha_desaprobada = setDate($fecha_desaprobada).'</td>';
							// }
						}else{
							echo '<td class="observa td"><l2></l2></td>';
						}
						$cont++;
					}
				}else{
					$sql = traerSqlCondicion('ideaxprofesor.id,idea,ideaaprobada,visto, observacion','ideaxprofesor INNER JOIN profesor ON profesor.id = ideaxprofesor.profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','idea = '.$id_Idea.' AND rol_fk <> 2 ORDER BY id');
					while ($rowIdeaXProfe = pg_fetch_array($sql)){
						$calificacion = $rowIdeaXProfe['ideaaprobada'];
						$observacion = $rowIdeaXProfe['observacion'];
						if ($rowIdeaXProfe['visto'] == 't') {
							//if ($calificacion == 't') {
								echo '<td class="observa td">'.$observacion.'</td>';
							// }else{
							// 	echo '<td class="observa td">'.$fecha_desaprobada = setDate($fecha_desaprobada).'</td>';
							// }
						}else{
							echo '<td class="observa td"><l2></l2></td>';
						}
						$cont++;
					}
				}
			?>
			</tr>


			<tr>
				<?php
					if ($informe_final == 1) {
						$sql = traerSqlCondicion('profesor.id, profesor.nombre, rol_fk','profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','rol_fk = 3');
						//$sql = traerSql('id,nombre','profesor');
						while ($rowIdeaXProfe = pg_fetch_array($sql)){
							echo '<td class="contactar"><a href="sendToProfe.php?idProfesor='.$rowIdeaXProfe['id'].'"><img class="msj" src="img/msj.png" title="Click aqu&iacute; para enviar un mail al profesor '.$rowIdeaXProfe['nombre'].'"><l3>  Contactar</l3></a></td>';
						}
					}else{
						$sql = traerSqlCondicion('profesor.id, profesor.nombre, rol_fk','profesor INNER JOIN usuario ON profesor.usuario_fk = usuario.id','rol_fk = 3');
						//$sql = traerSql('id,nombre','profesor');
						while ($rowIdeaXProfe = pg_fetch_array($sql)){
							echo '<td class="contactar"><a href="sendToProfe.php?idProfesor='.$rowIdeaXProfe['id'].'"><img class="msj" src="img/msj.png" title="Click aqu&iacute; para enviar un mail al profesor '.$rowIdeaXProfe['nombre'].'"><l3>  Contactar</l3></a></td>';
						}
					}
				?>
			</tr>
			</tbody>
		</table>
		</form>
		</div>
	</body>