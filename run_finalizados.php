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
						<h1 class="page-header">Serviços Finalizados</h1>
					</div>
				</div>

				<!-- /.row -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Clique emcima do serviço para habilitar a execução conforme o perfil e dispositivo
							</div>                            
							<div class="panel-body">
                                <div class="table-responsive" style="overflow: auto; width: auto; height: 350px">
                                    <table class="table table-striped table-bordered table-hover" id="data">
                                        <thead>
                                            <tr>
                                                <th>PVID</th>
                                                <th>PERFIL</th>
                                                <th>SERVIÇO</th>
												<th>DOWNLOAD</th>
												<th>STATUS</th>
												<th>THREAD</th>
												<th>HABILITADO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										
										require_once('dbconnect.php');

										$query = "SELECT pvid, perfil, nome_servico, download, conectado, finalizado, servico_disp FROM servicos INNER JOIN dispositivos ON servicos.dispositivo = dispositivos.pvid WHERE servicos.download = 'S' ORDER BY idservicos";
										$result = $mysqli->query($query);
										
										while($row = $result->fetch_assoc()){
											$data[] = $row;
											$pvid = $row["pvid"];
											$user = $row["perfil"];
											$senha = $row["nome_servico"];
											$nome = $row["download"];
											if($nome == 'N'){
												$nome = "NÃO REALIZADO";
											}else{
												$nome = "REALIZADO";
											}
											$conectado = $row["conectado"];
											if($conectado == 0){
												$conectado = "OFFLINE";
												$color = "red";
											}else{
												$conectado = "ONLINE";
												$color = "green";
											}
											$servicos = $row["finalizado"];
											if($servicos == 'N'){
												$servicos = "NÃO FINALIZADO";
											}else{
												$servicos = "FINALIZADO";
											}
											$servico_disp = $row["servico_disp"];
											if($servico_disp == 0){
												$servico_disp = "NÃO HABILITADO";
											}else{
												$servico_disp = "HABILITADO";
											}
											
											echo "<tr id='somerow'><td>".$pvid."</td><td>".$user."</td><td>".$senha."</td><td>".$nome."</td><td style='background:".$color.";color: #fff;'>".$conectado."</td><td>".$servicos."</td><td>".$servico_disp."</td></tr>";
										}?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
							<div class="panel-footer">
								Observações: A cada 10 segundos é atualizado automaticamente a página.
							</div>
						</div>
					</div>
					<!-- /.col-lg-1 -->
					
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
document.querySelector("#data tbody").addEventListener("click", function(event) {
  var td = event.target;
  while (td !== this && !td.matches("td")) {
      td = td.parentNode;
  }
  if (td === this) {
      console.log("No table cell found");
  } else {
      console.log(td.innerHTML);
	  // enviar numero do servico para liberar 
	  var data_rows = td.innerHTML;
            //build form HTML (hide keeps the form from being visible)
            $form = $('<form/>').attr({method: 'POST', action: 'excluiserv.php'}).hide();
            //build textarea HTML
            $textarea = $('<textarea/>').attr({name: 'data_rows'}).val(data_rows);
            //add textarea to form
            $form.append($textarea);
            //add form to the document body
            $('body').append($form);
            //submit the form
            $form.submit();
  }
});
</script>
<meta HTTP-EQUIV='refresh' CONTENT='10;URL=run_finalizados.php'>


