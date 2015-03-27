<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="jquery.mask.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/registroPasante.css">
	<title>Registro de Usuario</title>
	<script>
		function maskDni()
		{
			valDni = $('#nrodni').val();
			switch(valDni.length)
			{
				case 7:
				case 9:
					mascara = "0.000.000";
					break;
				case 8:
				case 10:
					mascara = "00.000.000";
					break;
			}
			$('#nrodni').mask(mascara);
		}
	</script>
</head>
<body>
<?php
$id_Pasante = $_REQUEST['idPasante'];
//echo 'id_Pasante '.$id_Pasante.'<br>';
include_once "conexion.php";
	if ($id_Pasante != 0){
		$sqlPasante = pg_query("SELECT * FROM pasante WHERE id = $id_Pasante");
		$rowPasante = pg_fetch_array($sqlPasante);
			$id_Pasante = $rowPasante['id'];
			$nombre = $rowPasante['nombre'];
			$apellido = $rowPasante['apellido'];
			$nro_legajo = $rowPasante['nro_legajo'];
			$tipodni = $rowPasante['tipodni'];
			$nrodni = $rowPasante['nrodni'];
			$fec_nacimiento = $rowPasante['fec_nacimiento'];
			$loc_nacimiento = $rowPasante['loc_nacimiento'];
			$prov_viviendo = $rowPasante['prov_viviendo'];
			$loc_viviendo = $rowPasante['loc_viviendo'];
			$codpos = $rowPasante['codpos'];
			$calle = $rowPasante['calle'];
			$nrocalle = $rowPasante['nrocalle'];
			$piso = $rowPasante['piso'];
			$dpto = $rowPasante['dpto'];
			$carrera_fk = $rowPasante['carrera_fk'];
			$caracfijo = $rowPasante['caracfijo'];
			$nrofijo = $rowPasante['nrofijo'];
			$caraccel = $rowPasante['caraccel'];
			$nrocelular = $rowPasante['nrocelular'];
			$mail = $rowPasante['mail'];
			$mail2 = $rowPasante['mail2'];
			$facebook = $rowPasante['facebook'];
			$twitter = $rowPasante['twitter'];
			$password = $rowPasante['password'];
			$prov_trabajo = $rowPasante['prov_trabajo'];
			$loc_trabajo = $rowPasante['loc_trabajo'];
			$codpos2 = $rowPasante['codpos2'];
			$empresa_trabaja = $rowPasante['empresa_trabaja'];
			$perfil_laboral = $rowPasante['perfil_laboral'];
	}
