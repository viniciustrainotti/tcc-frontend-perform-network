<?php
require("dbconnect_system.php");
?>

<html>

<head>
<title>Liberando Serviços</title>
</head>

<body>
<?php
$data_rows = $_POST['data_rows'];

echo $data_rows;

$sql = mysql_query("SELECT servico_disp FROM servicos WHERE nome_servico = '$data_rows'") or die(mysql_error());

while ($row = mysql_fetch_assoc($sql)) {
    $troca = $row['servico_disp'];
}

//echo $troca;

if($troca == 1){
	$trocou = '0';
}else{
	$trocou = '1';
}

//echo "trocou" . $trocou;

$sql1 = mysql_query("UPDATE servicos SET servico_disp='$trocou' WHERE nome_servico='$data_rows'") or die(mysql_error());

header("Location: run.php");

mysql_close($conn);

?>
</body>

</html>