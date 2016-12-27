<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= $this->e($title) ?></title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Pacifico" rel="stylesheet">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">
</head>
<body>
<header>
	<!-- HEADER BAR -->
	<nav class="navbar navbar-fixed-top" id="header-bar">
		<div class="container-fluid">
			<div class="row">

			<!-- NAVIGATION BAR BUTTON -->
			<div id="nav-bar-button-col" class="navbar-header col-xs-2 visible-xs">
				<button type="button" id="buttons" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#side-nav-button-mobile" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<!-- WEBSITE LOGO -->
			<div class="navbar-header col-xs-5 col-sm-3">
				<a id="website-title" class="navbar-brand" href="<?= $this->url('default_home') ?>">Tutomotion</a>
			</div>

			<!-- SEARCH BAR AND CONNEXION BUTTONS MOBILES -->
			<div id="header-buttons-mobile" class="col-xs-5 visible-xs text-right">
				<!-- SEARCH -->
				<button type="button" id="buttons" class="header-button btn btn-default" data-toggle="collapse" href="#search-form-mobile" aria-expanded="false" aria-controls="search-form-mobile">
					<i class="visible-xs visible-sm glyphicon glyphicon-search"></i>
				</button>

				<!-- CONNEXION -->
				<button type="button" id="buttons" class="btn btn-default" data-toggle="collapse" href="#login-buttons-mobile" aria-expanded="false" aria-controls="login-buttons-mobile">
					<i class="visible-xs visible-sm glyphicon glyphicon-user"></i>
				</button>
			</div>
			
			<!-- SEARCH BAR AND CONNEXION BUTTONS COMPUTERS -->
			<div class="col-xs-6 col-sm-9 hidden-xs">
				<form class="navbar-form" action="#" method="POST" >
					<div class="row">
						<!-- SEARCH -->
						<div class="form-group text-center col-xs-6" >
							<input type="text" class="form-control" name="search" id="search" placeholder="Search">
							<button type="submit" id="buttons" class="btnSearch search-button-computer btn btn-default glyphicon glyphicon-search"></button>
						</div>

						<!-- CONNEXION -->
						<div class="form-group text-right col-xs-6">
							<button type="button" id="buttons" class="btn btn-default">Inscription</button>
							<button type="button" id="buttons" class="btn btn-default">Connexion</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</nav>

	<!-- COLLAPSE SEARCH BAR AND SIGNIN/LOGIN BUTTON MOBILES -->
	<!-- SEARCH -->
	<div class="collapse navbar-fixed-top" id="search-form-mobile">
		<div class="text-center">
			<input type="text" class="form-control" placeholder="Search">
			<button type="submit" id="buttons" class="search-button-mobile btn btn-default glyphicon glyphicon-search"></button>
		</div>
	</div>
	<!-- CONNEXION -->
	<div class="collapse navbar-fixed-top" id="login-buttons-mobile">
		<div class="text-center">
			<button type="button" id="buttons" class="login-signin-button btn btn-default">Inscription</button>
			<button type="button" id="buttons" class="login-signin-button btn btn-default">Connexion</button>
		</div>
	</div>
</header>

<!-- SIDE NAVIGATION -->
<section class="collapse navbar-collapse" id="side-nav-button-mobile">
	<div class="side-nav navbar-fixed-top">
		
		<!-- BUTTONS MENU -->
		<div class="col-xs-12">
			<button class="btn btn-default btn-block" type="submit" id="home">Accueil</button>
			<button class="btn btn-default btn-block" type="submit" id="page">Ma page</button>
			<button class="btn btn-default btn-block" type="submit"	id="videos">Mes vidéos</button>
			<button class="btn btn-default btn-block" type="submit" id="comment">Mes commentaires</button>
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
						<li><a href="#">Dessin</a></li>
						<li><a href="#">Maquillage</a></li>
						<li><a href="#">Informatique</a></li>
						<li><a href="#">Jardinage</a></li>
						<li><a href="#">Cuisine</a></li>
					</ul>
				</div>
			</div>
		</div>

	</div>
</section>
