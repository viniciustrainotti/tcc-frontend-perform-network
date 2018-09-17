<?php

require_once('dbconnect.php');

$gruposcript = $_GET['grupo'];
echo "<label>SCRIPT</label>";
echo "<select class='form-control' name='script'>";
	
$query = "SELECT nomescript FROM scripts WHERE gruposcript = '$gruposcript' ORDER BY idscripts";
	$result = $mysqli->query($query);
	
	while($row = $result->fetch_assoc()){
		$data[] = $row;
		$nomescript = $row["nomescript"];
		
		echo "<option>".$nomescript."</option>";
	}
echo "</select>";

?>