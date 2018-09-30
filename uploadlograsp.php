<?php
// Nas versões do PHP anteriores a 4.1.0, $HTTP_POST_FILES deve ser utilizado ao invés
// de $_FILES.

// require("dbconnect_system.php");

function copyr($source, $dest)
{
    // Check for symlinks
    if (is_link($source)) {
        return symlink(readlink($source), $dest);
    }
    
    // Simple copy for a file
    if (is_file($source)) {
        return copy($source, $dest);
    }

    // Make destination directory
    if (!is_dir($dest)) {
        mkdir($dest);
    }

    // Loop through the folder
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }

        // Deep copy directories
        copyr("$source/$entry", "$dest/$entry");
    }

    // Clean up
    $dir->close();
    return true;
}

$nome_arquivo = basename($_FILES['lograspfile']['name']);

$nome_arquivo = trim($nome_arquivo);

$pvid = substr($nome_arquivo, 9, 2);

echo nl2br("pvid " . $pvid . "\n");

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