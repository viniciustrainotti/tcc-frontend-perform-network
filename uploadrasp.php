<?php
// Nas versões do PHP anteriores a 4.1.0, $HTTP_POST_FILES deve ser utilizado ao invés
// de $_FILES.

function ping_var($line, $time, $ms){

//64 bytes from 8.8.8.8: icmp_seq=1 ttl=120 time=9.17 ms

//$line = '64 bytes from 8.8.8.8: icmp_seq=1 ttl=120 time=9.17 ms';

//devido ao strpos ser a primeira aparição da string preciso contar a mais o tamanho dela ou seja na $line a string 'time=' está na posicao 42 e o tamanho dela é 5;
$mystring = $line;

$findme = $time;
$legthTime = strlen($time);
$pos = $legthTime + strpos($mystring, $findme);

$mystring0 = $line;

$findme0 = $ms;
$pos0 = strpos($mystring0, $findme0);

$posfinal = $pos0 - $pos;

$rest = substr($mystring, $pos, $posfinal);

return $rest;

}

function no_response($line, $time, $ms){

$mystring = $line;

$findme = $time;
$legthTime = strlen($time);
$pos = $legthTime + strpos($mystring, $findme);

$pos0 = $ms;

$posfinal = $pos0 - $pos;

$rest = substr($mystring, $pos, $posfinal);

return $rest;

}

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}	

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
				$copia_de_arquivo_bkp = $destino_servicos;
				
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
						
						echo "estou monstrando o arquivo de log do caminho " . $destino_log;
						
						$sql_grupo_script = mysql_query("SELECT gruposcript FROM scripts WHERE nomescript = '$array_scripts[$k]';");
						
						while($row = mysql_fetch_assoc($sql_grupo_script)){
						
							$grupo_script = $row['gruposcript'];
							
						}
						
						//echo $grupo_script;
						
						//var_dump($arquivo);
						
						$lines = file($arquivo);

						//var_dump($lines);
													
						switch ($grupo_script){
						
							case "PING":
							
								foreach($lines as $linha){
						
									//variação para scripts de PING
									$linha = trim($linha);
									$valor = explode(' ', $linha);
									//var_dump($valor);
									//ping
									if($valor[0] == '64'){
										
										//print_r($valor);
										list($var, $icmp_seq) = explode("=",$valor[5]);
										list($var, $ttl) = explode("=",$valor[6]);
										list($var, $time) = explode("=",$valor[7]);
										$resultado_array = 1;
										
										//echo "dispositivo ". $arr[$i] . "servico ". $array_servicos[$j] . "icmp " .$icmp_seq . "ttl " . $ttl . " time " .$time . "resultado ". $resultado_array;
										
										$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, nome_script, num_icmp, num_ttl, num_time, retorno_scripts_testecol, data_hora) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', '$icmp_seq', '$ttl', '$time', '$resultado_array', NOW())";
											
										echo $sql . "\n";
									
										$resultadoQuery = mysql_query($sql) or die(mysql_error());
										
									
									}else{
									
										$resultado_array = 0;
									
										$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, nome_script, num_icmp, num_ttl, num_time, retorno_scripts_testecol, data_hora) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', '0', '0', '0', '$resultado_array', NOW())";
										//$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, retorno_scripts_testecol) VALUES ('$arr[$i]', '$array_servicos[$j]','$resultado_array')";
										
										$resultadoQuery = mysql_query($sql) or die(mysql_error());
									
									}
								}
								
								break;
							
							case "DNS":
							
								$linha_concatenada_dns = "";
								
								foreach($lines as $line){
								
									$linha_concatenada_dns .= $line . "\n";
								
								}
								
								echo $linha_concatenada_dns;
								
								$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, nome_script, conteudo_dns, data_hora) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', '$linha_concatenada_dns', NOW())";
											
								echo $sql . "\n";
							
								$resultadoQuery = mysql_query($sql) or die(mysql_error());
								
								break;
								
							case "IPERF":							
								
								foreach($lines as $line){
								
									$line = trim($line);
									$valor = explode(' ', $line);
									//var_dump($valor);
									
									if($valor[2] == '4]' && $valor[3] == ''){
										
										//print_r($valor);
										list($var, $second) = explode("-",$valor[5]);
										
										//echo $second . "teste";
										//echo strlen($valor[5]);
										
										if(strlen($valor[5]) == 10){
										
											if($valor[31] == 'sender' || $valor[32] == 'receiver'){
											
											//echo "entrou no sender ou receiver";
											
												if($valor[31] == 'sender'){
												
													//echo "entrou no sender";
													
													$transfer = $valor[10];
												
													$bandwidth = $valor[13];
													
													$retr = $valor[18];
													
													$cwnd = $valor[31];
													
													$sql = "INSERT INTO retorno_scripts_iperf (pvid_dispositivo, num_servico, nome_script, data_hora, second, transfer, bandwidth, retro, cwnd) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', NOW(), '$second', '$transfer', '$bandwidth', '$retr', '$cwnd')";
														
													//echo $sql . "\n";
												
													$resultadoQuery = mysql_query($sql) or die(mysql_error());
												
												}else{
												
													//echo "entrou no receiver";
													
													$transfer = $valor[10];
												
													$bandwidth = $valor[13];
													
													$retr = 0;
													
													$cwnd = $valor[32];
													
													$sql = "INSERT INTO retorno_scripts_iperf (pvid_dispositivo, num_servico, nome_script, data_hora, second, transfer, bandwidth, retro, cwnd) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', NOW(), '$second', '$transfer', '$bandwidth', '$retr', '$cwnd')";
														
													//echo $sql . "\n";
												
													$resultadoQuery = mysql_query($sql) or die(mysql_error());
												
												}
												
											}else{
											
												//echo "entrou no 10";
												 
												$transfer = $valor[9];
												
												$bandwidth = $valor[12];
												
												$retr = $valor[17];
												
												$cwnd = $valor[20];
												
												$sql = "INSERT INTO retorno_scripts_iperf (pvid_dispositivo, num_servico, nome_script, data_hora, second, transfer, bandwidth, retro, cwnd) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', NOW(), '$second', '$transfer', '$bandwidth', '$retr', '$cwnd')";
													
												//echo $sql . "\n";
											
												$resultadoQuery = mysql_query($sql) or die(mysql_error());
											
											}
										
										}else{
										
											//echo "entrou no 9";
											
											$transfer = $valor[10];
										
											$bandwidth = $valor[13];
											
											$retr = $valor[18];
											
											$cwnd = $valor[21];
											
											$sql = "INSERT INTO retorno_scripts_iperf (pvid_dispositivo, num_servico, nome_script, data_hora, second, transfer, bandwidth, retro, cwnd) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', NOW(), '$second', '$transfer', '$bandwidth', '$retr', '$cwnd')";
												
											//echo $sql . "\n";
										
											$resultadoQuery = mysql_query($sql) or die(mysql_error());
										
										}
										
									}else{
									
										//echo "leu qualquer outra coisa" . $line;
									
									}
								}
								
								break;
								
							case "MONITORAMENTO":	
							
								$qtdeDeLinhas = count($lines) - 5;
							
								// echo "tudo isso de linhas AQUIIIi? ". $qtdeDeLinhas;
								
									for($indiceLinha = 1; $indiceLinha <= $qtdeDeLinhas; $indiceLinha++){
									
										$linha = trim($lines[$indiceLinha]);
										
										// echo nl2br("\n\n" . $linha); 
										
										$valor64 = substr($linha, 0, 2);
										
										if($valor64 == '64'){
											
											$time = trim(ping_var($linha, 'time=', 'ms'));
											
											$icmp = trim(ping_var($linha, 'icmp_seq=', 'ttl'));
											
											$ttl = trim(ping_var($linha, 'ttl=', 'time'));
											
											//echo "dispositivo ". $arr[$i] . "servico ". $array_servicos[$j] . "icmp " .$icmp_seq . "ttl " . $ttl . " time " .$time . "resultado ". $resultado_array;
											
											$sql = "INSERT INTO retorno_script_monitoramento_ping (dispositivo, servico, script, valor, date) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', '$time', NOW())";
												
											// echo $sql . "\n";
										
											$resultadoQuery = mysql_query($sql) or die(mysql_error());
											
											$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, nome_script, num_icmp, num_ttl, num_time, data_hora) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', '$icmp', '$ttl', '$time', NOW())";
											
											echo $sql . "\n";
										
											$resultadoQuery = mysql_query($sql) or die(mysql_error());
										
										}elseif($valor64 == 'no'){
										
											$time = '0';
											$ttl = '0';
											
											$icmp_seq = 'icmp_seq=';
											
											$ms = strlen($lines[$indiceLinha]);

											$no_response_icmp = no_response($linha, $icmp_seq, $ms);

											$no_response_icmp = trim($no_response_icmp);
										
											$sql = "INSERT INTO retorno_script_monitoramento_ping (dispositivo, servico, script, valor, date) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', '$time', NOW())";
											//$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, retorno_scripts_testecol) VALUES ('$arr[$i]', '$array_servicos[$j]','$resultado_array')";
											
											$resultadoQuery = mysql_query($sql) or die(mysql_error());
											
											$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, nome_script, num_icmp, num_ttl, num_time, data_hora) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', '$no_response_icmp', '$ttl', '$time', NOW())";
											
											echo $sql . "\n";
										
											$resultadoQuery = mysql_query($sql) or die(mysql_error());
										
										}
									
									}
									
									$query001 = "UPDATE servicos SET download='N', servico_disp = 1 WHERE dispositivo='$arr[$i]' AND nome_servico = '99'";
										
									$resultadoQuery001 = mysql_query($query001) or die(mysql_error());
									
									$query010 = "UPDATE arquivos_teste SET download='N' WHERE dispositivo='$arr[$i]' AND servico = '99'";
									
									$resultadoQuery010 = mysql_query($query010) or die(mysql_error());
									
									$query10 = "UPDATE dispositivos SET servicos='1' WHERE pvid='$arr[$i]'";
									
									$resultadoQuery10 = mysql_query($query10) or die(mysql_error());
										
								break;
							
							default:
						
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

		
	//mover arquivos para pasta de bkps
	
	echo $copia_de_arquivo_bkp;
	
	/*
		O certo será para cada interação de leitura do script fazer o processo de copia e exclusão do diretorio
		por enquanto essa função bastará para uma RASPBERRY
	*/
	
	copyr($uploaddir . "home", $uploaddir . "bkp_home");
	
	$diretorioExcluir = $uploaddir . "home";
			
	deleteDirectory($diretorioExcluir);
	
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
						
						echo "estou monstrando o arquivo de log do caminho " . $destino_log;
						
						$sql_grupo_script = mysql_query("SELECT gruposcript FROM scripts WHERE nomescript = '$array_scripts[$k]';");
						
						while($row = mysql_fetch_assoc($sql_grupo_script)){
						
							$grupo_script = $row['gruposcript'];
							
						}
						
						//echo $grupo_script;
						
						//var_dump($arquivo);
						
						$lines = file($arquivo);

						//var_dump($lines);
													
						switch ($grupo_script){
						
							case "PING":
							
								foreach($lines as $linha){
						
									//variação para scripts de PING
									$linha = trim($linha);
									$valor = explode(' ', $linha);
									//var_dump($valor);
									//ping
									if($valor[0] == '64'){
										
										//print_r($valor);
										list($var, $icmp_seq) = explode("=",$valor[5]);
										list($var, $ttl) = explode("=",$valor[6]);
										list($var, $time) = explode("=",$valor[7]);
										$resultado_array = 1;
										
										//echo "dispositivo ". $arr[$i] . "servico ". $array_servicos[$j] . "icmp " .$icmp_seq . "ttl " . $ttl . " time " .$time . "resultado ". $resultado_array;
										
										$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, nome_script, num_icmp, num_ttl, num_time, retorno_scripts_testecol, data_hora) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', '$icmp_seq', '$ttl', '$time', '$resultado_array', NOW())";
											
										echo $sql . "\n";
									
										$resultadoQuery = mysql_query($sql) or die(mysql_error());
										
									
									}else{
									
										$resultado_array = 0;
									
										$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, nome_script, num_icmp, num_ttl, num_time, retorno_scripts_testecol, data_hora) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', '0', '0', '0', '$resultado_array', NOW())";
										//$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, retorno_scripts_testecol) VALUES ('$arr[$i]', '$array_servicos[$j]','$resultado_array')";
										
										$resultadoQuery = mysql_query($sql) or die(mysql_error());
									
									}
								}
								
								break;
							
							case "DNS":
							
								$linha_concatenada_dns = "";
								
								foreach($lines as $line){
								
									$linha_concatenada_dns .= $line . "\n";
								
								}
								
								echo $linha_concatenada_dns;
								
								$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, nome_script, conteudo_dns, data_hora) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', '$linha_concatenada_dns', NOW())";
											
								echo $sql . "\n";
							
								$resultadoQuery = mysql_query($sql) or die(mysql_error());
								
								break;
								
							case "IPERF":							
								
								foreach($lines as $line){
								
									$line = trim($line);
									$valor = explode(' ', $line);
									//var_dump($valor);
									
									if($valor[2] == '4]' && $valor[3] == ''){
										
										//print_r($valor);
										list($var, $second) = explode("-",$valor[5]);
										
										//echo $second . "teste";
										//echo strlen($valor[5]);
										
										if(strlen($valor[5]) == 10){
										
											if($valor[31] == 'sender' || $valor[32] == 'receiver'){
											
											//echo "entrou no sender ou receiver";
											
												if($valor[31] == 'sender'){
												
													//echo "entrou no sender";
													
													$transfer = $valor[10];
												
													$bandwidth = $valor[13];
													
													$retr = $valor[18];
													
													$cwnd = $valor[31];
													
													$sql = "INSERT INTO retorno_scripts_iperf (pvid_dispositivo, num_servico, nome_script, data_hora, second, transfer, bandwidth, retro, cwnd) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', NOW(), '$second', '$transfer', '$bandwidth', '$retr', '$cwnd')";
														
													//echo $sql . "\n";
												
													$resultadoQuery = mysql_query($sql) or die(mysql_error());
												
												}else{
												
													//echo "entrou no receiver";
													
													$transfer = $valor[10];
												
													$bandwidth = $valor[13];
													
													$retr = 0;
													
													$cwnd = $valor[32];
													
													$sql = "INSERT INTO retorno_scripts_iperf (pvid_dispositivo, num_servico, nome_script, data_hora, second, transfer, bandwidth, retro, cwnd) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', NOW(), '$second', '$transfer', '$bandwidth', '$retr', '$cwnd')";
														
													//echo $sql . "\n";
												
													$resultadoQuery = mysql_query($sql) or die(mysql_error());
												
												}
												
											}else{
											
												//echo "entrou no 10";
												 
												$transfer = $valor[9];
												
												$bandwidth = $valor[12];
												
												$retr = $valor[17];
												
												$cwnd = $valor[20];
												
												$sql = "INSERT INTO retorno_scripts_iperf (pvid_dispositivo, num_servico, nome_script, data_hora, second, transfer, bandwidth, retro, cwnd) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', NOW(), '$second', '$transfer', '$bandwidth', '$retr', '$cwnd')";
													
												//echo $sql . "\n";
											
												$resultadoQuery = mysql_query($sql) or die(mysql_error());
											
											}
										
										}else{
										
											//echo "entrou no 9";
											
											$transfer = $valor[10];
										
											$bandwidth = $valor[13];
											
											$retr = $valor[18];
											
											$cwnd = $valor[21];
											
											$sql = "INSERT INTO retorno_scripts_iperf (pvid_dispositivo, num_servico, nome_script, data_hora, second, transfer, bandwidth, retro, cwnd) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', NOW(), '$second', '$transfer', '$bandwidth', '$retr', '$cwnd')";
												
											//echo $sql . "\n";
										
											$resultadoQuery = mysql_query($sql) or die(mysql_error());
										
										}
										
									}else{
									
										//echo "leu qualquer outra coisa" . $line;
									
									}
								}
								
								break;
								
							case "MONITORAMENTO":	
							
								$qtdeDeLinhas = count($lines) - 5;
							
								// echo "tudo isso de linhas? ". $qtdeDeLinhas;
								
									for($indiceLinha = 1; $indiceLinha <= $qtdeDeLinhas; $indiceLinha++){
									
										$linha = trim($lines[$indiceLinha]);
										
										// echo nl2br("\n\n" . $linha); 
										
										$valor64 = substr($linha, 0, 2);
										
										if($valor64 == '64'){
											
											$time = trim(ping_var($linha, 'time=', 'ms'));
											
											//echo "dispositivo ". $arr[$i] . "servico ". $array_servicos[$j] . "icmp " .$icmp_seq . "ttl " . $ttl . " time " .$time . "resultado ". $resultado_array;
											
											$sql = "INSERT INTO retorno_script_monitoramento_ping (dispositivo, servico, script, valor, date) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', '$time', NOW())";
												
											// echo $sql . "\n";
										
											$resultadoQuery = mysql_query($sql) or die(mysql_error());
										
										}elseif($valor64 == 'no'){
											
											$time = '0';
										
											$sql = "INSERT INTO retorno_script_monitoramento_ping (dispositivo, servico, script, valor, date) VALUES ('$arr[$i]', '$array_servicos[$j]', '$array_scripts[$k]', '$time', NOW())";
											//$sql = "INSERT INTO retorno_scripts_teste (pvid_dispositivo, num_servico, retorno_scripts_testecol) VALUES ('$arr[$i]', '$array_servicos[$j]','$resultado_array')";
											
											$resultadoQuery = mysql_query($sql) or die(mysql_error());
										
										}
									
									}
									
									$query001 = "UPDATE servicos SET download='N', servico_disp = 1 WHERE dispositivo='$arr[$i]' AND nome_servico = '99'";
										
									$resultadoQuery001 = mysql_query($query001) or die(mysql_error());
									
									$query010 = "UPDATE arquivos_teste SET download='N' WHERE dispositivo='$arr[$i]' AND servico = '99'";
									
									$resultadoQuery010 = mysql_query($query010) or die(mysql_error());
									
									$query10 = "UPDATE dispositivos SET servicos='1' WHERE pvid='$arr[$i]'";
									
									$resultadoQuery10 = mysql_query($query10) or die(mysql_error());
								
								break;	
							
							default:
						
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

	echo $copia_de_arquivo_bkp;
	
	/*
		O certo será para cada interação de leitura do script fazer o processo de copia e exclusão do diretorio
		por enquanto essa função bastará para uma RASPBERRY
	*/
	
	copyr($uploaddir . "home", $uploaddir . "bkp_home");
	
	$diretorioExcluir = $uploaddir . "home";
			
	deleteDirectory($diretorioExcluir);
	
	//echo 'Aqui está mais informações de debug:';
	//print_r($_FILES);

	//print "</pre>";
}

?>