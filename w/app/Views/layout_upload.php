<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $this->e($title) ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">
    <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="<?= $this->assetUrl('vendors/jQuery-File-Upload/css/jquery.fileupload.css')?>">
    <link rel="stylesheet" href="<?= $this->assetUrl('vendors/jQuery-File-Upload/css/jquery.fileupload-ui.css')?>">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="<?=$this->assetUrl('vendors/jQuery-File-Upload/css/jquery.fileupload-noscript.css')?>"></noscript>
    <noscript><link rel="stylesheet" href="<?=$this->assetUrl('vendors/jQuery-File-Upload/css/jquery.fileupload-ui-noscript.css')?>"></noscript>

</head>
<body>
<div class="container">
    <header>
        <h1>W :: <?= $this->e($title) ?></h1>
    </header>

    <section class=" container">
        <?= $this->section('main_content') ?>
    </section>

    <footer>
    </footer>
</div>

</body>
</html>