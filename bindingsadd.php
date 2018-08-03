<?php
$conn = @mysql_connect('localhost','root','') or die(mysql_error());

mysql_select_db('teste', $conn);
?>

<html>

<head>
<title>Adicionando Vinculações</title>
<script type = "text/javascript">
function loginsucessfully(){
	setTimeout("window.location='bindings.php'", 2000);
}
function loginfailed(){
	setTimeout("window.location='bindings.php'", 2000);
}
</script>
</head>

<body>
<?php

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

$selecao = $_POST['selecao'];
$dispositivo = $_POST['dispositivo'];
$perfil = $_POST['perfil'];
$servico = $_POST['servico'];
//$nome = $_POST['dvnome'];

switch ($selecao) {
    case '1':
	
		$sql = mysql_query("INSERT INTO servicos_tipos (nome_servicos) VALUES ('$servico')") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Serviço Adicionado com Sucesso!</center>";
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível adicionar o Serviço!</center>";
			echo "<script>loginfailed()</script>";
		}
		
       break;
        //save article and redirect
    case '2':
	
		$sql = mysql_query("DELETE FROM servicos_tipos WHERE nome_servicos ='$servico';") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Serviço Excluido com Sucesso!</center>";
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível Excluido o Serviço!</center>";
			echo "<script>loginfailed()</script>";
		}

        break;
		
	case '3':
	
		$sql = mysql_query("INSERT INTO servicos (nome_servico, perfil, dispositivo) VALUES ('$servico', '$perfil', '$dispositivo')") or die(mysql_error());
		
		if ($sql == TRUE) {
			echo "<center>Serviço Vinculado com Sucesso!</center>";
			
			$diretorio = 'C:/wamp/www/slimtest/servicos/' . $dispositivo . '/' . $servico . '/';

			if(is_dir($diretorio)){
				
				echo "aqui tem";
				
				$sql = mysql_query("SELECT nome_script FROM perfil_script WHERE nome_perfil = '$perfil'") or die(mysql_error());
				
				while($row = mysql_fetch_assoc($sql)){
				
					$nome_script = $row['nome_script'];
					
					$arquivo_origem = 'C:/wamp/www/slimtest/perfil/' . $perfil . '/' . $nome_script;
					$arquivo_destino = $diretorio . $nome_script;

					if (copy($arquivo_origem, $arquivo_destino))
					{
						echo "Arquivo copiado com Sucesso.";			
					}
					else
					{
						echo "Erro ao copiar arquivo.";
					}
				}
				
				$diretorio_ = dir($diretorio);
				
				$zip = new ZipArchive();
				
				if($zip->open($diretorio . $servico . '.zip',ZIPARCHIVE::CREATE) === TRUE){
				
					while(($arquivo = $diretorio_->read()) !== false)
					{
						if($arquivo != '..' && $arquivo != '.')
						{
							echo '<a>'.$diretorio . $arquivo.'</a><br />';
							
							$zip->addFile($diretorio . $arquivo, $arquivo);
							echo "numfiles: " . $zip->numFiles . "\n";
							echo "status:" . $zip->status . "\n";
							
						}
					}
					
					echo "arquivo pode ser criado";
				}
				else{
					
					echo "arquivo não pode ser criado";
				
				}
				
				$zip->close();	
				$diretorio_->close();
				
				echo "passou";
			
			}
			else{
			
				echo "não tem";
			
				mkdir($diretorio, 0777, true);
				
				$sql = mysql_query("SELECT nome_script FROM perfil_script WHERE nome_perfil = '$perfil'") or die(mysql_error());
				
				while($row = mysql_fetch_assoc($sql)){
				
					$nome_script = $row['nome_script'];
					
					$arquivo_origem = 'C:/wamp/www/slimtest/perfil/' . $perfil . '/' . $nome_script;
					$arquivo_destino = $diretorio . $nome_script;

					if (copy($arquivo_origem, $arquivo_destino))
					{
						echo "Arquivo copiado com Sucesso.";
					}
					else
					{
						echo "Erro ao copiar arquivo.";
					}
				}
				
				$diretorio_ = dir($diretorio);
				
					$zip = new ZipArchive();
					
					if($zip->open($diretorio . $servico . '.zip',ZIPARCHIVE::CREATE) === TRUE){
					
						while(($arquivo = $diretorio_->read()) !== false)
						{
							if($arquivo != '..' && $arquivo != '.')
							{
								echo '<a>'.$diretorio . $arquivo.'</a><br />';
								
								$zip->addFile($diretorio . $arquivo, $arquivo);
								echo "numfiles: " . $zip->numFiles . "\n";
								echo "status:" . $zip->status . "\n";
								
							}
						}
						
						echo "arquivo pode ser criado";
					}
					else{
						
						echo "arquivo não pode ser criado";
					
					}
					
					$zip->close();	
					$diretorio_->close();
					
					echo "passou";
			}
			
			echo "<script>loginsucessfully()</script>";
			
		} else {
			echo "<center>Não foi possível Vincular o Script ao Perfil!</center>";
			echo "<script>loginfailed()</script>";
		}

        break;
	
	case '4':
	
		$sql = mysql_query("DELETE FROM servicos WHERE nome_servico ='$servico' AND perfil = '$perfil' AND dispositivo = '$dispositivo';") or die(mysql_error());

		/*if ($sql == TRUE) {
			echo "<center>Vinculo Excluido com Sucesso!</center>";
			$delFile = 'C:/wamp/www/slimtest/perfil/' . $perfil . '/' .$script;
			echo unlink($delFile);
			
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível Excluido o Vinculo!</center>";
			echo "<script>loginfailed()</script>";
		}*/
		
		$diretorioExcluir = 'C:/wamp/www/slimtest/servicos/' . $dispositivo . '/' . $servico;
		
		deleteDirectory($diretorioExcluir);
		
		echo "<center>Vinculo Excluido com Sucesso!</center>";
		echo "<script>loginsucessfully()</script>";

        break;

    default:
        echo "<script>loginsucessfully()</script>";
}

mysql_close($conn);

?>
</body>

</html>