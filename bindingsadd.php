<?php
require("dbconnect_system.php");
?>

<html>

<head>
<title>Adicionando Vinculações</title>
<script type = "text/javascript">
function bindings_vinc(){
	setTimeout("window.location='bindings_vinc.php'", 2000);
}
function bindings(){
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
			echo "<script>bindings()</script>";
		} else {
			echo "<center>Não foi possível adicionar o Serviço!</center>";
			echo "<script>bindings()</script>";
		}
		
       break;
        //save article and redirect
    case '2':
	
		$sql = mysql_query("DELETE FROM servicos_tipos WHERE nome_servicos ='$servico';") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Serviço Excluido com Sucesso!</center>";
			echo "<script>bindings()</script>";
		} else {
			echo "<center>Não foi possível Excluido o Serviço!</center>";
			echo "<script>bindings()</script>";
		}

        break;
		
	case '3':
	
		$consulta_parametros = mysql_query("SELECT nome_script FROM perfil_script_parametro WHERE nome_perfil = '$perfil' GROUP BY nome_script") or die(mysql_error());
		
		//echo $consulta_parametros;
		
		while($row = mysql_fetch_assoc($consulta_parametros)){
		
			$nome_script[] = $row['nome_script'];
			
		}
		
		//print_r($nome_script);
		
		$count = count($nome_script);
		
		//echo $count;
		
		for($i = 0; $i < $count; $i++){
		
			$nomes_parametros = "";
			$conteudo_parametros_array = "";

			$parametros = mysql_query("SELECT nome_parametro FROM perfil_script_parametro WHERE nome_perfil = '$perfil' AND nome_script = '$nome_script[$i]'") or die(mysql_error());
			
			while ($row = mysql_fetch_assoc($parametros)) {
				
				$nomes_parametros[] = $row['nome_parametro'];
				
				//echo $arquivo_parametros ." ";
			}

			//print_r($nomes_parametros);
			
			foreach($nomes_parametros as $nome_parametro){
			
				$conteudo_parametros = mysql_query("SELECT conteudo FROM parametros WHERE conteudo = '$nome_parametro'") or die(mysql_error());
			
				while ($row = mysql_fetch_assoc($conteudo_parametros)) {
				
				$conteudo_parametros_array .= $row['conteudo'] . " \n";
				
				}
			
			}
			
			//echo "parametros conteudo " . $conteudo_parametros_array;
			
			//echo "SELECT conteudo FROM scripts WHERE nomescript = '$nome_script[$i]';";
			
			$cont_script = mysql_query("SELECT conteudo FROM scripts WHERE nomescript = '$nome_script[$i]';") or die(mysql_error());
			
			while ($row = mysql_fetch_assoc($cont_script)) {
				
				$conte_script = $row['conteudo'] . " \n";
				
			}
			
			//echo "conteudo script" . $conte_script;
			
			$cabecalho = "# Servico " . $servico . " do Dispositivo " . $dispositivo . " do " . $perfil . " que executara o " . $nome_script[$i] . " \n \n";
			
			$info_source = "source /boot/config.txt    ##repositorio=/home/pi/resultados \n \n";
			
			$rep_pvid = "rep_pvid=$dispositivo\n";
			
			$rep_servicos = "rep_servicos=$servico\n";
			
			$rep_script = "rep_script=$nome_script[$i]\n";
			
			$linha_fixa_1 = 'mkdir -p $repositorio/$rep_pvid/$rep_servicos/$rep_script \n';

			$linha_fixa_2 = 'retorno=$repositorio/$rep_pvid/$rep_servicos/$rep_script/log \n\n';
			
			$cabecalho_parametros = "# Parametros vinculados \n \n";
			
			$conteudo_parametros_array;
			
			$cabecalho_script = "\n# Script \n \n";
			
			$conte_script;
			
			$rodape = "\n# final do arquivo";
			
			$arquivo_final = $cabecalho . $info_source . $rep_pvid . $rep_servicos . $rep_script . $linha_fixa_1 . $linha_fixa_2 . $cabecalho_parametros . $conteudo_parametros_array . $cabecalho_script . $conte_script . $rodape;
			
			// echo $arquivo_final;
			
			$sql_qtde_parametros = mysql_query("SELECT COUNT(*) AS qtde_parametros FROM perfil_script_parametro WHERE nome_perfil = '$perfil' AND nome_script = '$nome_script[$i]';") or die(mysql_error());
			
			while ($row = mysql_fetch_assoc($sql_qtde_parametros)) {
				
				$qtde_parametros = $row['qtde_parametros'];
				
			}
			
			$salvar_arquivo = mysql_query("INSERT INTO arquivos_teste (arquivo_final, servico, perfil, script, qtde_parametros, dispositivo) VALUES ('$arquivo_final', '$servico', '$perfil', '$nome_script[$i]', '$qtde_parametros', '$dispositivo')") or die (mysql_error());
			
			$liberacao_servico = mysql_query("INSERT INTO servicos (nome_servico, perfil, dispositivo) VALUES ('$servico', '$perfil', '$dispositivo')") or die(mysql_error());
		
		}
		echo "Arquivo Vinculado com Sucesso!";
		echo "<script>bindings_vinc()</script>";
	
		//retirado a questao de arquivos e deixado só no WS REST
		/*$sql = mysql_query("INSERT INTO servicos (nome_servico, perfil, dispositivo) VALUES ('$servico', '$perfil', '$dispositivo')") or die(mysql_error());
		
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
*/
        break;
	
	case '4':
	
		$sql = mysql_query("DELETE FROM servicos WHERE nome_servico ='$servico' AND perfil = '$perfil' AND dispositivo = '$dispositivo';") or die(mysql_error());
		
		$sql_deleta_arquivo_db = mysql_query("DELETE FROM arquivos_teste WHERE servico ='$servico' AND perfil = '$perfil' AND dispositivo = '$dispositivo';") or die(mysql_error());

		/*if ($sql == TRUE) {
			echo "<center>Vinculo Excluido com Sucesso!</center>";
			$delFile = 'C:/wamp/www/slimtest/perfil/' . $perfil . '/' .$script;
			echo unlink($delFile);
			
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível Excluido o Vinculo!</center>";
			echo "<script>loginfailed()</script>";
		}*/
		//transferencia para somente utilizar REST do sistema
		//$diretorioExcluir = 'C:/wamp/www/slimtest/servicos/' . $dispositivo . '/' . $servico;
		
		//deleteDirectory($diretorioExcluir);
		
		echo "<center>Vinculo Excluido com Sucesso!</center>";
		echo "<script>bindings_vinc()</script>";

        break;

    default:
        echo "<script>bindings_vinc()</script>";
}

mysql_close($conn);

?>
</body>

</html>