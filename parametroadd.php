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
		
		$sql = mysql_query("DELETE FROM parametros WHERE parametro_variavel = '$parametro_variavel';") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Parametro Excluido com Sucesso!</center>";
			
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível Excluido o Parametro!</center>";
			echo "<script>loginfailed()</script>";
		}

        break;
		
	case '3':
	
		$conteudo_teste = "$".$parametro_variavel." = ".$parametro_valor.";";
	
		$sql = mysql_query("UPDATE parametros SET parametro_valor = '$parametro_valor', conteudo = '$conteudo_teste' WHERE parametro_variavel = '$parametro_variavel';") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Parametro Atualizado com Sucesso!</center>";
			
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível atualizar o Parametro</center>";
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