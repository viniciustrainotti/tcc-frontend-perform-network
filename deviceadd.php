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

switch ($selecao) {
    case '1':
	
		$sql = mysql_query("INSERT INTO dispositivos (pvid, user, senha, nome) VALUES ('$pvid', '$user', '$dvsenha', '$nome')") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Dispositivo Adicionado com Sucesso!</center>";
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível adicionar o dispositivo!</center>";
			echo "<script>loginfailed()</script>";
		}
		
       break;
        //save article and redirect
    case '2':
	
		$sql = mysql_query("DELETE FROM dispositivos WHERE pvid ='$pvid';") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Dispositivo Excluido com Sucesso!</center>";
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível Excluido o dispositivo!</center>";
			echo "<script>loginfailed()</script>";
		}

        break;

    default:
        //no action sent
}

mysql_close($conn);

?>
</body>

</html>