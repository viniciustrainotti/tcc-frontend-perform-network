<?php
$conn = @mysql_connect('localhost','root','') or die(mysql_error());

mysql_select_db('teste', $conn);
?>

<html>

<head>
<title>Adicionando Parametro</title>
<script type = "text/javascript">
function loginsucessfully(){
	setTimeout("window.location='parameters.php'", 2000);
}
function loginfailed(){
	setTimeout("window.location='parameters.php'", 2000);
}
</script>
</head>

<body>
<?php

$selecao = $_POST['selecao'];
$parametro_variavel = $_POST['parametro_variavel'];
$parametro_valor = $_POST['parametro_valor'];
//$script = $_POST['script'];
//$nome = $_POST['dvnome'];

switch ($selecao) {
    case '1':
	
	//echo $parametro_variavel . " " . $parametro_valor;
	
		$conteudo_teste = "$".$parametro_variavel." = ".$parametro_valor.";";
		
		echo $conteudo_teste;
		
		$sql = mysql_query("INSERT INTO parametros (parametro_variavel, parametro_valor, conteudo) VALUES ('$parametro_variavel', '$parametro_valor', '$conteudo_teste')") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Parametro Adicionado com Sucesso!</center>";
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível adicionar o Parametro!</center>";
			echo "<script>loginfailed()</script>";
		}
		
       break;
        //save article and redirect
    case '2':
	
		$sql = mysql_query("DELETE FROM perfil WHERE nome_perfil ='$perfil';") or die(mysql_error());
		
		$sql1 = mysql_query("DELETE FROM perfil_script WHERE nome_perfil ='$perfil';") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Perfil Excluido com Sucesso!</center>";
			
			$diretorioExcluir = 'C:/wamp/www/slimtest/perfil/' . $perfil . '/';
			
			deleteDirectory($diretorioExcluir);
			
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível Excluido o Perfil!</center>";
			echo "<script>loginfailed()</script>";
		}

        break;
		
	case '3':
	
		$sql = mysql_query("INSERT INTO perfil_script (nome_perfil, nome_script) VALUES ('$perfil', '$script')") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Script Vinculado com Sucesso ao Perfil!</center>";
			
			$diretorio = 'C:/wamp/www/slimtest/perfil/' . $perfil . '/';

			if(is_dir($diretorio)){
				
				echo "aqui tem";
				$arquivo_origem = 'C:/wamp/www/slimtest/uploads/' . $grupo . '/' . $script;
				$arquivo_destino = $diretorio . $script;

				if (copy($arquivo_origem, $arquivo_destino))
				{
					echo "Arquivo copiado com Sucesso.";
				}
				else
				{
					echo "Erro ao copiar arquivo.";
				}
			
			}
			else{
			
				echo "não tem";
			
				mkdir($diretorio, 0777, true);
				
				$arquivo_origem = 'C:/wamp/www/slimtest/uploads/' . $grupo . '/' . $script;
				$arquivo_destino = $diretorio . $script;

				if (copy($arquivo_origem, $arquivo_destino))
				{
					echo "Arquivo copiado com Sucesso.";
				}
				else
				{
					echo "Erro ao copiar arquivo.";
				}
			
			}
			
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível Vincular o Script ao Perfil!</center>";
			echo "<script>loginfailed()</script>";
		}

        break;
	
	case '4':
	
		$sql = mysql_query("DELETE FROM perfil_script WHERE nome_perfil ='$perfil' AND nome_script = '$script';") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Vinculo Excluido com Sucesso!</center>";
			$delFile = 'C:/wamp/www/slimtest/perfil/' . $perfil . '/' .$script;
			echo unlink($delFile);
			
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível Excluido o Vinculo!</center>";
			echo "<script>loginfailed()</script>";
		}

        break;

    default:
        //no action sent
}

mysql_close($conn);

?>
</body>

</html>