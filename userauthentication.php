<?php
require("dbconnect_system.php");
?>

<html>

<head>
<title>Autenticando usuario</title>
<script type = "text/javascript">
function loginsucessfully(){
	setTimeout("window.location='index.php'", 5000);
}
function loginfailed(){
	setTimeout("window.location='login.php'", 5000);
}
</script>
</head>

<body>
<?php
$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = mysql_query("SELECT * FROM teste.usuarios WHERE email = '$email' AND senha = '$senha'") or die(mysql_error());

$row = mysql_num_rows($sql);

if($row > 0){
	session_start();
	$_SESSION['email'] = $_POST['email'];
	$_SESSION['senha'] = $_POST['senha'];
	echo "<center>Você foi autenticado com sucesso! Aguarde um instante.</center>";
	echo "<script>loginsucessfully()</script>";
}else{
	echo "<center>Nome de usuário ou senha inválidos! Aguarde um instante para tentar novamente!</center>";
	echo "<script>loginfailed()</script>";

}

?>
</body>

</html>