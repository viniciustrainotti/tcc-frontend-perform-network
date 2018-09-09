<?php

require_once('dbconnect.php');

$pvid = $_GET['pvid'];

echo "<label>Adicione ou Edite o texto conforme Tabela de Roteamento</label>";
echo "<textarea class='form-control' name='route' id='route' rows='5'>";
				
$query = "SELECT route_conteudo FROM route WHERE pvid = '$pvid' ORDER BY idroute";
	$result = $mysqli->query($query);
	
	while($row = $result->fetch_assoc()){
		$data[] = $row;
		$route_conteudo = $row["route_conteudo"];
		
		echo $route_conteudo;
	}
echo "</textarea>";


?>