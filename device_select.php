<?php

require_once('dbconnect.php');

$dvpvid = $_GET['dvpvid'];

echo "<label>Informe novo User</label>";
echo "<input class='form-control' name='dvuser' placeholder='Por exemplo: blabla'";
				
$query = "SELECT user FROM dispositivos WHERE pvid = '$dvpvid' ORDER BY iddispositivo;";
	$result = $mysqli->query($query);
	
	while($row = $result->fetch_assoc()){
		$data[] = $row;
		$user = $row["user"];
		
	}
echo " value = '$user' >";
echo "</br> ";

echo "<label>Informe nova Senha</label>";
echo "<input class='form-control' name='dvsenha' placeholder='Por exemplo: 1234'";
				
$query = "SELECT senha FROM dispositivos WHERE pvid = '$dvpvid' ORDER BY iddispositivo;";
	$result = $mysqli->query($query);
	
	while($row = $result->fetch_assoc()){
		$data[] = $row;
		$senha = $row["senha"];
		
	}
echo " value = '$senha' >";

echo "</br> ";

echo "<label>Informe novo Nome</label>";
echo "<input class='form-control' name='dvnome' placeholder='Por exemplo: uxux'";
				
$query = "SELECT nome FROM dispositivos WHERE pvid = '$dvpvid' ORDER BY iddispositivo;";
	$result = $mysqli->query($query);
	
	while($row = $result->fetch_assoc()){
		$data[] = $row;
		$nome = $row["nome"];
		
	}
echo " value = '$nome' >";

echo "</br> ";

echo "<label>Informe Endereçamento Estático IP</label>";
echo "<input class='form-control' name='dvdhcpip' placeholder='Por exemplo: 192.168.0.X'";
				
$query = "SELECT DHCP_ip FROM dispositivos WHERE pvid = '$dvpvid' ORDER BY iddispositivo;";
	$result = $mysqli->query($query);
	
	while($row = $result->fetch_assoc()){
		$data[] = $row;
		$DHCP_ip = $row["DHCP_ip"];
		
	}
echo " value = '$DHCP_ip' >";

echo "</br> ";

echo "<label>Informe Endereçamento Estático Máscara</label>";
echo "<input class='form-control' name='dvdhcpmask' placeholder='Por exemplo: 255.255.255.X'";
				
$query = "SELECT DHCP_mascara FROM dispositivos WHERE pvid = '$dvpvid' ORDER BY iddispositivo;";
	$result = $mysqli->query($query);
	
	while($row = $result->fetch_assoc()){
		$data[] = $row;
		$DHCP_mascara = $row["DHCP_mascara"];
		
	}
echo " value = '$DHCP_mascara' >";

echo "</br> ";

echo "<label>Informe Endereçamento Estático Gateway</label>";
echo "<input class='form-control' name='dvdhcpgateway' placeholder='Por exemplo: 192.168.0.X'";
				
$query = "SELECT DHCP_gateway FROM dispositivos WHERE pvid = '$dvpvid' ORDER BY iddispositivo;";
	$result = $mysqli->query($query);
	
	while($row = $result->fetch_assoc()){
		$data[] = $row;
		$DHCP_gateway = $row["DHCP_gateway"];
		
	}
echo " value = '$DHCP_gateway' >";

echo "</br> ";

echo "<label>Informe Endereçamento Estático DNS</label>";
echo "<input class='form-control' name='dvdhcpdns' placeholder='Por exemplo: 8.8.8.8'";
				
$query = "SELECT DHCP_dns FROM dispositivos WHERE pvid = '$dvpvid' ORDER BY iddispositivo;";
	$result = $mysqli->query($query);
	
	while($row = $result->fetch_assoc()){
		$data[] = $row;
		$DHCP_dns = $row["DHCP_dns"];
		
	}
echo " value = '$DHCP_dns' >";




?>