?>
<div id="formulario">
<h2>Formulario de Inscripci&oacute;n</h2>
<form class="formNuevoPasante" name="f1" id="form2" action="registrarDatosPasante.php?idPasante=<?php echo $id_Pasante ?>" method="post" enctype="multipart/form-data">
<table align="center" width="100%">
	<tr width="100%">
		<td width="100%">
			<fieldset>
				<legend>Datos Personales</legend>
					<table align="center" width="100%">
						<tr width="100%">
							<td width="10%" align="right">
								<label for="nombre">Nombre: </label>
							</td>
							<td width="30%">
								<input id="nombre" name="nombre" type="text" class="campoText" value="<?php echo $nombre; ?>" required/>
							</td>
							<td width="10%" align="right">
								<label for="apellido">Apellido: </label>
							</td>
							<td width="30%">
								<input id="apellido" name="apellido" type="text" class="campoText" value="<?php echo $apellido; ?>" required/>
							</td>
							<td width="10%" align="right">
								<label for="nro_legajo">N&deg; Legajo: </label>
							</td>
							<td width="10%" colspan="3">
								<input id="nro_legajo" name="nro_legajo" pattern="[0-9]{4,5}" type="text" class="campoNro" value="<?php echo $nro_legajo; ?>" size="4" maxlength="5" required/>
							</td>
						</tr>
						<tr width="100%">
							<td colspan="1" align="right">
								<label for="tipodni">Tipo DNI:</label>
							</td>
							<td colspan="1">
								<select id="tipodni" name="tipodni" size="1">
									<?php
										$consultaTipoDNI=pg_query("SELECT * FROM tipo_dni");
										while($rowTipoDNI=pg_fetch_array($consultaTipoDNI)){
										if ($tipodni == $rowTipoDNI['id']){
					                        echo "<option value=".$rowTipoDNI['id']." selected>".$rowTipoDNI['nombre']."</option>";
										}else{
											echo "<option value=".$rowTipoDNI['id'].">".$rowTipoDNI['nombre']."</option>";
											}
										}
									?>
								</select>
							</td>
							<td colspan="1" align="right">
								<label for="nrodni">N&deg; DNI:</label>
							</td>
							<td colspan="5">
								<input id="nrodni" name="nrodni" type="text" class="campoText" onkeyup="maskDni()" onfocus="this.value = '';" pattern="[0-9]{1,2}+[.]{1}[0-9]{3}+[.]{1}[0-9]{3}" value="<?php echo $nrodni; ?>" maxlength="10" required/>
							</td>
						</tr>
						<tr width="100%">
							<td colspan="1" align="right">
								<label for="fec_nacimiento">Fecha Nac.: </label>
							</td>
							<td colspan="1">
								<input id="fec_nacimiento" name="fec_nacimiento" type="date" class="campoDate"  value="<?php echo $fec_nacimiento; ?>" placeholder="dd/mm/aaaa" maxlength="10" required/>
							</td>
							<td colspan="1" align="right">
								<label for="loc_nacimiento">Lugar Nac.: </label>
							</td>
							<td colspan="5">
								<input id="loc_nacimiento" name="loc_nacimiento" type="text" spellcheck="true" class="campoText" value="<?php echo $loc_nacimiento; ?>" required/>
							</td>
						</tr>
						<tr width="100%">
							<td  width="100%" colspan="8"><hr size="2" width="100%" align="center"/></td>
						</tr>
						<tr width="100%">
							<td  width="100%" colspan="8">
								<legend id="leyenda">*Domicilio donde vive</legend>
							</td>
						</tr>
						<tr width="100%">
							<td colspan="1" align="right">
								<label for="loc_viviendo">Localidad:</label>
							</td>
							<td colspan="1">
								<input id="loc_viviendo" name="loc_viviendo" type="text" spellcheck="true" class="campoText" value="<?php echo $loc_viviendo; ?>" required/>
							</td>
							<td colspan="1" align="right">
								<label for="prov_viviendo">Provincia:</label>
							</td>
							<td colspan="1">
								<input id="prov_viviendo" name="prov_viviendo" type="text" spellcheck="true" class="campoText" value="<?php echo $prov_viviendo; ?>" required/>
							</td>
							<td colspan="1" align="right">
								<label for="codpos">C.P.:</label>
							</td>
							<td colspan="3">
								<input id="codpos" name="codpos" type="text" class="campoNro" pattern="[0-9]{4}" value="<?php echo $codpos; ?>" required maxlength="4" size="4"/>
							</td>
						</tr>
						<tr width="100%">
							<td colspan="1" width="10%" align="right">
								<label for="calle">Calle: </label>
							</td>
							<td colspan="1" width="30%">
								<input id="calle" name="calle" type="text" class="campoText" value="<?php echo $calle; ?>" required/>
							</td>
							<td colspan="1" width="10%" align="right">
								<label for="nrocalle">N&deg;: </label>
							</td>
							<td colspan="1" width="10%">
								<input id="nrocalle" name="nrocalle" pattern="[0-9]{2,6}" type="text" class="campoNro" size="4" value="<?php echo $nrocalle; ?>" required/>
							</td>
							<td colspan="1" width="10%" align="right">
								<label for="piso">Piso: </label>
							</td>
							<td colspan="1" width="10%">
								<input id="piso" name="piso" type="text" pattern="[0-9]{2}" class="campoNro" size="4" value="<?php echo $piso; ?>"/>
							</td>
							<td colspan="1" width="10%" align="right">
								<label for="dpto">Dpto: </label>
							</td>
							<td colspan="1" width="10%">
								<input id="dpto" name="dpto" type="text" size="1" class="campoNro" value="<?php echo $dpto; ?>"/>
							</td>
						</tr>
					</table>
			</fieldset>
			<fieldset>
				<legend>Datos Contacto</legend>
					<table align="center" width="100%">
						<tr width="100%">
							<td width="10%" align="right">
								<label for="caracfijo">Tel&eacute;fono Fijo: </label>
							</td>
							<td width="5%">
								<input id="caracfijo" name="caracfijo" type="text" class="campoNro" pattern="[1-9]{2,4}" placeholder="Sin 0" value="<?php echo $caracfijo; ?>" size="3" maxlength="5"/>
							</td>
							<td width="35%">
								<input id="nrofijo" name="nrofijo" type="text" class="campoTextTel" value="<?php echo $nrofijo; ?>"/>
							</td>
							<td width="10%" align="right">
								<label for="caraccel">Celular: </label>
							</td>
							<td width="5%">
								<input id="caraccel" name="caraccel" type="text" class="campoNro" pattern="[1-9]{2,4}" placeholder="Sin 0" value="<?php echo $caraccel; ?>" size="3" maxlength="5" required/>
							</td>
							<td width="35%">
								<input id="nrocelular" name="nrocelular" type="text" class="campoTextTel" pattern="[0-9]{6,8}" placeholder="Sin 15" value="<?php echo $nrocelular; ?>" required/>
							</td>
						</tr>
						<tr width="100%">
							<td colspan="1" align="right">
								<label for="mail">Mail 1: </label>
							</td>
							<td colspan="2">
								<input id="mail" name="mail" type="email" class="campoText" value="<?php echo $mail; ?>" autocomplete="off" required/>
							</td>
							<td colspan="1" align="right">
								<label for="mail2">Mail 2: </label>
							</td>
							<td colspan="2">
								<input id="mail2" name="mail2" type="email" placeholder="Opcional" class="campoText" value="<?php echo $mail2; ?>"/>
							</td>
						</tr>
						<tr width="100%">
							<td colspan="1" align="right">
								<label for="facebook">Facebook: </label>
							</td>
							<td colspan="2">
								<input id="facebook" name="facebook" type="text" class="campoText" placeholder="&iquest;Como te encuentro?" value="<?php echo $facebook; ?>"/>
							</td>
							<td colspan="1" align="right">
								<label for="twitter">Twitter: </label>
							</td>
							<td colspan="2">
								<input id="twitter" name="twitter" type="text" class="campoText" value="<?php echo $twitter; ?>"/>
							</td>
						</tr>
					</table>
			</fieldset>
			<fieldset>
				<legend>Datos Laborales</legend>
					<table align="center" width="100%">
						<tr width="100%">
							<td width="10%" align="right">
								<label for="loc_trabajo">Localidad:</label>
							</td>
							<td width="30%">
								<input id="loc_trabajo" name="loc_trabajo" type="text" class="campoText" spellcheck="true" value="<?php echo $loc_trabajo; ?>"/>
							</td>
							<td width="10%" align="right">
								<label for="prov_trabajo">Provincia:</label>
							</td>
							<td width="30%">
								<input id="prov_trabajo" name="prov_trabajo" type="text" class="campoText" spellcheck="true" value="<?php echo $prov_trabajo; ?>"/>
							</td>
							<td width="10%" align="right">
								<label for="codpos2">C.P.:</label>
							</td>
							<td width="10%">
								<input id="codpos2" name="codpos2" type="text" class="campoNro" pattern="[0-9]{4}" value="<?php echo $codpos2; ?>" maxlength="4" size="2"/>
							</td>
						</tr>
						<tr width="100%">
							<td colspan="1" align="right">
								<label for="empresa_trabaja">Empresa: </label>
							</td>
							<td colspan="5">
								<input id="empresa_trabaja" name="empresa_trabaja" type="text" class="campoText" value="<?php echo $empresa_trabaja; ?>"/>
							</td>
						</tr>
						<tr width="100%">
							<td colspan="1" align="right">
								<label for="perfil_laboral">Perfil Laboral: </label>
							</td>
							<td colspan="5">
								<textarea id="perfil_laboral" name="perfil_laboral" class="campoArea" value="" spellcheck="true" ><?php echo $perfil_laboral; ?></textarea>
							</td>
						</tr>
					</table>
			</fieldset>
		</td>
	</tr>
</table>
<fieldset>
	<legend>Datos de usuario</legend>
		<table align="center" width="100%">
			<tr width="100%">
				<td width="10%" align="right">
					<label for="password">Contrase&ntilde;a: </label>
				</td>
				<td width="90%">
					<input id="password" name="password" type="password" pattern=".{6,}" title="M&iacute;nimo seis caracteres" class="campoText" value="<?php echo $password; ?>" required/>
				</td>
			</tr>
		</table>
</fieldset>
</div>
<table id="tablaBtn" align="center">
	<tr width="100%">
		<td width="50%" align="right">
			<?php if($id_Pasante != 0){?>
				<a href="verAlumno.php?idAlumno=<?php echo $id_Pasante;?>&titulo_pasante=<?php echo $carrera_fk;?>"><input type="button" id="btn_cancelar" value="Cancelar"></a>
			<?php }else{?>
				<a href="login.php"><input type="button" id="btn_cancelar" value="Cancelar"></a>
			<?php }; ?>
		</td>	
		<td width="50%" align="left">
			<input class="submit" type="submit" value="Guardar"/>
		</td>
	</tr>
</table>
</form>
</body>
</html>