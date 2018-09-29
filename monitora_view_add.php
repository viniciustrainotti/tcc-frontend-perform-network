<?php
require("dbconnect_system.php");
?>

<html>

<head>
<title>Alteracoes do Monitora</title>
<script type = "text/javascript">
function loginsucessfully(){
	setTimeout("window.location='run_monitora.php'", 2000);
}
function loginfailed(){
	setTimeout("window.location='run_monitora.php'", 2000);
}
</script>
</head>

<body>
<?php

$selecao = $_POST['selecao'];
$dispositivo = $_POST['dispositivo'];
$servico = $_POST['servico'];


// echo "selecao " . $selecao;

// echo "dispositivo " . $dispositivo;

// echo "servico " . $servico;

switch ($selecao) {
    case '1':
		
		$query001 = "UPDATE servicos SET download='S', servico_disp = 0 WHERE dispositivo='$dispositivo' AND nome_servico = '$servico'";
										
		$resultadoQuery001 = mysql_query($query001) or die(mysql_error());
		
		$query010 = "UPDATE arquivos_teste SET download='S' WHERE dispositivo='$dispositivo' AND servico = '$servico'";
		
		$resultadoQuery010 = mysql_query($query010) or die(mysql_error());
		
		$query10 = "UPDATE dispositivos SET servicos='0' WHERE pvid='$dispositivo'";
		
		$resultadoQuery10 = mysql_query($query10) or die(mysql_error());

		if ($resultadoQuery10 == TRUE) {
			echo "<center>Parando o Monitoramento!</center>";
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível Para o Monitoramento!</center>";
			echo "<script>loginfailed()</script>";
		}
		
       break;
        //save article and redirect
    case '2':
	
		$sql = mysql_query("DELETE FROM retorno_script_monitoramento_ping WHERE dispositivo ='$dispositivo' AND servico = '$servico';") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Limpado Monitoramento com Sucesso!</center>";
			
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível Limpar o Monitoramento!</center>";
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