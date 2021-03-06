<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- FAVICON -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $this->assetUrl('favicons/apple-touch-icon.png')?>">
    <link rel="icon" type="image/png" href="<?= $this->assetUrl('favicons/favicon-32x32.png')?>" sizes="32x32">
    <link rel="icon" type="image/png" href="<?= $this->assetUrl('favicons/favicon-16x16.png')?>" sizes="16x16">
    <link rel="manifest" href="<?= $this->assetUrl('favicons/manifest.json')?>">
    <link rel="mask-icon" href="<?= $this->assetUrl('favicons/safari-pinned-tab.svg')?>" color="#2be9b9">
    <meta name="theme-color" content="#ffffff">

    <title><?= $title ?></title>

    <!-- BOOTSTRAP 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- CUSTOM FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600i,700|Roboto+Condensed:400,700|Pacifico" rel="stylesheet">
    <!-- CUSTOM CSS -->
    <link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">

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
                                <input type="text" id="search" class="body-inputs form-control" placeholder="Rechercher">
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
            <input type="text" id="search" class="body-inputs form-control" placeholder="Rechercher">
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
            <?php if(isset($_SESSION['user'])): ?>
            <a class="buttons btn btn-default btn-block" href="<?= $this->url('user_video') ?>">Mes vidéos</a>
            <a class="buttons btn btn-default btn-block" href="<?= $this->url('user_comment') ?>">Mes commentaires</a>
            <?php endif ; ?>
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
                    <ul class="categories">
                        <?php foreach ($categories as $category):?>
                        <li><a href="<?=$this->url('category_videos',['slug' => $category['slug']])?>"><?=$category['name']?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
    <input id="category" type="hidden" value="<?= $this->url('categories_get')?>">
	<input type="hidden" id="watch_route" value="<?= $this->url('watch') ?>">
	<input type="hidden" id="ajax_search_route" value="<?= $this->url('search') ?>">
    <input type="hidden" id="vote_route" value="<?= $this->url('vote') ?>">

	<section class="body body-padding">
		<section>
			<?= $this->section('main_content') ?>
		</section>
	</section>

<footer class="footer footer-padding">

    <div class="footer-copyright">
        <p>© Tutomotion 2017</p>
    </div>

    <div class="footer-links">
        <a href="<?=$this->url('default_condition')?>">Conditions d'utilisation</a>
        -
        <a href="<?=$this->url('default_confidentialite')?>">Confidentialité</a>
        -
        <a href="<?=$this->url('user_contact')?>">Nous contacter</a>
    </div>

</footer>

<script>
    var homeUrl = '<?= $this->url('default_home')?>';
    window.HELP_IMPROVE_VIDEOJS = false;
</script>
<!-- JQUERY 3.1.1 -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
<!-- BOOTSTRAP CDN 3.3.7 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- PERSONAL SCRIPTS -->
<script src="<?= $this->assetUrl('js/script.js') ?>"></script>
<?= $this->section('script') ?>
</body>
</html>


