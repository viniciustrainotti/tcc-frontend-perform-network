<?php

$perfil = $_POST['perfil'];

//echo "entrou aqui" . $perfil;
echo "<div class='panel panel-default'>";
echo "<div class='panel-heading'>";
echo "Lista de Perfis vinculados à scripts";
echo "</div>";

echo "<div class='panel-body'>";
echo "<div class='table-responsive' style='overflow: auto; width: auto; height: 350px'>";
echo "<table class='table table-striped table-bordered table-hover'>";
echo "<thead>";
echo "<tr>";
echo " <th>PERFIL</th>";
echo "<th>SCRIPT</th>";
echo "<th>PARAMETRO</th>";
echo " </tr>";
echo "</thead>";
echo "<tbody>";

require_once('dbconnect.php');
				
	$query = "SELECT nome_perfil, nome_script, nome_parametro FROM perfil_script_parametro WHERE nome_perfil = '$perfil' ORDER BY nome_perfil,nome_script";
	
	//echo $query;
	
	$result = $mysqli->query($query);
	
	while($row = $result->fetch_assoc()){
		$data[] = $row;
		$nome_perfil = $row["nome_perfil"];
		$nome_script = $row["nome_script"];
		$nome_parametro = $row["nome_parametro"];

		echo "<tr><td>".$nome_perfil."</td><td>".$nome_script."</td><td>".$nome_parametro."</td></tr>";
	}

echo "</tbody>";
echo "</table>";
echo "</div>";
echo "</div>";
echo "</div>";
	
?>