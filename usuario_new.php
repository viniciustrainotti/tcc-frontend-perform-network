<?php
require('dbconnect_system.php');
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

	<!-- Page Content -->
		<div id="page-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">Novo Usuario</h1>
					</div>
				</div>

				<!-- /.row -->
				<div class="row">
					<!-- col-lg-1-->
					<div class="col-lg-12" style="width: 600px; height: 200px">
						<div class="panel panel-default">
							<div class="panel-heading">
									Novo Usuario
							</div>
							<div class="panel-body">
								<form role="form" method="post" action="usuario_add.php">
									<div class="form-group">
										<label>Informe o novo Login</label>
										<input class="form-control" name="login" placeholder="Login">
									</div>
									<div class="form-group">
										<label>Informe a nova Senha</label>
										<input class="form-control" placeholder="Password" name="senha" type="password" value="">
									</div>
									<button type="submit" class="btn btn-primary"name="selecao" value="1">Adicionar</button>
								</form>
							</div>
						</div>
					</div>
					<!-- col-lg-1-->
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


