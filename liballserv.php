<html>

<head>
<title>Liberando Todos os Serviços em referencia aos Dispositivos</title>
</head>

<body>
<?php
		
//$sql = mysql_query("SELECT * FROM servicos WHERE servico_disp = '1'") or die(mysql_error());

require_once('dbconnect.php');
										
$query = "SELECT dispositivo FROM servicos WHERE servico_disp = '1' GROUP BY dispositivo";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()){
	$data[] = $row;
	$dispositivo = $row["dispositivo"];
	
	$query1 = "UPDATE dispositivos SET servicos='1' WHERE pvid='$dispositivo'";
	$result1 = $mysqli->query($query1);
	
	//echo "<h1>".$dispositivo."</h1>";
}

header("Location: run.php");

//mysql_close($conn);

?>
</body>

</html>