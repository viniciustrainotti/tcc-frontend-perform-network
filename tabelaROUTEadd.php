<?php
require("dbconnect_system.php");
?>

<html>

<head>
<title>Adicionado Tabela Route</title>
<script type = "text/javascript">
function loginsucessfully(){
	setTimeout("window.location='tableROUTE.php'", 5000);
}
function loginfailed(){
	setTimeout("window.location='tableROUTE.php'", 5000);
}
</script>
</head>

<body>
<?php
$selecao = $_POST['selecao'];
$pvid = $_POST['pvid'];
$route = $_POST['route'];

switch ($selecao) {
    case '1':
	
	echo $pvid . " ";
	echo $route;
	
		$sql = mysql_query("INSERT INTO route (pvid, route_conteudo) VALUES ('$pvid', '$route')") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Route Adicionado com Sucesso!</center>";
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível adicionar o Route do dispositivo!</center>";
			echo "<script>loginfailed()</script>";
		}
		
       break;
        //save article and redirect
    case '2':
	
		$sql = mysql_query("UPDATE arp SET arp_conteudo = '$arp' WHERE pvid = '$pvid';") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Route Atualizada com Sucesso!</center>";
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível Atualizar os valores Route!</center>";
			echo "<script>loginfailed()</script>";
		}

        break;
	case '3':
		
		$sql_conteudo_escrito = mysql_query("SELECT arp_conteudo FROM arp WHERE pvid = '$pvid';") or die(mysql_error());
		
		while($row = mysql_fetch_assoc($sql_conteudo_escrito)){
			
			$conteudo_escrito_arp = $row['arp_conteudo'];
		
		}
		
		$sql_conteudo_recebido = mysql_query("SELECT arp_comparacao FROM arp WHERE pvid = '$pvid';") or die(mysql_error());
		
			while($row = mysql_fetch_assoc($sql_conteudo_recebido)){
			
			$conteudo_recebido_arp = $row['arp_comparacao'];
		
		}
		
		if ($conteudo_escrito_arp === $conteudo_recebido_arp) {
			
			echo "escrito " . $conteudo_escrito_arp . " e igual a " . $conteudo_recebido_arp;
			
			$sql_status_arp = mysql_query("UPDATE arp SET arp_status = '1' WHERE pvid = '$pvid';") or die(mysql_error());
			
			//echo "<center>Dispositivo Atualizado DHCP com Sucesso!</center>";
			echo "<script>loginsucessfully()</script>";
		} else {
		
			echo "escrito " . $conteudo_escrito_arp . " e diferente a " . $conteudo_recebido_arp;
			
			$sql_status_arp = mysql_query("UPDATE arp SET arp_status = '0' WHERE pvid = '$pvid';") or die(mysql_error());
			
			//echo "<center>Não foi possível atualizar o dispositivo!</center>";
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