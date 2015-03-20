<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Varela+Round">
	<link rel="stylesheet" href="css/registroPasante.css">
	<title>Registro de Usuario</title>
</head>
<body>
<?php
include_once "conexion.php";
/*$id_Pasante = $_REQUEST['idPasante'];
$volver = $_REQUEST['volver'];
$numDNI = $_REQUEST['numDNI'];
$dniExistente = $_REQUEST['dniExistente'];

	if ($volver == 1){
		$sep = '/-/';
		$datosPasar = $_REQUEST['verDatos'];
		$mostrar = explode($sep,$datosPasar);
			$nombre_alumno = $mostrar[0];
			$apellido_alumno = $mostrar[1];
			$nro_legajo = $mostrar[2];
			$tipodni_alumno = $mostrar[3];
			$numerodni_alumno = $mostrar[4];
			$fecha_nacimiento_alumno = $mostrar[5];
			// $mostrar = explode('-',$fechanacimiento_alumno);
			// 		$anio = $mostrar[0];
			// 		$mes = $mostrar[1];
			// 		$dia = $mostrar[2];
			// $fecha_nacimiento_alumno = $dia.'-'.$mes.'-'.$anio;
			$provincia_viviendo_alumno = $mostrar[6];
			$localidad_viviendo_alumno = $mostrar[7];
			$cp_alumno = $mostrar[8];
			$calle_alumno = $mostrar[9];
			$numerocalle_alumno = $mostrar[10];
			$piso_alumno = $mostrar[11];
			$dpto_alumno = $mostrar[12];
			$carrera_alumno = $mostrar[13];
			$caracteristicaF_alumno = $mostrar[14];
			$telefono_alumno = $mostrar[15];
			$caracteristicaC_alumno = $mostrar[16];
			$celular_alumno = $mostrar[17];
			$mail_alumno = $mostrar[18];
			$mail_alumno2 = $mostrar[19];
			$facebook_alumno = $mostrar[20];
			$twitter_alumno = $mostrar[21];
			$password_alumno = $mostrar[22];
			$provincia_trabajo_alumno = $mostrar[23];
			$localidad_trabajo_alumno = $mostrar[24];
			$cp_alumno2 = $mostrar[25];
			$empresa_trabaja_alumno = $mostrar[26];
			$perfil_laboral_alumno = $mostrar[27];
			$destinoImagen = $mostrar[28];
			$localidad_nacimiento_alumno = $mostrar[29];
			$ultima_materia_alumno = $mostrar[30];
			$fecha_ultima_mat_alumno = $mostrar[31];
			// $ancho_final = $mostrar[29];
			// $alto_final = $mostrar[30];	
	}else{
		$sqlAlumno = pg_query("SELECT alumno.*,carrera_fk FROM alumno INNER JOIN seguimiento ON(alumno.id_alumno = seguimiento.alumno_fk) WHERE id_alumno = $id_Alumno");
		$rowAlumno = pg_fetch_array($sqlAlumno);
			$id_Alumno = $rowAlumno['id_alumno'];
			$nombre_alumno = $rowAlumno['nombre_alumno'];
			$apellido_alumno = $rowAlumno['apellido_alumno'];
			$nro_legajo = $rowAlumno['nro_legajo'];
			$tipodni_alumno = $rowAlumno['tipodni_alumno'];
			$numerodni_alumno = $rowAlumno['numerodni_alumno'];
			$fechanacimiento_alumno = $rowAlumno['fechanacimiento_alumno'];
				$mostrar = explode('-',$fechanacimiento_alumno);
					$anio = $mostrar[0];
					$mes = $mostrar[1];
					$dia = $mostrar[2];
			$fecha_nacimiento_alumno = $dia.'-'.$mes.'-'.$anio;
			$localidad_nacimiento_alumno = $rowAlumno['localidad_nacimiento_alumno'];
			$provincia_viviendo_alumno = $rowAlumno['provincia_viviendo_alumno'];
			$localidad_viviendo_alumno = $rowAlumno['localidad_viviendo_alumno'];
			$cp_alumno = $rowAlumno['cp_alumno'];
			$calle_alumno = $rowAlumno['calle_alumno'];
			$numerocalle_alumno = $rowAlumno['numerocalle_alumno'];
			$piso_alumno = $rowAlumno['piso_alumno'];
			$dpto_alumno = $rowAlumno['dpto_alumno'];
			$carrera_alumno = $_REQUEST['carrera_fk'];
			$caracteristicaF_alumno = $rowAlumno['caracteristicaf_alumno'];
			$telefono_alumno = $rowAlumno['telefono_alumno'];
			$caracteristicaC_alumno = $rowAlumno['caracteristicac_alumno'];
			$celular_alumno = $rowAlumno['celular_alumno'];
			$mail_alumno = $rowAlumno['mail_alumno'];
			$mail_alumno2 = $rowAlumno['mail_alumno2'];
			$facebook_alumno = $rowAlumno['facebook_alumno'];
			$twitter_alumno = $rowAlumno['twitter_alumno'];
			$password_alumno = $rowAlumno['password_alumno'];
			$provincia_trabajo_alumno = $rowAlumno['provincia_trabajo_alumno'];
			$localidad_trabajo_alumno = $rowAlumno['localidad_trabajo_alumno'];
			$cp_alumno2 = $rowAlumno['cp_alumno2'];
			$empresa_trabaja_alumno = $rowAlumno['empresa_trabaja_alumno'];
			$perfil_laboral_alumno = $rowAlumno['perfil_laboral_alumno'];
			$destinoImagen = $rowAlumno['foto_alumno'];
			$ancho_final = $rowAlumno['ancho_final'];
			$alto_final = $rowAlumno['alto_final'];
			$ultima_materia_alumno = $rowAlumno['ultima_materia_alumno'];
			$fecha_ultimamat_alumno = $rowAlumno['fecha_ultima_mat_alumno'];
			$mostrar = explode('-',$fecha_ultimamat_alumno);
					$anio = $mostrar[0];
					$mes = $mostrar[1];
					$dia = $mostrar[2];
			$fecha_ultima_mat_alumno = $dia.'-'.$mes.'-'.$anio;
	}*/
