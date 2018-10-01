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
<script>
 $(document).ready(function(){
		$('#resultspvid').change(function(){
			$('#teste').load('resultado_select.php?resultspvid='+$('#resultspvid').val());
			//var r = $('#grupo').val();
			//alert(r);
		});
	});
</script>		
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
						<h1 class="page-header">Response Time</h1>
					</div>
				</div>
				<!-- /.row -->
				
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Selecione primeiramente o Dispositivo para verificar quais serviços já foram retornados
							</div>						
							<div class="panel-body">
							<form method="" action="" enctype="multipart/form-data">
								<div class="form-group">
										<label>Escolha o Dispositivo</label>
										<select class="form-control" name="resultspvid" id="resultspvid">
										<?php
										
											require_once('dbconnect.php');
											
											$query = "SELECT pvid FROM dispositivos WHERE user = '$email' ORDER BY iddispositivo;";
											$result = $mysqli->query($query);
											
											while($row = $result->fetch_assoc()){
												$data[] = $row;
												$pvid = $row["pvid"];
												
												echo "<option value=".$pvid.">".$pvid."</option>";
											}
										?>
										</select>
									</div>
									<div class="form-group" id="teste">
										<label>Escolha o Serviço</label>
											<select class="form-control" name="servico">
											<?php
												
												require_once('dbconnect.php');
												
												//$query = "SELECT nomescript FROM scripts WHERE gruposcript = '$gruposcript' ORDER BY idscripts";
												$query = "SELECT num_servico FROM retorno_scripts_teste WHERE pvid_dispositivo = '$pvid' GROUP BY num_servico UNION SELECT num_servico FROM teste.retorno_scripts_iperf WHERE pvid_dispositivo = '$pvid' GROUP BY num_servico";
												
												$result = $mysqli->query($query);
												
												while($row = $result->fetch_assoc()){
													$data[] = $row;
													$num_servico = $row["num_servico"];
													
													echo "<option>".$num_servico."</option>";
												}
									
											?>
											</select>
									</div>
									<p>
										<button type="submit" class="btn btn-primary" name="selecao" value="1">Pesquisar</button>
										<!-- <input type="submit"/> -->
									</p>
							</form>
							</div>
                            <!-- /.panel-body -->
							<div class="panel-footer">
								Observações
							</div>
						</div>
					</div>
					
				</div>
				
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Tabela resultado serviço PING
							</div>                            
							<div class="panel-body">
                                <div style="overflow: auto; width: auto; height: 344px">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>PVID</th>
                                                <th>SERVIÇO</th>
                                                <th>ICMP</th>
												<th>TTL</th>
												<th>MEDIDO (MS)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php 
											
											require_once('dbconnect.php');
											
											if(isset($_GET['servico'])){
												$servico = $_GET['servico'];
											}else{
												$servico = NULL;
											}
																						
											if(isset($_GET['resultspvid'])){
												$resultspvid = $_GET['resultspvid'];
											}else{
												$resultspvid = NULL;
											}
											
											$query = "SELECT * FROM retorno_scripts_teste WHERE pvid_dispositivo = '$resultspvid' AND num_servico = '$servico' ORDER BY idretorno_scripts_teste;";
											$result = $mysqli->query($query);
											
											while($row = $result->fetch_assoc()){
												$data[] = $row;
												$pvid_dispositivo = $row["pvid_dispositivo"];
												$nome_perfil = $row["nome_perfil"];
												$num_servico = $row["num_servico"];
												$num_icmp = $row["num_icmp"];
												$num_ttl = $row["num_ttl"];
												$num_time = $row["num_time"];
												
												echo "<tr><td>".$pvid_dispositivo."</td><td>".$num_servico."</td><td>".$num_icmp."</td><td>".$num_ttl."</td><td>".$num_time."</td></tr>";
											}?>	
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
						</div>
					</div>
					<!-- /.col-lg-1 -->
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Serviço de Ping - Dispositvo <?php if(isset($_GET['resultspvid'])){ echo $_GET['resultspvid']; } else { echo "0"; } ?> - Serviço <?php if(isset($_GET['servico'])){ echo $_GET['servico']; } else { echo "0"; } ?>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div id="chart"></div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-2 -->
				</div>
				<!-- col-lg-3 -->
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

require_once('dbconnect.php');

$connect = mysqli_connect($host, $user, $pass, $db_name);
$query = "SELECT * FROM retorno_scripts_teste WHERE num_servico = '$servico' AND retorno_scripts_testecol = '1' ORDER BY idretorno_scripts_teste";
$result = mysqli_query($connect, $query);
$chart_data = '';
while($row = mysqli_fetch_array($result))
{
	$chart_data .= "{ y: ".$row["num_icmp"].", a: ".$row["num_time"]."}, ";
}
$chart_data = substr($chart_data, 0, -2);
?>

<script>
Morris.Line({
	element : 'chart',
	data : [ <?php echo $chart_data; ?>	],
	xkey : 'y',
	ykeys: ['a'],
	labels : ['Valor medido (ms)'],
	parseTime: false,
    hideHover: true
});
</script>

