<?php
	session_start(); // al volver al index si existe una session, esta sera destruida, existen formas de conservarlas como con un if(session_start()!= NULL). Pero por el momento para el ejemplo no es valido.
 	 	$_SESSION['usuario'] = NULL;
 	 	$_SESSION['password'] = NULL;
	session_destroy(); // Se destruye la session existente de esta forma no permite el duplicado.
?>
<!doctype html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Varela+Round">
	<link rel="stylesheet" href="css/login.css">
</head>
<body>
	<div id="login">
		<h2>Login</h2>
		<form action="verificarLogin.php" method="post">
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
							<input type="button" id="btn_olvpass" value="Olvid&eacute; mi contrase&ntilde;a">
						</td>
					</tr>
				</table>
		</form>
	</div> <!-- end login -->
<p><a href="registrarPasante.php?idPasante=0"><input type="button" id="btn_sincta" value="No tengo cuenta"></a></p>
</body>	
</html>