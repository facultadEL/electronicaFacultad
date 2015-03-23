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
		<form action="" method="POST">
				<table width="100%" align="center">
					<tr>
						<td>
							<label for="email">Usuario:</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="email" id="email" value="" placeholder="E-mail"/>
						</td>
					</tr>
					<tr>
						<td>
							<label for="password">Contrase&ntilde;a:</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="password" id="password" value="" placeholder="Contrase&ntilde;a"/>
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
<p><a href="registrarPasante.php"><input type="button" id="btn_sincta" value="No tengo cuenta"></a></p>
</body>	
</html>