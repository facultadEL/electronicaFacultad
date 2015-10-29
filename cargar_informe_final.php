<body>
	<div id="formulario">
	<h2>Seguimiento del Informe Final</h2>
	<?php include_once "menuPasante.html"; ?>

	<form class="nueva_idea" name="nueva_idea" id="nueva_idea" action="?inf_fin=1" method="post" enctype="multipart/form-data">
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
						<?php
							if ($informe_final == 0) {
								echo '<h1>No tienes ninguna idea subida</h1>';
							}else{
								echo '<h1>Sube tu informe final</h1>';
							}
						?>
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
						<label for="nombre">Nombre Inf. Final: </label>
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