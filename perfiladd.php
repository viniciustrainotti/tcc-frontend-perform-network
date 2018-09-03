<?php
require("dbconnect_system.php");
?>

<html>

<head>
<title>Adicionando Perfil</title>
<script type = "text/javascript">
function loginsucessfully(){
	setTimeout("window.location='profile.php'", 2000);
}
function loginfailed(){
	setTimeout("window.location='profile.php'", 2000);
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
$perfil = $_POST['perfil'];
$grupo = $_POST['grupo'];
$script = $_POST['script'];
$parametro = $_POST['parametro'];
//$nome = $_POST['dvnome'];

switch ($selecao) {
    case '1':
	
		$sql = mysql_query("INSERT INTO perfil (nome_perfil) VALUES ('$perfil')") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Perfil Adicionado com Sucesso!</center>";
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível adicionar o Perfil!</center>";
			echo "<script>loginfailed()</script>";
		}
		
       break;
        //save article and redirect
    case '2':
	
		$sql = mysql_query("DELETE FROM perfil WHERE nome_perfil ='$perfil';") or die(mysql_error());
		
		$sql1 = mysql_query("DELETE FROM perfil_script_parametro WHERE nome_perfil ='$perfil';") or die(mysql_error());

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
	
		$sql = mysql_query("INSERT INTO perfil_script_parametro (nome_perfil, nome_script, nome_parametro) VALUES ('$perfil', '$script', '$parametro')") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Script e Parametro Vinculado com Sucesso ao Perfil!</center>";
			
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
			echo "<center>Não foi possível Vincular o Script e Parametro ao Perfil!</center>";
			echo "<script>loginfailed()</script>";
		}

        break;
	
	case '4':
	
		$sql = mysql_query("DELETE FROM perfil_script_parametro WHERE nome_perfil ='$perfil' AND nome_script = '$script' AND nome_parametro = '$parametro';") or die(mysql_error());

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