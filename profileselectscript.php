<?php

$perfil = $_GET['perfil'];

echo "entrou aqui" . $perfil;
				
require_once('dbconnect.php');
				
	$query = "SELECT nome_perfil, nome_script, nome_parametro FROM perfil_script_parametro WHERE nome_perfil = '$perfil' ORDER BY nome_perfil,nome_script";
	
	echo $query;
	
	$result = $mysqli->query($query);
	
	while($row = $result->fetch_assoc()){
		$data[] = $row;
		$nome_perfil = $row["nome_perfil"];
		$nome_script = $row["nome_script"];
		$nome_parametro = $row["nome_parametro"];

		echo "<tr><td>".$nome_perfil."</td><td>".$nome_script."</td><td>".$nome_parametro."</td></tr>";
	}

?>