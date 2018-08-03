<?php
$conn = @mysql_connect('localhost','root','') or die(mysql_error());

mysql_select_db('teste', $conn);
?>

<html>

<head>
<title>Adicionando Dispositivo</title>
<script type = "text/javascript">
function loginsucessfully(){
	setTimeout("window.location='devices.php'", 2000);
}
function loginfailed(){
	setTimeout("window.location='devices.php'", 2000);
}
</script>
</head>

<body>
<?php
$selecao = $_POST['selecao'];
$pvid = $_POST['dvpvid'];
$user = $_POST['dvuser'];
$dvsenha = $_POST['dvsenha'];
$nome = $_POST['dvnome'];

$sql = mysql_query("INSERT INTO dispositivos (pvid, user, senha, nome) VALUES ('$pvid', '$user', '$dvsenha', '$nome')") or die(mysql_error());

//$sql = mysql_query("SELECT * FROM teste.usuarios WHERE email = '$email' AND senha = '$senha'") or die(mysql_error());

//$row = mysql_num_rows($sql);

/*if($row > 0){
	echo "<center>Dispositivo Adicionado com Sucesso!</center>";
	echo "<script>loginsucessfully()</script>";
}else{
	echo "<center>Não foi possível adicionar o dispositivo!</center>";
	echo "<script>loginfailed()</script>";
}*/

if ($sql == TRUE) {
    echo "<center>Dispositivo Adicionado com Sucesso!</center>";
	echo "<script>loginsucessfully()</script>";
} else {
    echo "<center>Não foi possível adicionar o dispositivo!</center>";
	echo "<script>loginfailed()</script>";
}

mysql_close($conn);

?>
</body>

</html>