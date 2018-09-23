<?php

require_once('dbconnect.php');

$pvid = $_GET['pvid'];

echo "<p>Tabela de Roteamento do Dispositivo selecionado</p>";
echo "<p class='form-control-static'>";
				
$query = "SELECT route_enviado FROM route WHERE pvid = '$pvid' ORDER BY idroute";
	$result = $mysqli->query($query);
	
	while($row = $result->fetch_assoc()){
		$data[] = $row;
		$route_enviado = $row["route_enviado"];
		
		echo nl2br($route_enviado);
	}
echo "</p>";


?>