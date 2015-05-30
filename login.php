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
<html lang="en-US">
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<script type='text/javascript' src="jquery-1.11.3.min.js"></script>
	<script type='text/javascript' src="cryptor.js"></script>
	<link rel="stylesheet" href="css/login.css">
	<script>
		// var dataDictionary = [];

		// function setData(dataToPush){
		// 	dataDictionary.push(dataToPush);
		// }

		// function validateData(){

		// 	var mail, pass, loginCheck;
		// 	mail = $('#email').val().toLowerCase();
		// 	pass = $('#password').val();
		// 	loginCheck = mail+'/--/'+pass;

		// 	if($.inArray(loginCheck, dataDictionary) != -1){
		// 		return true;
		// 	}else{
		// 		for (var i = 0; i < dataDictionary.length; i++) {
		// 			vString = dataDictionary[i].split('/--/');

		// 			if (vString[0] == mail){
		// 				alert("La contraseña es incorrecta");
		// 				$('#password').val("");
		// 				$('#password').focus();
		// 				return false;
		// 			}else{
		// 				alert("Los datos ingresados son incorrectos");
		// 				$('#email').val("");
		// 				$('#password').val("");
		// 				$('#email').focus();
		// 				return false;
		// 			}
		// 		}
		// 	}
		// }

		var dataDictionary = [];

		function setData(dataToPush){
			dataDictionary.push(dataToPush);
		}

		function validateData(){

			var mail, pass, loginCheck;
			var exito = 0;
			mail = $('#email').val().toLowerCase();
			pass = $('#password').val();
			loginCheck = mail+'/--/'+pass;

			for(var i = 0; i < dataDictionary.length; i++){
				var vData = dataDictionary[i].split('/--/');
				if(vData[0] == mail){

					if(pass == disencrypt(vData[1])){
						exito = 1;
						break;
					}
				}
			}

			if(exito == 1){
				return true;
			}else{
				for (var i = 0; i < dataDictionary.length; i++) {
					vString = dataDictionary[i].split('/--/');

					if (vString[0] == mail){
						alert("La contraseña es incorrecta");
						$('#password').val("");
						$('#password').focus();
						return false;
					}else{
						alert("Los datos ingresados son incorrectos");
						$('#email').val("");
						$('#password').val("");
						$('#email').focus();
						return false;
					}
				}
			}
		}
	</script>
</head>
<body>
<?php
include_once "conexion.php";
include_once "libreria.php";
	$sql = traerSql('mail,password','usuario');
	while($rowData=pg_fetch_array($sql,NULL,PGSQL_ASSOC)){
		$dataToPass = strtolower($rowData['mail']).'/--/'.$rowData['password'];
		echo "<script>setData('".$dataToPass."')</script>";
	}
include_once "cerrar_conexion.php";
?>
	<div id="login">
		<h2>Login</h2>
		<form action="verificarLogin.php" onsubmit="return validateData();" method="post">
				<table width="100%" align="center">
					<tr>
						<td>
							<label for="email">Usuario:</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="email" id="email" name="usuario" value="" placeholder="E-mail" autofocus required/>
						</td>
					</tr>
					<tr>
						<td>
							<label for="password">Contrase&ntilde;a:</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="password" id="password" name="password" value="" placeholder="Contrase&ntilde;a" required/>
						</td>
					</tr>
					<tr>
						<td>
							<hr width="100%">
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" id="btn_enviar" value="Acceder">
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