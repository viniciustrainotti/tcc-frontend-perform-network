<?php
// Nas versões do PHP anteriores a 4.1.0, $HTTP_POST_FILES deve ser utilizado ao invés
// de $_FILES.

require("dbconnect_system.php");

$nome_arquivo = basename($_FILES['logfile']['name']);

echo $nome_arquivo;

$diretoriofinal = 'C:/wamp/www/slimtest/retorno';

if(is_dir($diretoriofinal)){
	
	$uploaddir = $diretoriofinal . '/';

	//echo $uploaddir;

	$uploadfile = $uploaddir . basename($_FILES['logfile']['name']);

	//$arquivo = basename($_FILES['userfile']['name']);

	echo '<pre>';
	if (move_uploaded_file($_FILES['logfile']['tmp_name'], $uploadfile)) {
	
	echo "Arquivo válido e enviado com sucesso.\n";
		
		$arquivo = $uploadfile;
		$destino = $uploaddir;
		
		//var_dump($arquivo);

		$phar = new PharData($arquivo);
		
		//$phar->open($arquivo);
		if($phar->extractTo($destino, null, true) == TRUE)
		{
			echo 'Arquivo descompactado com sucesso.';
			
			$caminho = dir($destino . "home/pi/resultados/");
			
			//echo 'aqui' . $destino;
			
			while(($arquivo = $caminho->read()) !== false)
			{
				//echo "verificando no banco o servico e os scripts\n\n\n";
				if($arquivo != '..' && $arquivo != '.')
				{
					//echo '<a href='.$destino.$arquivo.'>'.$arquivo.'</a><br />';
					//echo $arquivo;
					$arr[] = $arquivo;
					
				}
			}
			
			//print_r($arr);
			//$caminho->close();
			
			for($i = 0; $i < count($arr); $i++) {
				
				//echo "conte dispositivo" . count($arr) . "valor de i ". $i;
				$destino_servicos = $destino . "home/pi/resultados/" . $arr[$i] . "/";
				
				$caminho = dir($destino_servicos);
				
				while(($arquivo = $caminho->read()) !== false)
				{
					//echo "verificando no banco o servico e os scripts\n\n\n";
					if($arquivo != '..' && $arquivo != '.')
					{
						//echo '<a href='.$destino.$arquivo.'>'.$arquivo.'</a><br />';
						//echo $arquivo;
						$array_servicos[] = $arquivo;
						
					}
				}
				
				for($j = 0; $j < count($array_servicos); $j++) {
				
					//echo "conte servicos" . count($array_servicos) . "valor de j " . $j;
					$destino_scripts = $destino_servicos . $array_servicos[$j] . "/";
					
					//echo $destino_scripts;
					
					$caminho = dir($destino_scripts);
					
					while(($arquivo = $caminho->read()) !== false)
					{
						//echo "verificando no banco o servico e os scripts\n\n\n";
						if($arquivo != '..' && $arquivo != '.')
						{
							//echo '<a href='.$destino.$arquivo.'>'.$arquivo.'</a><br />';
							//echo $arquivo;
							$array_scripts[] = $arquivo;
							//print_r($array_scripts);
							
						}
					}
					
					for($k = 0; $k < count($array_scripts); $k++) {
					
						$destino_log = $destino_scripts . $array_scripts[$k] . "/log";
						
						$arquivo = $destino_log;
						
						//echo "estou monstrando o arquivo de log do caminho " . $destino_log;
						
						//var_dump($arquivo);
						
						$lines = file($arquivo);

						//var_dump($lines);
						
						foreach($lines as $linha){
		
							$linha = trim($linha);
							$valor = explode(' ', $linha);
							//var_dump($valor);
							
							if($valor[0] == '64'){
								
								//print_r($valor);
								list($var, $icmp_seq) = explode("=",$valor[5]);
								list($var, $ttl) = explode("=",$valor[6]);
								list($var, $time) = explode("=",$valor[7]);
								$resultado_array = 1;
								
								//echo "dispositivo ". $arr[$i] . "servico ". $array_servicos[$j] . "icmp " .$icmp_seq . "ttl " . $ttl . " time " .$time . "resultado ". $resultado_array;
								
								$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, num_icmp, num_ttl, num_time, retorno_scripts_testecol, data_hora) VALUES ('$arr[$i]', '$array_servicos[$j]', '$icmp_seq', '$ttl', '$time', '$resultado_array', NOW())";
									
								//echo $sql . "\n";
							
								$resultadoQuery = mysql_query($sql) or die(mysql_error());
								
							
							}else{
							
								$resultado_array = 0;
							
								$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, num_icmp, num_ttl, num_time, retorno_scripts_testecol, data_hora) VALUES ('$arr[$i]', '$array_servicos[$j]', '0', '0', '0', '$resultado_array', NOW())";
								//$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, retorno_scripts_testecol) VALUES ('$arr[$i]', '$array_servicos[$j]','$resultado_array')";
								
								$resultadoQuery = mysql_query($sql) or die(mysql_error());
							
							}
							
						
						}
					
					}
					
					$array_scripts = NULL;
				}

			}

			//print_r($arr);
			$caminho->close();
			
			//print_r($array_servicos);
			//$caminho->close();
			
			//print_r($array_scripts);
			//$caminho->close();
				
		}
		else
		{
			echo 'O Arquivo não pode ser descompactado.';
		}

	} else {
		echo "Possível ataque de upload de arquivo!\n";
	}

	//echo 'Aqui está mais informações de debug:';
	//print_r($_FILES);

	//print "</pre>";

}else{

	mkdir($diretoriofinal, 0777, true);

	$uploaddir = $diretoriofinal . '/';

	//echo $uploaddir;

	$uploadfile = $uploaddir . basename($_FILES['logfile']['name']);

	//$arquivo = basename($_FILES['userfile']['name']);

	//echo '<pre>';
	if (move_uploaded_file($_FILES['logfile']['tmp_name'], $uploadfile)) {
		
		
	echo "Arquivo válido e enviado com sucesso.\n";
		
		$arquivo = $uploadfile;
		$destino = $uploaddir;
		
		//var_dump($arquivo);

		$phar = new PharData($arquivo);
		
		//$phar->open($arquivo);
		if($phar->extractTo($destino, null, true) == TRUE)
		{
			echo 'Arquivo descompactado com sucesso.';
			
			$caminho = dir($destino . "home/pi/resultados/");
			
			//echo 'aqui' . $destino;
			
			while(($arquivo = $caminho->read()) !== false)
			{
				echo "verificando no banco o servico e os scripts\n\n\n";
				if($arquivo != '..' && $arquivo != '.')
				{
					//echo '<a href='.$destino.$arquivo.'>'.$arquivo.'</a><br />';
					//echo $arquivo;
					$arr[] = $arquivo;
					
				}
			}
			
			//print_r($arr);
			//$caminho->close();
			
			for($i = 0; $i < count($arr); $i++) {
				
				//echo "conte dispositivo" . count($arr) . "valor de i ". $i;
				$destino_servicos = $destino . "home/pi/resultados/" . $arr[$i] . "/";
				
				$caminho = dir($destino_servicos);
				
				while(($arquivo = $caminho->read()) !== false)
				{
					//echo "verificando no banco o servico e os scripts\n\n\n";
					if($arquivo != '..' && $arquivo != '.')
					{
						echo '<a href='.$destino.$arquivo.'>'.$arquivo.'</a><br />';
						echo $arquivo;
						$array_servicos[] = $arquivo;
						
					}
				}
				
				for($j = 0; $j < count($array_servicos); $j++) {
				
					//echo "conte servicos" . count($array_servicos) . "valor de j " . $j;
					$destino_scripts = $destino_servicos . $array_servicos[$j] . "/";
					
					//echo $destino_scripts;
					
					$caminho = dir($destino_scripts);
					
					while(($arquivo = $caminho->read()) !== false)
					{
						//echo "verificando no banco o servico e os scripts\n\n\n";
						if($arquivo != '..' && $arquivo != '.')
						{
							//echo '<a href='.$destino.$arquivo.'>'.$arquivo.'</a><br />';
							//echo $arquivo;
							$array_scripts[] = $arquivo;
							//print_r($array_scripts);
							
						}
					}
					
					for($k = 0; $k < count($array_scripts); $k++) {
					
						$destino_log = $destino_scripts . $array_scripts[$k] . "/log";
						
						$arquivo = $destino_log;
						
						//echo "estou monstrando o arquivo de log do caminho " . $destino_log;
						
						//var_dump($arquivo);
						
						$lines = file($arquivo);

						//var_dump($lines);
						
						foreach($lines as $linha){
		
							$linha = trim($linha);
							$valor = explode(' ', $linha);
							var_dump($valor);
							
							if($valor[0] == '64'){
								
								//print_r($valor);
								list($var, $icmp_seq) = explode("=",$valor[5]);
								list($var, $ttl) = explode("=",$valor[6]);
								list($var, $time) = explode("=",$valor[7]);
								$resultado_array = 1;
								
								//echo "dispositivo ". $arr[$i] . "servico ". $array_servicos[$j] . "icmp " .$icmp_seq . "ttl " . $ttl . " time " .$time . "resultado ". $resultado_array;
								
								$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, num_icmp, num_ttl, num_time, retorno_scripts_testecol) VALUES ('$arr[$i]', '$array_servicos[$j]', '$icmp_seq', '$ttl', '$time', '$resultado_array')";
									
								//echo $sql . "\n";
							
								$resultadoQuery = mysql_query($sql) or die(mysql_error());
								
							
							}else{
							
								$resultado_array = 0;
							
								$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, num_icmp, num_ttl, num_time, retorno_scripts_testecol) VALUES ('$arr[$i]', '$array_servicos[$j]', '0', '0', '0', '$resultado_array')";
								//$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, retorno_scripts_testecol) VALUES ('$arr[$i]', '$array_servicos[$j]','$resultado_array')";
								
								$resultadoQuery = mysql_query($sql) or die(mysql_error());
							
							}
							
						
						}
					
					}
					
					$array_scripts = NULL;
				}

			}

			//print_r($arr);
			$caminho->close();
			
			//print_r($array_servicos);
			//$caminho->close();
			
			//print_r($array_scripts);
			//$caminho->close();
				
		}
		else
		{
			echo 'O Arquivo não pode ser descompactado.';
		}

	} else {
		echo "Possível ataque de upload de arquivo!\n";
		
	}

	//echo 'Aqui está mais informações de debug:';
	//print_r($_FILES);

	//print "</pre>";
}

?>