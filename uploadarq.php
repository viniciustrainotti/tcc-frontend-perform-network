<?php
// Nas versões do PHP anteriores a 4.1.0, $HTTP_POST_FILES deve ser utilizado ao invés
// de $_FILES.

$conn = @mysql_connect('localhost','root','') or die(mysql_error());

mysql_select_db('teste', $conn);

$selecao = $_POST['selecao'];
$grupo = $_POST['grupo'];
$script = $_POST['script'];

//echo $script;
//echo $selecao;

switch ($selecao) {
    case '1':
	
		echo $grupo;

		$uploaddir = 'C:/wamp/www/slimtest/uploads/' . $grupo . '/';

		echo $uploaddir;
		
		$conteudo = file_get_contents($_FILES['userfile']['tmp_name']);
		
		echo $conteudo;

		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
		
		$arquivo = basename($_FILES['userfile']['name']);

		echo '<pre>';
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
			//$sql = mysql_query("INSERT INTO scripts (nomescript, gruposcript) VALUES ('$arquivo', '$grupo')") or die(mysql_error());
			
			$sql = mysql_query("SELECT * FROM scripts WHERE nomescript = '$arquivo' AND gruposcript = '$grupo'") or die(mysql_error());
			
			$row = mysql_num_rows($sql);
			
			if($row > 0){
				echo '<a>'.$arquivo.'</a><br />';
			
			}else{
				$sql = mysql_query("INSERT INTO scripts (nomescript, conteudo, gruposcript) VALUES ('$arquivo', '$conteudo', '$grupo')") or die(mysql_error());
			}
			
			echo "Arquivo válido e enviado com sucesso.\n";
		} else {
			echo "Possível ataque de upload de arquivo!\n";
		}

		echo 'Aqui está mais informações de debug:';
		print_r($_FILES);

		print "</pre>";

		header("Location: scripts.php");
        break;

        //save article and redirect
    case '2':
	
		//echo $grupo;
		
		//$resultado = fopen('http://localhost/slimtest/index.php/download/' . $grupo . '/' . $script, "r");
		//$resultado = file_get_contents('http://localhost/slimtest/index.php/download/' . $grupo . '/' . $script);
		//echo $resultado;
		
		$resultado = file_get_contents('http://localhost/slimtest/index.php/download/' . $grupo . '/' . $script);
		
		$file = 'C:/wamp/www/slimtest/uploads/' . $grupo . '/' . $script;
		header('Content-Disposition: attachment; filename="'.basename($file).'"');
		header("Content-Type: application/octet-stream");
		header("Content-Length: " . filesize($file));
		//echo $file;
		readfile($file);
		
        break;

    case '3':
        
		echo $script;
		
		$sql = mysql_query("DELETE FROM scripts WHERE nomescript = '$script'") or die(mysql_error());
		
		$delFile = 'C:/wamp/www/slimtest/uploads/' . $grupo . '/' .$script;
		echo unlink($delFile);
		
		header("Location: scripts.php");
		
        break;

    default:
        //no action sent
}

?>