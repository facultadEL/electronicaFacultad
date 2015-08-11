<?php

include_once "scripts/cryptor.php";

$cadenaEncriptada = encrypt("Esta es una cadena encriptada",'eof');
echo $cadenaEncriptada;

echo disencrypt($cadenaEncriptada);

?>