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
		$('#pvid').change(function(){
			$('#teste').load('routeselect.php?pvid='+$('#pvid').val());
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
					
					<li>
						<a href="#" class="active"><i class="fa fa-cubes fa-fw"></i> Dispositivos<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="devices.php">Dashboard</a>
							</li>
							<li>
								<a href="devices_adicionar.php">Adicionar Dispositivo</a>
							</li>
							<li>
								<a href="devices_editar.php">Editar Dispositivo</a>
							</li>
							<li>
								<a href="devices_excluir.php">Excluir Dispositivo</a>
							</li>
						</ul>
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
						<a href="results.php" class="active"><i class="fa fa-bar-chart fa-fw"></i> Resultados<!-- <span class="fa arrow"></span> --></a>
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
						<h1 class="page-header">Tabela de Roteamento</h1>
					</div>
				</div>

				<!-- /.row -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Escolha o Dispositivo vinculado para comparação da Tabela Route cadastrada.
							</div>						
							<div class="panel-body">
							<form method="post" action="tabelaROUTEadd.php" enctype="multipart/form-data">
								<p>Escolha o Dispositivo na lista para edição</p>
								<div class="form-group">
									<label>DISPOSITIVO</label>
									<select class="form-control" name="pvid" id="pvid">
									<?php
									
										require_once('dbconnect.php');
										
										$query = "SELECT pvid FROM dispositivos ORDER BY pvid";
										$result = $mysqli->query($query);
										
										while($row = $result->fetch_assoc()){
											$data[] = $row;
											$pvid = $row["pvid"];
											
											echo "<option>".$pvid."</option>";
										}
									?>
									</select>
								</div>
								<p>Insira/Atualize a Tabela Route do dispositivo selecionado</p>
								<div class="form-group" id="teste">
									<label>Adicione ou Edite o texto conforme Tabela de Roteamento</label>
									<textarea class="form-control" name="route" id="route" rows="5">
									<?php
									
										require_once('dbconnect.php');
										
										$query = "SELECT route_conteudo FROM route WHERE pvid = '$pvid' ORDER BY idroute";
										$result = $mysqli->query($query);
										
										while($row = $result->fetch_assoc()){
											$data[] = $row;
											$route_conteudo = $row["route_conteudo"];
		
											echo $route_conteudo;
											
										}
									?>
									</textarea>
								</div>
								<p>
									<button type="submit" class="btn btn-primary" name="selecao" value="1">Inserir</button>
									<button type="submit" class="btn btn-success" name="selecao" value="2">Atualizar</button>
									<button type="submit" class="btn btn-danger" name="selecao" value="3">Comparar</button>
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






