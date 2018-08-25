<?php
$conn = @mysql_connect('localhost','root','') or die(mysql_error());

mysql_select_db('teste', $conn);
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
		$('#grupo').change(function(){
			$('#teste').load('profileselect.php?grupo='+$('#grupo').val());
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
						<h1 class="page-header">Perfil</h1>
					</div>
				</div>

				<!-- /.row -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Escolha o Perfil para vincular com os Scripts ou crie um novo perfil
							</div>						
							<div class="panel-body">
							<form method="post" action="perfiladd.php" enctype="multipart/form-data">
								<p>Escolha o Perfil na lista para edição</p>
								<div class="form-group">
									<label>PERFIL</label>
									<select class="form-control" name="perfil">
									<?php
									
										require_once('dbconnect.php');
										
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
									<p>Escolhe o grupo do script respectivamente</p>
									<div class="form-group">
										<label>GRUPO</label>
										<select class="form-control" name="grupo" id="grupo">
										<?php
										
											require_once('dbconnect.php');
											
											//$query = "SELECT gruposcript FROM scripts GROUP BY gruposcript";
											$query = "SELECT grupos FROM scripts_grupos";
											$result = $mysqli->query($query);
											
											while($row = $result->fetch_assoc()){
												$data[] = $row;
												$gruposcript = $row["grupos"];
												
												echo "<option value=".$gruposcript.">".$gruposcript."</option>";
											}
										?>
										</select>
									</div>
										<p>Escolha o Script respectivamente para vincular ao Perfil</p>
										<div class="form-group" id="teste">
											<label>SCRIPT</label>
											<select class="form-control" name="script">
												<?php
													
													require_once('dbconnect.php');
													
													//$query = "SELECT nomescript FROM scripts WHERE gruposcript = '$gruposcript' ORDER BY idscripts";
													$query = "SELECT nomescript FROM scripts ORDER BY idscripts";
													$result = $mysqli->query($query);
													
													while($row = $result->fetch_assoc()){
														$data[] = $row;
														$nomescript = $row["nomescript"];
														
														echo "<option>".$nomescript."</option>";
													}
										
												?>
											</select>
										</div>
										<p>Escolha o Parâmetro respectivamente para vincular ao Script e Perfil</p>
										<div class="form-group" id="parametro">
											<label>PARÂMETRO</label>
											<select class="form-control" name="parametro">
												<?php
													
													require_once('dbconnect.php');
													
													$query = "SELECT parametro_variavel FROM parametros ORDER BY idparametros";
													$result = $mysqli->query($query);
													
													while($row = $result->fetch_assoc()){
														$data[] = $row;
														$parametro_variavel = $row["parametro_variavel"];
														
														echo "<option>".$parametro_variavel."</option>";
													}
										
												?>
											</select>
										</div>
									<p>
										<button type="submit" class="btn btn-success" name="selecao" value="3">Vincular Perfil ao Script</button>
										<button type="submit" class="btn btn-danger" name="selecao" value="4">Desvincular Perfil ao Script</button>
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
					<!-- col-lg-2-->
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
									Inserir Novo Perfil
							</div>
							<div class="panel-body">
								<form role="form" method="post" action="perfiladd.php">
									<div class="form-group">
										<label>Informe o nome do novo Perfil</label>
										<input class="form-control" name="perfil" placeholder="Por exemplo: perfilx">
									</div>
									<button type="submit" class="btn btn-primary"name="selecao" value="1">Adicionar</button>
									<button type="submit" class="btn btn-danger" name="selecao" value="2">Excluir</button>
								</form>
							</div>
						</div>
					</div>
					<!-- /.col-lg-2-->
					<!-- col-lg-3-->
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Lista de Perfis vinculados à scripts
							</div>                            
							<div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>PERFIL</th>
                                                <th>SCRIPT</th>
												<th>PARAMETRO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										
										require_once('dbconnect.php');

										$query = "SELECT nome_perfil, nome_script, nome_parametro FROM perfil_script_parametro ORDER BY nome_perfil,nome_script";
										$result = $mysqli->query($query);
										
										while($row = $result->fetch_assoc()){
											$data[] = $row;
											$nome_perfil = $row["nome_perfil"];
											$nome_script = $row["nome_script"];
											$nome_parametro = $row["nome_parametro"];
											
											
											echo "<tr><td>".$nome_perfil."</td><td>".$nome_script."</td><td>".$nome_parametro."</td></tr>";
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






