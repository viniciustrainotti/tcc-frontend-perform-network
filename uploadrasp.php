<?php
// Nas versões do PHP anteriores a 4.1.0, $HTTP_POST_FILES deve ser utilizado ao invés
// de $_FILES.

require("dbconnect_system.php");

$nome_arquivo = basename($_FILES['logfile']['name']);

echo $nome_arquivo;

$diretoriofinal = 'C:/wamp/www/slimtest/retorno/' . $nome_arquivo . '/' . $nome_arquivo;

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
		
		var_dump($arquivo);
		
		$lines = file($arquivo);
				
		var_dump($lines);
		
		foreach($lines as $linha){
		
			$linha = trim($linha);
			$valor = explode(' ', $linha);
			var_dump($valor);
			
			if($valor[0] == '64'){
				
				print_r($valor);
				list($var, $icmp_seq) = explode("=",$valor[4]);
				list($var, $ttl) = explode("=",$valor[5]);
				list($var, $time) = explode("=",$valor[6]);
				$resultado_array = 1;
				
				echo $icmp_seq . $ttl . $time . $resultado_array;
				
				//$sql = "INSERT INTO retorno_scripts_teste (num_icmp, num_ttl, num_time, retorno_scripts_testecol) VALUES ('$icmp_seq', '$ttl', '$time', '$resultado_array')";
				
				//$resultadoQuery = mysql_query($sql) or die(mysql_error());
				
			
			}else{
			
				$resultado_array = 0;
			
				//$sql = "INSERT INTO retorno_scripts_teste (retorno_scripts_testecol) VALUES ('$resultado_array')";
				
				//$resultadoQuery = mysql_query($sql) or die(mysql_error());
			
			}
			
		
		}
	
		/*$zip = new ZipArchive;
		$zip->open($arquivo);
		if($zip->extractTo($destino) == TRUE)*/
		
		$phar = new PharData($arquivo);
		
		//$phar->open($arquivo);
		if($phar->extractTo($destino, null, true) == TRUE)
		{
			echo 'Arquivo descompactado com sucesso.';
			
			$caminho = dir($destino);
			
			while(($arquivo = $caminho->read()) !== false)
			{
				echo "verificando no banco o servico e os scripts\n\n\n";
				//if($arquivo != '..' && $arquivo != '.')
				//{
					echo '<a href='.$destino.$arquivo.'>'.$arquivo.'</a><br />';
					echo $arquivo;
					$arr[] = $arquivo;
					
				//}
			}

			for($i = 0; $i < count($arr)-1; ++$i) {
				
				list($disp, $serv, $script_, $grupo) = explode('_', $arr[$i]);
				echo $disp;
				echo $serv;
				echo $script_;
				echo $grupo;
				
				//$sql = ("UPDATE servicos_scripts SET sucesso='1' WHERE servico_nome = '$serv' AND script_nome = '$script_.sh' AND dispositivo = '$disp'");
				
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