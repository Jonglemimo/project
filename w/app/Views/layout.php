<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">
</head>
<body>
	<div class="container row">
		<header class="col-md-12">
            <div class="col-md-4">
			    <h2><?= $this->e($title) ?></h2>
            </div>
            <div class="col-md-4">
                <input class="form-control" type="text" placeholder="recherche ...">
            </div>
            <div class="col-md-4">
                <?php if(isset($_SESSION['user'])):?>
                    <a href="<?=$this->url('user_logout')?>" class="btn btn-default">Déconnexion</a>
                <?php else: ?>
                    <a href="<?=$this->url('user_login')?>" class="btn btn-default">Connexion</a>
                <?php endif; ?>
            </div>
		</header>

		<section>
			<?= $this->section('main_content') ?>
		</section>

		<footer>
		</footer>
	</div>
    <script>
        <?= $this->section('script')?>
    </script>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="<?= $this->assetUrl('js/script.js') ?>"></script>
</body>
</html>