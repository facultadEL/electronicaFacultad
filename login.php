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
		<h2><span class="fontawesome-lock"></span>Login</h2>
		<form action="" method="POST">
			<fieldset>
				<p><label for="email">E-mail</label></p>
				<p><input type="email" id="email" value="" placeholder="E-mail"/></p> <!-- JS because of IE support; better: placeholder="mail@address.com" -->

				<p><label for="password">Contrase&ntilde;a</label></p>
				<p><input type="password" id="password" value="" placeholder="Contrase&ntilde;a"/></p> <!-- JS because of IE support; better: placeholder="password" -->
				<br>
				<p><input type="submit" value="Acceder"></p>
				<p><input type="button" value="Olvid&eacute; mi contrase&ntilde;a"></p>
			</fieldset>
		</form>
	</div> <!-- end login -->
</body>	
</html>