?>
<div id="formulario">
	<h2>Formulario de Inscripci&oacute;n</h2>
	<form class="formNuevoPasante" name="nuevoPasante" id="formPasante" action="registrarDatosPasante.php?idPasante=<?php echo $id_Pasante ?>" method="post" enctype="multipart/form-data">
		<fieldset>
			<table align="center" id="tablaGeneral" cellpadding="2" cellspacing="2" width="100%">
				<tr>
					<td>
						<legend>Datos Personales</legend>
							<table id="tablaInterna">				
								<tr>
									<td class="etiqueta">
										<label for="nombre_alumno">Nombre: </label>	
									</td>	
									<td class="campos">
										<input name="nombre_alumno" type="text" value="<?php echo $nombre_alumno; ?>" required size="22" autofocus/>
									</td>
									<td class="etiqueta">
										<label for="apellido_alumno">Apellido: </label>
									</td>
									<td class="campos">
										<input name="apellido_alumno" type="text" value="<?php echo $apellido_alumno; ?>" required size="22" />
									</td>
								</tr>
								<tr>
									<td colspan="4">&nbsp;</td>
								</tr>
								<tr>
									<td class="etiqueta">
										<label for="nro_legajo">Nro. Legajo: </label>	
									</td>	
									<td class="campos">
										<input name="nro_legajo" type="text" pattern="[0-9]{4,6}" value="<?php echo $nro_legajo; ?>" maxlength="6" required size="22"/>
									</td>
									<td class="etiqueta">
										<label for="tipodni_alumno">Tipo DNI: </label>
									</td>
									<td class="campos">
										<select id="cTipoDNI" name="tipodni_alumno" size="1">
											<?php
												$consultaTipoDNI=pg_query("select id,nombre FROM tipo_dni");
												while($rowTipoDNI=pg_fetch_array($consultaTipoDNI)){
												if ($tipo_dni_alumno == $rowTipoDNI['id']){
							                        echo "<option value=".$rowTipoDNI['id']." selected>".$rowTipoDNI['nombre']."</option>";
												}else{
													echo "<option value=".$rowTipoDNI['id'].">".$rowTipoDNI['nombre']."</option>";
													}
												}
											?>
										</select>
									</td>
								</tr>
							</table>
			
			</fieldset>
			<fieldset id="tabla" width="100%">
			<legend><FONT face="Cambria" size="4" color="#6E6E6E">Datos Personales</FONT></legend>
				<table align="left" cellpadding="2" cellspacing="2" width="100%">
					
					<tr width="100%">
						<td width="20%" align="right" colspan="1">
							<label for="cNroLegajo">Nro. Legajo: </label>
						</td>
						<td width="80" colspan="7">
							<input id="cNroLegajo" name="nro_legajo" type="text" value="<?php echo $nro_legajo; ?>" maxlength="5" class="required number" size="22"/>
						</td>
					</tr>
					<tr width="100%">
						<td width="20%" align="right" colspan="1">
							<label for="cTipoDNI">Tipo DNI: </label>
						</td>
						<td width="30%" colspan="1">
							<select id="cTipoDNI" name="tipodni_alumno" size="1">
								<?php
									$consultaTipoDNI=pg_query("select * FROM tipo_dni");
									while($rowTipoDNI=pg_fetch_array($consultaTipoDNI)){
									if ($tipo_dni_alumno == $rowTipoDNI['id_tipo_dni']){
				                        echo "<option value=".$rowTipoDNI['id_tipo_dni']." selected>".$rowTipoDNI['nombre_tipo_dni']."</option>";
									}else{
										echo "<option value=".$rowTipoDNI['id_tipo_dni'].">".$rowTipoDNI['nombre_tipo_dni']."</option>";
										}
									}
								?>
							</select>
						</td>
						<td width="20%" align="right" colspan="1">
							<label for="cNumeroDNI">N&uacute;mero DNI: </label>
						</td>
						<td width="30%" colspan="5">
							<?php
								if ($numerodni_alumno == ""){
									echo '<input id="cNumeroDNI" name="numerodni_alumno" type="text" value="'.$numDNI.'" size="22" maxlength="8" class="required number"/>';
								}else{
									echo '<input id="cNumeroDNI" name="numerodni_alumno" type="text" value="'.$numerodni_alumno.'" size="22" maxlength="8" class="required number"/>';
								}
							?>
						</td>
					</tr>
					<tr width="100%">
						<td width="20%" align="right" colspan="1">
							<label for="cFecha">Fecha de Nacimiento: </label>
						</td>
						<td width="30%" colspan="1">
							<input id="fechaNacimiento" name="fechanacimiento_alumno" type="text"  value="<?php echo $fecha_nacimiento_alumno; ?>" placeholder="dd-mm-aaaa" class="required" maxlength="10" size="22"/>
						</td>
						<td width="20%" align="right" colspan="1">
							<label for="LugarNacimiento">Lugar de Nacimiento: </label>
						</td>
						<td width="30%" colspan="5">
							<input id="LugarNacimiento" name="localidad_nacimiento_alumno" type="text"  value="<?php echo $localidad_nacimiento_alumno; ?>" class="required" size="22"/>
						</td>
					</tr>
					<tr width="100%"><td colspan="8" width="100%"><hr size="2" width="100%" align="center"/></td></tr>
					<tr width="100%"><td colspan="8" width="100%"><legend><FONT face="Verdana" size="2.5" color="#6E6E6E">*Domicilio donde vive</FONT></legend></td></tr>
					<tr width="100%">
						<td width="20%" align="right" colspan="1" >
							<label for="cLocalidad">Localidad donde vive: </label>
						</td>
						<td width="20%" colspan="1">
							<input id="cLocalidad" name="localidad_viviendo_alumno" type="text" value="<?php echo $localidad_viviendo_alumno; ?>" class="required" size="22"/>
						</td>
						<td width="10%" align="right" colspan="1">
							<label for="cProvincia">Provincia donde vive: </label>
						</td>
						<td width="20%" colspan="1">
							<input id="cProvincia" name="provincia_viviendo_alumno" type="text" value="<?php echo $provincia_viviendo_alumno; ?>" class="required" size="22"/>
						</td>
						<td width="10%" align="right" colspan="1">
							<label for="cCP">C.P.: </label>
						</td>
						<td width="10%" colspan="3">
							<input id="cCP" name="cp_alumno" type="text" value="<?php echo $cp_alumno; ?>" class="required number" maxlength="4" size="2"/>
						</td>
					</tr>
					<tr width="100%">
						<td width="20%" align="right" colspan="1">
							<label for="cCalle">Calle: </label>
						</td>
						<td width="20%" colspan="1">
							<input id="cCalle" name="calle_alumno" type="text"  class="required" size="22" value="<?php echo $calle_alumno; ?>"/>
						</td>
						<td width="10%" align="right" colspan="1">
							<label for="cNumCalle">N&uacute;mero: </label>
						</td>
						<td width="10%" colspan="1">
							<input id="cNumCalle" name="numerocalle_alumno" type="text" class="required number" size="3" value="<?php echo $numerocalle_alumno; ?>"/>
						</td>
						<td width="10%" align="right" colspan="1">
							<label for="cPiso">Piso: </label>
						</td>
						<td width="10%" colspan="1">
							<input id="cPiso" name="piso_alumno" type="text" class="number" size="4" value="<?php echo $piso_alumno; ?>"/>
						</td>
						<td width="10%" align="right" colspan="1">
							<label for="cDptoe">Dpto: </label>
						</td>
						<td width="10%" colspan="1">
							<input id="cDpto" name="dpto_alumno" type="text" size="2" value="<?php echo $dpto_alumno; ?>"/>
						</td>
					</tr>
					<tr width="100%"><td colspan="8" width="100%"><hr size="2" width="100%" align="center"/></td></tr>
					<tr width="100%">
						<td width="20%" align="right" colspan="1">
							<label for="cFoto">Foto: </label>
						</td>
						<td width="80%" colspan="7">
							<input type="file" name="fotoAlumno"/>
						</td>
					</tr>
				</table>
				</fieldset>
				<fieldset id="tabla" width="100%">
				<legend><FONT face="Cambria" size="4" color="#6E6E6E">Datos Contacto</FONT></legend>
				<table align="center" cellpadding="2" cellspacing="2" width="100%">
					<tr width="100%">
						<td width="15%" align="right">
							<label for="cCaracteristica">Tel&eacute;fono Fijo: </label>
						</td>
						<td width="5%">
							<input id="cCaracteristica" name="caracteristicaF_alumno" type="text" value="<?php echo $caracteristicaF_alumno; ?>" size="3" maxlength="5" class="caracteristica"/>
						</td>
						<td width="25%">
							<input id="cTelefono" name="telefono_alumno" type="text" value="<?php echo $telefono_alumno; ?>" size="13" class="number"/>
						</td>
						<td width="10%" align="right">
							<label for="cCaracteristica">Celular: </label>
						</td>
						<td width="5%">
							<input id="cCaracteristica" name="caracteristicaC_alumno" type="text" value="<?php echo $caracteristicaC_alumno; ?>" size="3" maxlength="5" class="required caracteristica"/>
						</td>
						<td width="40%">
							<input id="cCelular" name="celular_alumno" type="text" value="<?php echo $celular_alumno; ?>" size="13" class="required number"/>
						</td>
					</tr>
					<tr width="100%">
						<td width="10%" colspan="1" align="right">
							<label for="cMail">Mail 1: </label>
						</td>
						<td width="40%" colspan="2">
							<input id="cMail" name="mail_alumno" type="text" size="22" value="<?php echo $mail_alumno; ?>" class="required email"/>
						</td>
						<td width="10%" colspan="1" align="right">
							<label for="cMail">Mail 2: </label>
						</td>
						<td width="40%" colspan="2">
							<input id="cMail2" name="mail_alumno2" type="text" size="22" value="<?php echo $mail_alumno2; ?>" class="email"/>
						</td>
					</tr>
					<tr width="100%">
						<td width="10%" colspan="1" align="right">
							<label for="cFacebook">Facebook: </label>
						</td>
						<td width="20%" colspan="2">
							<input id="cFacebook" name="facebook_alumno" type="text" size="22" placeholder="&iquest;Como te encuentro?" value="<?php echo $facebook_alumno; ?>"/>
						</td>
						<td width="10%" colspan="1" align="right">
							<label for="cTwitter">Twitter: </label>
						</td>
						<td width="40%" colspan="2">
							<input id="cTwitter" name="twitter_alumno" type="text" size="22" value="<?php echo $twitter_alumno; ?>"/>
						</td>
					</tr>
				</table>
				</fieldset>
				<fieldset id="tabla">
				<legend><FONT face="Cambria" size="4" color="#6E6E6E">Datos Laborales</FONT></legend>
				<table align="center" cellpadding="2" cellspacing="2" width="100%">
					<tr width="100%">
						<td width="14%" align="right">
							<label for="cLocalidad">Localidad del Trabajo: </label>
						</td>
						<td width="26%">
							<input id="cLocalidad" name="localidad_trabajo_alumno" type="text" value="<?php echo $localidad_trabajo_alumno; ?>" size="22"/>
						</td>
						<td width="14%" align="right">
							<label for="cProvincia">Provincia del Trabajo: </label>
						</td>
						<td width="26%">
							<input id="cProvincia" name="provincia_trabajo_alumno" type="text" value="<?php echo $provincia_trabajo_alumno; ?>" size="22"/>
						</td>
						<td width="10%" align="right">
							<label for="cCP">C.P.: </label>
						</td>
						<td width="10%">
							<input id="cCP2" name="cp_alumno2" type="text" value="<?php echo $cp_alumno2; ?>" class="number" maxlength="4" size="2"/>
						</td>
					</tr>
					<tr width="100%">
						<td width="14%" colspan="1" align="right">
							<label for="cEmpresaTrabaja">Empresa donde Trabaja: </label>
						</td>
						<td width="86%" colspan="5">
							<input id="cEmpresaTrabaja" name="empresa_trabaja_alumno" type="text" value="<?php echo $empresa_trabaja_alumno; ?>" size="22"/>
						</td>
					</tr>
					<tr width="100%">
						<td width="14%" colspan="1" align="right">
							<label for="cPerfilLaboral">Perfil Laboral: </label>
						</td>
						<td width="86%" colspan="5">
							<textarea id="cPerfilLaboral" name="perfil_laboral_alumno" value="" cols="50" rows="5"><?php echo $perfil_laboral_alumno; ?></textarea>
						</td>
					</tr>
				</table>
				<fieldset id="tabla">
				<legend><FONT face="Cambria" size="4" color="#6E6E6E">Esta Contrase&ntilde;a se le solicitar&aacute; para acceder a sus datos cargados en el formulario actual</FONT></legend>
				<table align="center" cellpadding="2" cellspacing="2" width="100%">
					<tr width="100%">
						<td width="12%" align="right">
							<label for="cPassword">Contrase&ntilde;a: </label>
						</td>
						<td width="88%">
							&nbsp;<input id="cPassword" name="password_alumno" type="password" class="required" value="<?php echo $password_alumno; ?>" size="22"/>
						</td>
					</tr>
				</table>
				</fieldset>
				<br>
				<table align="center" cellpadding="2" cellspacing="2" width="100%">
					<tr width="100%">
						<td width="100%" align="center">
							<input class="submit" type="submit" value="Guardar"/>
							<a href="validarDNI.php"><input type="button" value="Atr&aacute;s"></a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	</fieldset>
</form>
</fieldset>
</body>
</html>