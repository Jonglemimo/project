<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= $title ?></title>
	
	<!-- BOOTSTRAP 3.3.7 -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- CUSTOM FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600i,700|Pacifico" rel="stylesheet">
	<!-- CUSTOM CSS -->
	<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css')?>">
</head>
<body>
<header>
	<!-- HEADER BAR -->
	<nav class="header-bar navbar navbar-fixed-top">
		<div class="container-fluid">
			<div class="row">

			<!-- NAVIGATION BAR BUTTON -->
			<div class="nav-bar-button-col navbar-header col-xs-2 visible-xs">
				<button type="button" class="btn buttons navbar-toggle" id="mySidenav">
					<span class="glyphicon glyphicon-align-justify"></span>
				</button>
			</div>

			<!-- WEBSITE LOGO -->
			<div class="navbar-header col-xs-5 col-sm-3">
				<a class="website-title navbar-brand" href="<?= $this->url('default_home') ?>">Tutomotion</a>
			</div>

			<!-- SEARCH BAR AND CONNEXION BUTTONS MOBILES -->
			<div class="header-buttons-mobile col-xs-5 visible-xs text-right">
				<!-- SEARCH -->
				<button type="button" class="buttons header-button btn btn-default" data-toggle="collapse" href="#search-form-mobile" aria-expanded="false" aria-controls="search-form-mobile">
					<i class="visible-xs visible-sm glyphicon glyphicon-search"></i>
				</button>

				<!-- CONNEXION -->
				<button type="button" class="buttons btn btn-default" data-toggle="collapse" href="#login-buttons-mobile" aria-expanded="false" aria-controls="login-buttons-mobile">
					<i class="visible-xs visible-sm glyphicon glyphicon-user"></i>
				</button>
			</div>
			
			<!-- SEARCH BAR AND CONNEXION BUTTONS COMPUTERS -->
			<div class="col-xs-6 col-sm-9 hidden-xs">
				<form class="navbar-form" method="POST">
					<div class="row">
						<!-- SEARCH -->
						<div class="form-group text-center col-xs-6" >
							<input type="text" id="search" class="form-control" placeholder="Rechercher">
							<button type="submit" id="btnSearch" class="buttons search-button-computer btn btn-default glyphicon glyphicon-search"></button>
						</div>

						<!-- CONNEXION -->
						<div class="form-group text-right col-xs-6">
						<?php if(isset($_SESSION['user'])): ?>
							<a class="buttons btn btn-default" href="<?= $this->url('user_logout') ?>">Déconnexion</a>
						<?php else : ?>
							<a class="buttons btn btn-default" href="<?= $this->url('user_signup') ?>">Inscription</a>
							<a class="buttons btn btn-default" href="<?= $this->url('user_login') ?>">Connexion</a>
						<?php endif ; ?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</nav>

	<!-- COLLAPSE SEARCH BAR AND SIGNIN/LOGIN BUTTON MOBILES -->
	<!-- SEARCH -->
	<div class="search-form-mobile collapse navbar-fixed-top" id="search-form-mobile">
		<div class="text-center">
			<input type="text" id="search" class="form-control" placeholder="Rechercher">
			<button type="submit" id="btnSearch" class="buttons search-button-mobile btn btn-default glyphicon glyphicon-search"></button>
		</div>
	</div>
	<!-- CONNEXION -->
	<div class="login-buttons-mobile collapse navbar-fixed-top" id="login-buttons-mobile">
		<div class="text-center">
			<?php if(isset($_SESSION['user'])): ?>
	            <a class="buttons login-signin-button btn btn-default" href="<?= $this->url('user_logout') ?>">Déconnexion</a>
	        <?php else : ?>
				<a class="buttons login-signin-button btn btn-default" href="<?= $this->url('user_signup') ?>">Inscription</a>
				<a class="buttons login-signin-button btn btn-default" href="<?= $this->url('user_login') ?>">Connexion</a>
			<?php endif ; ?>
		</div>
	</div>
</header>

<!-- SIDE NAVIGATION -->
<section>
	<div class="sidenav">

		<!-- BUTTONS MENU -->
		<div class="col-xs-12">
			<a class="buttons btn btn-default btn-block" href="<?= $this->url('default_home') ?>">Accueil</a>
			<a class="buttons btn btn-default btn-block" href="<?= $this->url('user_admin') ?>">Ma page</a>
			<a class="buttons btn btn-default btn-block" href="<?= $this->url('user_video') ?>">Mes vidéos</a>
			<a class="buttons btn btn-default btn-block" href="<?= $this->url('user_comment') ?>">Mes commentaires</a>
		</div>

		<!-- CATEGORIES PANEL -->
		<div class="col-xs-12">
			<div class="panel panel-default">

				<!-- TITLE -->
				<div class="panel-heading">
					<h3 class="panel-title">Catégories :</h3>
				</div>

				<!-- CATEGORIES -->
				<div class="panel-body">
					<ul>
						<li><a href="#">Bricolage</a></li>
						<li><a href="#">Couture</a></li>
						<li><a href="#">Cuisine</a></li>
						<li><a href="#">Dessin</a></li>
						<li><a href="#">Jardinage</a></li>
						<li><a href="#">Informatique</a></li>
						<li><a href="#">Maquillage</a></li>
					</ul>
				</div>
			</div>
		</div>

	</div>
</section>

