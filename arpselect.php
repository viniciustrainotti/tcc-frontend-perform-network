<?php

require_once('dbconnect.php');

$pvid = $_GET['pvid'];

echo "<label>Adicione o texto conforme IP (Espaço) MAC. Ex.: 192.168.1.1 30-99-35-9f-00-0b</label>";
echo "<textarea class='form-control' name='arp' id='arp' rows='5'>";
				
$query = "SELECT arp_conteudo FROM arp WHERE pvid = '$pvid' ORDER BY idarp";
	$result = $mysqli->query($query);
	
	while($row = $result->fetch_assoc()){
		$data[] = $row;
		$arp_conteudo = $row["arp_conteudo"];
		
		echo $arp_conteudo;
	}
echo "</textarea>";

echo "</br>";

echo "<label>Retorno da Tabela ARP do Dispositivo</label>";

echo "<p class='form-control-static'>";
		
$query = "SELECT arp_comparacao FROM arp WHERE pvid = '$pvid' ORDER BY idarp";
	$result = $mysqli->query($query);

	while($row = $result->fetch_assoc()){
		$data[] = $row;
		$arp_comparacao = $row["arp_comparacao"];

		echo nl2br($arp_comparacao);
		
	}
	
echo "</p>";

?>