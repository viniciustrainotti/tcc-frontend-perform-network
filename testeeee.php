<?php

require("dbconnect_system.php");
	
$pasta = 'C:/wamp/www/slimtest/uploads/PING';

$grupo = "PING";

 if(is_dir($pasta))
 {
  $diretorio = dir($pasta);

  while(($arquivo = $diretorio->read()) !== false)
  {
   if($arquivo != '..' && $arquivo != '.')
	{
		echo '<a href='.$pasta.$arquivo.'>'.$arquivo.'</a><br />';
		
		$sql = mysql_query("SELECT * FROM scripts WHERE nomescript = '$arquivo' AND gruposcript = '$grupo'") or die(mysql_error());
		
		$row = mysql_num_rows($sql);
		
		if($row > 0){
			echo '<a>'.$arquivo.'</a><br />';
		
		}else{
			$sql = mysql_query("INSERT INTO scripts (nomescript, gruposcript) VALUES ('$arquivo', '$grupo')") or die(mysql_error());
		}
	}
  }

  $diretorio->close();
 }
 else
 {
  echo 'A pasta não existe.';
 }
?>