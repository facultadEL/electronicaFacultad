<?php
	session_start(); // al volver al index si existe una session, esta sera destruida, existen formas de conservarlas como con un if(session_start()!= NULL). Pero por el momento para el ejemplo no es valido.

	$usuario = (empty($_SESSION['usuario'])) ? NULL : $_SESSION['usuario'];
	if ($usuario != NULL) {
		$_SESSION['usuario'] = NULL;
 	 	$_SESSION['password'] = NULL;
	}

	session_destroy(); // Se destruye la session existente de esta forma no permite el duplicado.
?>
<!doctype html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<script type='text/javascript' src="jquery-1.11.3.min.js"></script>
	<script type='text/javascript' src="cryptor.js"></script>
	<link rel="stylesheet" href="css/login.css">
	<script defer>
		function validateData(){

			var parametros = {
	            "usuario" : $('#usu_nombre').val(),
	            "password" : $('#usu_password').val()
	    	};

			var pasa;
			$.ajax({
				type: "POST",
				url: "valida_carga.php",
				data: parametros,
				async: false,
				success:  function (response) { //Funcion que ejecuta si todo pasa bien. El response es los datos que manda el otro archivo
					if(response == '1'){
						//alert("Usuario ok");
						$('#form').attr('action','verificar_login.php');
						$('#form').submit();
					}else{
						switch(response){
							case '0':
							case '4':
								//alert("Usuario incorrecto");
								$('#ae_usu').attr('hidden', false);
								$('#usu_nombre').focus();
	                        	break;
							case '2':
								//alert("Pass incorrecto");
								$('#ae_pass').attr('hidden', false);
								$('#usu_password').focus();
	                        	break;
	                        case '3':
	                        	//alert("Usuario deshabilitado");
	                        	$('#usu_nohab').attr('hidden', false);
	                        	$('#usu_nombre').focus();
	                        	break;
	                        case '5':
	                        	//alert("Usuario y pass mal");
	                        	$('#ae_pass_usu').attr('hidden', false);
	                        	$('#usu_nombre').focus();
	                        	break;
	                        default:
	                        	//alert("Comunicarse con mantenimiento");
	                        	$('#error_cod').attr('hidden', false);
	                        	$('#usu_nombre').focus();
	                        	break;
						}
					}
	            },
				error: function (msg) {
					$('#error_cod').attr('hidden', false);
					//alert("No se pudo validar el usuario. Contactarse con el equipo de mantenimiento");
				}
			});
		}

		function controlVacio(){
			if ($.trim($('#usu_nombre').val()) == '') {
				$('#av_usu').attr('hidden', false);
				$('#usu_nombre').focus();
				return false;
			}else{
				if ($.trim($('#usu_password').val()) == '') {
					$('#av_pass').attr('hidden', false);
					$('#usu_password').focus();
					return false;
				}
			}
	    	return true;
		}

		function pulsar(e){
			if(e.keyCode == 13){
				if(!controlVacio('#usu_nombre')) return false;
				if(!controlVacio('#usu_password')) return false;
				e.stopPropagation();
				e.preventDefault();

				validateData();
			}
		}

		function btn_mouse(){
			if(!controlVacio()) return false;
			if(!controlVacio()) return false;

			validateData();
		}

		function ocultar_alertar(){
			//av = Alerta de campo Vacío
			$('#av_usu').attr('hidden', true);
			$('#av_pass').attr('hidden', true);
			$('#av_mail').attr('hidden', true);
			//ae = Alerta de campo Erroneo
			$('#ae_usu').attr('hidden', true);
			$('#ae_pass').attr('hidden', true);
			$('#ae_pass_usu').attr('hidden', true);
			$('#ae_mail').attr('hidden', true);
			//nohab = No Habilitado
			$('#usu_nohab').attr('hidden', true);
			//error de código o de conexión
			$('#error_cod').attr('hidden', true);
			//espera de aprobación
			$('#esp_aprob').attr('hidden', true);
		}

		$(document).ready(function() {
			ocultar_alertar();
		});
	</script>
</head>
<body>
<?php
// include_once "conexion.php";
// include_once "libreria.php";
// 	$sql = traerSql('mail,password','usuario ORDER BY id');
// 	while($rowData=pg_fetch_array($sql,NULL,PGSQL_ASSOC)){
// 		$dataToPass = strtolower($rowData['mail']).'/--/'.$rowData['password'];
// 		echo "<script>setData('".$dataToPass."')</script>";
// 		echo $dataToPass.'<br>';
// 	}
// include_once "cerrar_conexion.php";
?>

<center><div class="alerta" id="av_usu"><strong>Atenci&oacute;n:</strong> debe ingresar su usuario.</div></center>
<center><div class="alerta" id="av_pass"><strong>Atenci&oacute;n:</strong> debe ingresar su contrase&ntilde;a.</div></center>
<center><div class="alerta" id="ae_usu"><strong>Atenci&oacute;n:</strong> el usuario ingresado es incorrecto.</div></center>
<center><div class="alerta" id="ae_pass"><strong>Atenci&oacute;n:</strong> la contrase&ntilde;a ingresada es incorrecta.</div></center>
<center><div class="alerta" id="ae_pass_usu"><strong>Atenci&oacute;n:</strong> los datos ingresados son incorrectos.</div></center>
<center><div class="alerta" id="usu_nohab"><strong>Atenci&oacute;n:</strong> su usuario ha sido deshabilitado.</div></center>
<center><div class="alerta" id="error_cod"><strong>Atenci&oacute;n:</strong> error del sistema. Por favor, comunicarse con la empresa.</div></center>
<center><div class="alerta" id="esp_aprob"><strong>Atenci&oacute;n:</strong> Su solicitud est&aacute; en espera de aprobaci&oacute;n</div></center>

	<div id="login">
		<h2>Login</h2>
		<form action="" id="form" name="login" method="post">
				<table width="100%" align="center">
					<tr>
						<td>
							<label for="email">Usuario:</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="email" id="usu_nombre" name="usuario" value="" placeholder="E-mail" onkeypress="ocultar_alertar();" required autofocus />
						</td>
					</tr>
					<tr>
						<td>
							<label for="password">Contrase&ntilde;a:</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="password" id="usu_password" name="password" value="" placeholder="Contrase&ntilde;a" onkeypress="ocultar_alertar();pulsar(event);" required />
						</td>
					</tr>
					<tr>
						<td>
							<hr width="100%">
						</td>
					</tr>
					<tr>
						<td>
							<input type="button" id="btn_enviar" onclick="btn_mouse();" value="Acceder">
						</td>
					</tr>
					<tr>
						<td>
							<a href="olvidoPassword.php"><input type="button" id="btn_olvpass" value="Olvid&eacute; mi contrase&ntilde;a"></a>
						</td>
					</tr>
				</table>
		</form>
	</div> <!-- end login -->
<p><a href="registrarPasante.php"><input type="button" id="btn_sincta" value="No tengo cuenta"></a></p>
</body>	
</html>