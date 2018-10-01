<?php
require('dbconnect_system.php');
?>

<?php
	session_start();
	if(!isset($_SESSION["email"]) || !isset($_SESSION["senha"])){
		header("Location: login.php");
		exit;
	}
?>

<?php

$email = $_SESSION["email"];

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ferramenta de Analise de Desempenho de Rede</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/startmin.css" rel="stylesheet">

	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	
	<!-- Custom Fonts -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
</head>
<body>

<div id="wrapper">

	<!-- Navigation -->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">


		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>

		<!-- Top Navigation: Left Menu -->
		<ul class="nav navbar-nav navbar-left navbar-top-links">
			<li><a href="index.php"><i class="fa fa-home fa-fw"></i> Home</a></li>
		</ul>
		
		<div class="navbar-header">
			<a class="navbar-brand" href="#">Ferramenta de Análise de Desempenho de Rede</a>
		</div>

		<!-- Top Navigation: Right Menu -->
		<ul class="nav navbar-right navbar-top-links">
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="fa fa-user fa-fw"></i> <?php echo $email; ?><b class="caret"></b>
				</a>
				<ul class="dropdown-menu dropdown-user">
					<li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
					</li>
				</ul>
			</li>
		</ul>

		<!-- Sidebar -->
		<div class="navbar-default sidebar" role="navigation">
			<div class="sidebar-nav navbar-collapse">

				<ul class="nav" id="side-menu">
					
					<?php include 'menu_navbar.php' ?>
					
				</ul>

			</div>
		</div>
	</nav>

	<!-- Page Content -->
	<div id="page-wrapper">
		<div class="container-fluid">

			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Monitoramento</h1>
				</div>
			</div>

			<!-- /.row -->
			<form method="post" action="monitora_view_add.php" enctype="multipart/form-data">
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							Monitoramento Dispositvo <?php if(isset($_GET['dispositivo'])){ echo $_GET['dispositivo']; } else { echo "0"; } ?> - Serviço <?php if(isset($_GET['servico'])){ echo $_GET['servico']; } else { echo "0"; } ?>
						</div>  
						<div class="panel-body">
							<div id="chart"></div>
						</div>
					</div>
					<input type="hidden" name="dispositivo" value="<?php if(isset($_GET['dispositivo'])){ echo $_GET['dispositivo']; } else { echo "0"; } ?>"></input>
					<input type="hidden" name="servico" value="<?php if(isset($_GET['servico'])){ echo $_GET['servico']; } else { echo "0"; } ?>"></input>
					<p>
						<button type="submit" class="btn btn-danger" name="selecao" value="1">Parar Monitoramento</button>
						<button type="submit" class="btn btn-primary" name="selecao" value="2">Limpar Dados</button>
					</p>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="js/startmin.js"></script>

</body>
</html>
<?php

if(isset($_GET['servico'])){
	$servico = $_GET['servico'];
}else{
	$servico = NULL;
}

if(isset($_GET['dispositivo'])){
	$dispositivo = $_GET['dispositivo'];
}else{
	$dispositivo = NULL;
}

//echo $servico;

require_once('dbconnect.php');

$connect = mysqli_connect($host, $user, $pass, $db_name);
$query = "SELECT * FROM retorno_script_monitoramento_ping WHERE servico = '$servico' AND dispositivo = '$dispositivo' ORDER BY idretorno_script_monitoramento_ping";
$result = mysqli_query($connect, $query);
$chart_data = '';
while($row = mysqli_fetch_array($result))
{
	$chart_data .= "{ y: '".$row["date"]."', a: ".$row["valor"]."}, ";
}
$chart_data = substr($chart_data, 0, -2);
?>

<script>
Morris.Area({
	element : 'chart',
	data : [ <?php echo $chart_data; ?>	],
	xkey : 'y',
	ykeys: ['a'],
	labels : ['Valor medido (ms)'],
	parseTime: false,
    hideHover: true
});
</script>
<!-- utilizado somente content pra nao perder o get -->
<meta HTTP-EQUIV='refresh' CONTENT='6'>


