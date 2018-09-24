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
						<!-- /.nav-second-level -->
					</li>
					<li>
						<a href="#" class="active"><i class="fa fa-cube fa-fw"></i> Perfil<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="profile.php">Adicionar Perfil</a>
							</li>
							<li>
								<a href="profile_vinc.php">Vinculações Perfil</a>
							</li>
						</ul>
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
						<a href="#" class="active"><i class="fa fa-sheqel fa-fw"></i> Serviços<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="bindings.php">Adicionar Serviços</a>
							</li>
							<li>
								<a href="bindings_vinc.php">Vinculações de Serviços</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="#" class="active"><i class="fa fa-play fa-fw"></i> Executar<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="run.php">Liberar Serviços</a>
							</li>
							<li>
								<a href="run_finalizados.php">Finalizados</a>
							</li>
							<li>
								<a href="run_monitora.php">Monitoramento</a>
							</li>
						</ul>
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
						<h1 class="page-header">Vinculações de Serviços</h1>
					</div>
				</div>

				<!-- /.row -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Escolha o Serviço para vincular ao Perfil e Dispositivo
							</div>						
							<div class="panel-body">
							<form method="post" action="bindingsadd.php" enctype="multipart/form-data">
								<p>Escolha o Dispositivo na lista para vincular</p>
								<div class="form-group">
									<label>DISPOSITIVO</label>
									<select class="form-control" name="dispositivo">
									<?php
									
										require_once('dbconnect.php');
										
										$query = "SELECT pvid FROM dispositivos ORDER BY iddispositivo";
										$result = $mysqli->query($query);
										
										while($row = $result->fetch_assoc()){
											$data[] = $row;
											$pvid = $row["pvid"];
											
											echo "<option>".$pvid."</option>";
										}
									?>
									</select>
								</div>
									<p>Escolhe o Perfil respectivamente</p>
									<div class="form-group">
										<label>PERFIL</label>
										<select class="form-control" name="perfil">
										<?php
										
											require_once('dbconnect.php');
											
											//$query = "SELECT gruposcript FROM scripts GROUP BY gruposcript";
											$query = "SELECT nome_perfil FROM perfil ORDER BY idperfil";
											$result = $mysqli->query($query);
											
											while($row = $result->fetch_assoc()){
												$data[] = $row;
												$nome_perfil = $row["nome_perfil"];
												
												echo "<option>".$nome_perfil."</option>";
											}
										?>
										</select>
									</div>
										<p>Escolha o Serviço para vincular ao Perfil e Dispositivo</p>
										<div class="form-group">
											<label>SERVIÇO</label>
											<select class="form-control" name="servico">
											<?php
											
												require_once('dbconnect.php');
												
												$query = "SELECT nome_servicos FROM servicos_tipos ORDER BY idservicos_tipos";
												$result = $mysqli->query($query);
												
												while($row = $result->fetch_assoc()){
													$data[] = $row;
													$nome_servicos = $row["nome_servicos"];
													
													echo "<option>".$nome_servicos."</option>";
												}
											?>
											</select>
										</div>
									<p>
										<button type="submit" class="btn btn-success" name="selecao" value="3">Vincular Serviço</button>
										<button type="submit" class="btn btn-danger" name="selecao" value="4">Desvincular Serviço</button>
									</p>
								</form>
							</div>
                            <!-- /.panel-body -->
							<div class="panel-footer">
								Observações
							</div>
						</div>
					</div>
					<!-- /.col-lg-1 -->
					<!-- col-lg-3-->
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Lista de Serviços vinculados ao Perfil e ao Dispositivo
							</div>                            
							<div class="panel-body">
                                <div class="table-responsive" style="overflow: auto; width: auto; height: 350px">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>SERVIÇO</th>
                                                <th>PERFIL</th>
												<th>DISPOSITIVO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										
										require_once('dbconnect.php');

										$query = "SELECT nome_servico, perfil, dispositivo FROM servicos ORDER BY idservicos";
										$result = $mysqli->query($query);
										
										while($row = $result->fetch_assoc()){
											$data[] = $row;
											$nome_servico = $row["nome_servico"];
											$perfil = $row["perfil"];
											$dispositivo = $row["dispositivo"];
											
											
											echo "<tr><td>".$nome_servico."</td><td>".$perfil."</td><td>".$dispositivo."</td></tr>";
										}?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
						</div>
					</div>
					<!-- /.col-lg-3 -->
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




