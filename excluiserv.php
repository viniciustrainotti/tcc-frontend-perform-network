<?php
require("dbconnect_system.php");
?>

<html>

<head>
<title>Excluindo Resultados de Serviços</title>
</head>

<body>
<?php
$data_rows = $_POST['data_rows'];

echo $data_rows;

$sql1 = mysql_query("DELETE FROM retorno_scripts_teste WHERE num_servico = '$data_rows'") or die(mysql_error());

$sql2 = mysql_query("DELETE FROM servicos WHERE nome_servico = '$data_rows';") or die(mysql_error());

$sql3 = mysql_query("DELETE FROM arquivos_teste WHERE servico = '$data_rows';") or die(mysql_error());

header("Location: run_finalizados.php");

mysql_close($conn);

?>
</body>

</html>