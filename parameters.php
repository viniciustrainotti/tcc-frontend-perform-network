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
						<h1 class="page-header">Parâmetros</h1>
					</div>
				</div>

				<!-- /.row -->
				<div class="row">
					<!-- col-lg-2-->
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
									Inserir novos Parâmetros
							</div>
							<div class="panel-body">
								<div class="row">
								<form role="form" method="post" action="parametroadd.php">
                                    <div class="col-lg-6">
										<div class="form-group">
											<label>Informe o novo Parâmetro ou Digite o numero para Atualização</label>
											<input class="form-control" name="parametro_variavel" placeholder="Por exemplo: T">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label>Informe o valor do novo Parâmetro ou Digite o valor para Atualização</label>
											<input class="form-control" name="parametro_valor" placeholder="Por exemplo: 10">
										</div>
									</div>
									<div class="col-lg-6">
										<button type="submit" class="btn btn-primary"name="selecao" value="1">Adicionar</button>
										<button type="submit" class="btn btn-success" name="selecao" value="3">Atualizar</button>
										<button type="submit" class="btn btn-danger" name="selecao" value="2">Excluir</button>
									</div>
								</form>	
								</div>
							</div>
						</div>
					</div>
					<!-- /.col-lg-2-->
					<!-- col-lg-3-->
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Lista de Parâmetros adicionados
							</div>                            
							<div class="panel-body">
                                <div class="table-responsive" style="overflow: auto; width: auto; height: 350px">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>SEQUÊNCIA</th>
												<th>VARIÁVEL</th>
                                                <th>VALOR</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										
										require_once('dbconnect.php');

										$query = "SELECT idparametros, parametro_variavel, parametro_valor FROM parametros ORDER BY idparametros";
										$result = $mysqli->query($query);
										
										while($row = $result->fetch_assoc()){
											$data[] = $row;
											$idparametros = $row["idparametros"];
											$parametro_variavel = $row["parametro_variavel"];
											$parametro_valor = $row["parametro_valor"];
											
											
											echo "<tr><td>".$idparametros."</td><td>".$parametro_variavel."</td><td>".$parametro_valor."</td></tr>";
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






