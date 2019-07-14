<!DOCTYPE html>
<html>
	<head>
		<title>Plano de Estudo</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/all.min.css"/>
		<link rel="shortcut icon" href="<?php echo BASE_URL; ?>assets/images/favicon.png" />
	</head>
	<body class="bg-light">
		<header class="site-header">
			<nav class="navbar navbar-expand-lg navbar-light">
				<div class="container">
					<div class="row w-100">
						<div class="col-6">
							<a href="<?php echo BASE_URL."index.php?url=home"; ?>" class="navbar-brand logo"><img src="<?php echo BASE_URL; ?>assets/images/cfol.png" alt=""> </a>
						</div>
						<div class="col-6 text-right">
							<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
								<span class="navbar-toggler-icon"></span>
							</button>
							<div class="collapse navbar-collapse w-100 order-3 dual-collapse2" id="navbarNavAltMarkup">
								<ul class="navbar-nav w-100 text-right">

									<?php if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])): ?>
									<!-- Não está funcionando, precisa implementar se o cliente pedir. -->
										<li><a href="<?php echo BASE_URL; ?>login">Login</a></li>
									<?php else: ?>

									
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Cursos
										</a>
										<div class="dropdown-menu" aria-labelledby="navbarDropdown">
										
											<a class="dropdown-item" href="<?= BASE_URL; ?>studyplan">Criar</a>
											<a class="dropdown-item" href="<?= BASE_URL;?>studyplan/list">Listar / Editar</a>
										</div>
									</li>
									<?php endif; ?>

								</ul>
							</div>
						</div>
					</div>
				</div>
			</nav>
		</header>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.min.js"></script>

		<?php $this->loadViewInTemplate($viewName, $viewData); ?> 
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/all.min.js"></script>
	</body>
</html>