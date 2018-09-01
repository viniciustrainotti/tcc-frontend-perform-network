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
					
					<li>
						<a href="devices.php" class="active"><i class="fa fa-cubes fa-fw"></i> Dispositivos</a>
					</li>
					<li>
						<a href="profile.php" class="active"><i class="fa fa-cube fa-fw"></i> Perfil</a>
					</li>
					<li>
						<a href="parameters.php" class="active"><i class="fa fa-list fa-fw"></i> Parâmetros</a>
					</li>
					<li>
						<a href="scripts.php" class="active"><i class="fa fa-tasks fa-fw"></i> Scripts</a>
					</li>
					<li>
						<a href="tableARP.php" class="active"><i class="fa fa-exchange fa-fw"></i> Tabela ARP</a>
					</li>
					<li>
						<a href="tableROUTE.php" class="active"><i class="fa fa-location-arrow fa-fw"></i> Tabela Roteamento</a>
					</li>
					<li>
						<a href="bindings.php" class="active"><i class="fa fa-sheqel fa-fw"></i> Vinculações</a>
					</li>
					<li>
						<a href="run.php" class="active"><i class="fa fa-play fa-fw"></i> Executar</a>
					</li>
					<li>
						<a href="results.php"><i class="fa fa-bar-chart fa-fw"></i> Resultados<!-- <span class="fa arrow"></span> --></a>
						<!-- <ul class="nav nav-second-level">
							<li>
								<a href="#">Second Level Item</a>
							</li>
							<li>
								<a href="#">Third Level <span class="fa arrow"></span></a>
								<ul class="nav nav-third-level">
									<li>
										<a href="#">Third Level Item</a>
									</li>
								</ul>
							</li>
						</ul>-->
					</li>
				</ul>

			</div>
		</div>
	</nav>

	<!-- Page Content -->
		<div id="page-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">Resultado</h1>
					</div>
				</div>
				<!-- /.row -->
				
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Selecione as informações desejadas para mostrar os resultados
							</div>						
							<div class="panel-body">
							<form method="" action="" enctype="multipart/form-data">
								<p>Escolha o Dispositivo</p>
								<div class="form-group">
									<label>DISPOSITIVO</label>
									<select class="form-control" name="dispositivo">
										<option>10</option>
										<option>11</option>
									</select>
								</div>
									<p>Escolha o Serviço</p>
									<div class="form-group">
										<label>SERVIÇO</label>
										<select class="form-control" name="servico">
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
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
					<div class="col-lg-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								Prototipo de grafico do resultado de um serviço PING
							</div>                            
							<div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>PVID</th>
                                                <th>PERFIL</th>
                                                <th>SERVIÇO</th>
                                                <th>INICIO</th>
												<th>FIM</th>
												<th>MEDIDO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<tr>
												<td>10</td>
												<td>perfil 1</td>
												<td>1</td>
												<td>00:00</td>
												<td>00:01</td>
												<td>50</td>
											</tr>
											<tr>
												<td>10</td>
												<td>perfil 1</td>
												<td>1</td>
												<td>00:01</td>
												<td>00:02</td>
												<td>49</td>
											</tr>
											<tr>
												<td>10</td>
												<td>perfil 1</td>
												<td>1</td>
												<td>00:02</td>
												<td>00:03</td>
												<td>50</td>
											</tr>
											<tr>
												<td>10</td>
												<td>perfil 1</td>
												<td>1</td>
												<td>00:03</td>
												<td>00:04</td>
												<td>0</td>
											</tr>
											<tr>
												<td>10</td>
												<td>perfil 1</td>
												<td>1</td>
												<td>00:04</td>
												<td>00:05</td>
												<td>0</td>
											</tr>
											<tr>
												<td>10</td>
												<td>perfil 1</td>
												<td>1</td>
												<td>00:05</td>
												<td>00:06</td>
												<td>50</td>
											</tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
						</div>
					</div>
					<!-- /.col-lg-1 -->
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Serviço de Ping - Dispositvo 10 - Serviço 1
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

<script>
Morris.Line({
	element : 'chart',
	data : [
	{ y: '00:00', a: 50 },
    { y: '00:01', a: 49 },
    { y: '00:02', a: 50 },
    { y: '00:03', a: 0 },
    { y: '00:04', a: 0 },
    { y: '00:05', a: 50 },
	{ y: '00:06', a: 51 },
	{ y: '00:07', a: 55 },
	{ y: '00:08', a: 60 },
	{ y: '00:09', a: 55 },
	{ y: '00:10', a: 53 },
	{ y: '00:11', a: 49 },
	{ y: '00:12', a: 100 },
    { y: '00:13', a: 49 }
	],
	xkey : 'y',
	ykeys: ['a'],
	labels : ['Valor medido (ms)'],
	parseTime: false,
    hideHover: true
});
</script>

