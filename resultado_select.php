<?php

require_once('dbconnect.php');

$resultspvid = $_GET['resultspvid'];
echo "<label>Escolha o Serviço</label>";
echo "<select class='form-control' name='servico'>";
				
$query = "SELECT num_servico FROM retorno_scripts_teste WHERE pvid_dispositivo = '$resultspvid' GROUP BY num_servico";
	$result = $mysqli->query($query);
	
	while($row = $result->fetch_assoc()){
		$data[] = $row;
		$num_servico = $row["num_servico"];
		
		echo "<option>".$num_servico."</option>";
	}
echo "</select>";

?>