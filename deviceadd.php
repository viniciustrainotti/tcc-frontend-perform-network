<?php
require("dbconnect_system.php");
?>

<html>

<head>
<title>Adicionando Dispositivo</title>
<script type = "text/javascript">
function loginsucessfully(){
	setTimeout("window.location='index.php'", 2000);
}
function loginfailed(){
	setTimeout("window.location='index.php'", 2000);
}
</script>
</head>

<body>
<?php

$selecao = $_POST['selecao'];
$pvid = $_POST['dvpvid'];
$user = $_POST['dvuser'];
$dvsenha = $_POST['dvsenha'];
$nome = $_POST['dvnome'];
$dvdhcpip = $_POST['dvdhcpip'];
$dvdhcpmask = $_POST['dvdhcpmask'];
$dvdhcpgateway = $_POST['dvdhcpgateway'];
$dvdhcpdns = $_POST['dvdhcpdns'];

switch ($selecao) {
    case '1':
	
		$sql = mysql_query("INSERT INTO dispositivos (pvid, user, senha, nome, DHCP_ip, DHCP_mascara, DHCP_gateway, DHCP_dns) VALUES ('$pvid', '$user', '$dvsenha', '$nome', '$dvdhcpip', '$dvdhcpmask', '$dvdhcpgateway', '$dvdhcpdns')") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Dispositivo Adicionado com Sucesso!</center>";
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível adicionar o dispositivo!</center>";
			echo "<script>loginfailed()</script>";
		}
		
       break;
        //save article and redirect
    case '2':

		$sql = mysql_query("DELETE FROM dispositivos WHERE pvid ='$pvid';") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Dispositivo Excluido com Sucesso!</center>";
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível Excluido o dispositivo!</center>";
			echo "<script>loginfailed()</script>";
		}

        break;
	case '3':
		
		/*echo $dvdhcpip . " ";
		echo $dvdhcpmask . " ";
		echo $dvdhcpgateway . " ";
		echo $dvdhcpdns . " ";*/
		
		if(empty($dvdhcpip)){
			
			$sql_ip = mysql_query("SELECT DHCP_ip FROM dispositivos WHERE pvid = '$pvid'");
			
			while($row = mysql_fetch_assoc($sql_ip)){
				
				$dvdhcpip = $row['DHCP_ip'];
			
			}
		
		}
		
		if(empty($dvdhcpmask)){
		
			$sql_mask = mysql_query("SELECT DHCP_mascara FROM dispositivos WHERE pvid = '$pvid'");
			
			while($row = mysql_fetch_assoc($sql_mask)){
				
				$dvdhcpmask = $row['DHCP_mascara'];
			
			}
		
		}
		
		if(empty($dvdhcpgateway)){
		
			$sql_gateway = mysql_query("SELECT DHCP_gateway FROM dispositivos WHERE pvid = '$pvid'");
			
			while($row = mysql_fetch_assoc($sql_gateway)){
				
				$dvdhcpgateway = $row['DHCP_gateway'];
			
			}
		
		}
		
		if(empty($dvdhcpdns)){
		
			$sql_dns = mysql_query("SELECT DHCP_dns FROM dispositivos WHERE pvid = '$pvid'");
			
			while($row = mysql_fetch_assoc($sql_dns)){
				
				$dvdhcpdns = $row['DHCP_dns'];
			
			}
		
		}
		
		$sql = mysql_query("UPDATE dispositivos SET user = '$user', senha = '$dvsenha', nome = '$nome', DHCP_ip = '$dvdhcpip', DHCP_mascara = '$dvdhcpmask', DHCP_gateway = '$dvdhcpgateway', DHCP_dns = '$dvdhcpdns' WHERE pvid = '$pvid'") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Dispositivo Atualizado DHCP com Sucesso!</center>";
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível atualizar o dispositivo!</center>";
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