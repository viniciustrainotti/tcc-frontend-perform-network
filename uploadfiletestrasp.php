<?php
// Nas versões do PHP anteriores a 4.1.0, $HTTP_POST_FILES deve ser utilizado ao invés
// de $_FILES.

$conn = @mysql_connect('localhost','root','') or die(mysql_error());

mysql_select_db('teste', $conn);

$nome_arquivo = basename($_FILES['logfile']['name']);

echo $nome_arquivo;

//print_r($_FILES);
list($nome_pasta, $data_diretorio) = explode("_", $nome_arquivo);

echo $nome_pasta;

list($data_diretorio1, $tipo) = explode(".", $data_diretorio);

echo $data_diretorio1;

$diretoriofinal = 'C:/wamp/www/slimtest/retorno/' . $data_diretorio1 . '/' . $nome_pasta;

if(is_dir($diretoriofinal)){
	
	$uploaddir = $diretoriofinal . '/';

	echo $uploaddir;

	$uploadfile = $uploaddir . basename($_FILES['logfile']['name']);

	//$arquivo = basename($_FILES['userfile']['name']);

	echo '<pre>';
	if (move_uploaded_file($_FILES['logfile']['tmp_name'], $uploadfile)) {
	
	echo "Arquivo válido e enviado com sucesso.\n";
		
		$arquivo = $uploadfile;
		$destino = $uploaddir;
	
		$zip = new ZipArchive;
		$zip->open($arquivo);
		if($zip->extractTo($destino) == TRUE)
		{
			echo 'Arquivo descompactado com sucesso.';
			
			$caminho = dir($destino);
			
			while(($arquivo = $caminho->read()) !== false)
			{
				echo "verificando no banco o servico e os scripts";
				if($arquivo != '..' && $arquivo != '.')
				{
					echo '<a href='.$destino.$arquivo.'>'.$arquivo.'</a><br />';
					echo $arquivo;
					$arr[] = $arquivo;
					
				}
			}

			for($i = 0; $i < count($arr)-1; ++$i) {
				
				list($disp, $serv, $script_, $grupo) = explode('_', $arr[$i]);
				echo $disp;
				echo $serv;
				echo $script_;
				echo $grupo;
				
				$sql = ("UPDATE servicos_scripts SET sucesso='1' WHERE servico_nome = '$serv' AND script_nome = '$script_.sh' AND dispositivo = '$disp'");
				
				//echo $sql;
				
				$resultadoQuery = mysql_query($sql) or die(mysql_error());
				
				//Lendo o arquivo de destino por posição de array (somente os txt);
				$lines = file($destino.$arr[$i]);
				
				var_dump($lines);
			}
			print_r($arr);
			$caminho->close();		
		}
		else
		{
			echo 'O Arquivo não pode ser descompactado.';
		}
		$zip->close();

	} else {
		echo "Possível ataque de upload de arquivo!\n";
	}

	echo 'Aqui está mais informações de debug:';
	print_r($_FILES);

	print "</pre>";

}else{

	mkdir($diretoriofinal, 0777, true);

	$uploaddir = $diretoriofinal . '/';

	echo $uploaddir;

	$uploadfile = $uploaddir . basename($_FILES['logfile']['name']);

	//$arquivo = basename($_FILES['userfile']['name']);

	echo '<pre>';
	if (move_uploaded_file($_FILES['logfile']['tmp_name'], $uploadfile)) {
		
		echo "Arquivo válido e enviado com sucesso.\n";
		
		$arquivo = $uploadfile;
		$destino = $uploaddir;

		$zip = new ZipArchive;
		$zip->open($arquivo);
		if($zip->extractTo($destino) == TRUE)
		{
			echo 'Arquivo descompactado com sucesso.';
		}
		else
		{
			echo 'O Arquivo não pode ser descompactado.';
		}
		$zip->close();
	} else {
		echo "Possível ataque de upload de arquivo!\n";
	}

	echo 'Aqui está mais informações de debug:';
	print_r($_FILES);

	print "</pre>";
}

?>