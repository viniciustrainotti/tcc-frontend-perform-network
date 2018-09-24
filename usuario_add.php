<?php
require("dbconnect_system.php");
?>

<html>

<head>
<title>Adicionando novo Usuario</title>
<script type = "text/javascript">
function loginsucessfully(){
	setTimeout("window.location='login.php'", 5000);
}
function loginfailed(){
	setTimeout("window.location='usuario_new.php'", 5000);
}
</script>
</head>

<body>
<?php
$selecao = $_POST['selecao'];
$login = $_POST['login'];
$senha = $_POST['senha'];

switch ($selecao) {
    case '1':
	
	$sql_search = mysql_query("SELECT * FROM usuarios WHERE email = '$login';");
	
	$num_rows = mysql_num_rows($sql_search);
	
	if($num_rows > 0){
		
		echo "<center>Já Existe um Usuario cadastro com esse login por gentileza criar com outro nomes!</center>";
		echo "<script>loginfailed()</script>";
	
	}else{
		
		$sql = mysql_query("INSERT INTO usuarios (email, senha) VALUES ('$login', '$senha')") or die(mysql_error());

		if ($sql == TRUE) {
			echo "<center>Usuario Adicionado com Sucesso!</center>";
			echo "<script>loginsucessfully()</script>";
		} else {
			echo "<center>Não foi possível adicionar o Usuario!</center>";
			echo "<script>loginfailed()</script>";
		}
		
	}
	
       break;
        //save article and redirect
		
    default:
        //no action sent
}

mysql_close($conn);

?>
</body>

</html>