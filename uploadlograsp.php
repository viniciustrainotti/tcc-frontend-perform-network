<?php
// Nas versões do PHP anteriores a 4.1.0, $HTTP_POST_FILES deve ser utilizado ao invés
// de $_FILES.

require("dbconnect_system.php");

$nome_arquivo = basename($_FILES['lograspfile']['name']);

echo $nome_arquivo;

$diretoriofinal = 'C:/wamp/www/slimtest/logs_rasp';

if(is_dir($diretoriofinal)){
	
	$uploaddir = $diretoriofinal . '/';

	//echo $uploaddir;

	$uploadfile = $uploaddir . basename($_FILES['lograspfile']['name']);

	//$arquivo = basename($_FILES['userfile']['name']);

	echo '<pre>';
	if (move_uploaded_file($_FILES['lograspfile']['tmp_name'], $uploadfile)) {
	
		echo "Arquivo válido e enviado com sucesso.\n";

	} else {
		echo "Possível ataque de upload de arquivo!\n";
	}

}else{

	mkdir($diretoriofinal, 0777, true);

	$uploaddir = $diretoriofinal . '/';

	//echo $uploaddir;

	$uploadfile = $uploaddir . basename($_FILES['lograspfile']['name']);

	//$arquivo = basename($_FILES['userfile']['name']);

	//echo '<pre>';
	if (move_uploaded_file($_FILES['lograspfile']['tmp_name'], $uploadfile)) {
			
		echo "Arquivo válido e enviado com sucesso.\n";

	} else {
		echo "Possível ataque de upload de arquivo!\n";
		
	}
	
}

?>