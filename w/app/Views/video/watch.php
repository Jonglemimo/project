<?php $this->layout('layout', ['title' => $video['title']]) ?>

<?php $this->start('main_content') ?>
<section id="watch">
<?php
	$title = $video['title'];
	$url = $this->assetUrl('uploads/videos/'.$video['url']);
	$poster = $this->assetUrl('uploads/images/medium/'.$video['poster']);?>
	<br>
	<video src='<?= $url ?>' controls poster='<?= $poster ?>'></video>
	<h3>Mise en ligne par <?= $video['username'] ?></h3>
	<h5><?= $video['date_created'] ?></h5>
</section>

<section class="commentary">

	<form action="#" method="post">
		<label>Votre commentaire</label>
		<textarea name="" id="" rows="3"></textarea>
		<button class="buttons btn btn-default" type="submit">Envoyer</button>
	</form>

    <div class="comment-content">
        <ul><!-- Comments here --></ul>
    </div>
</section>

<?php $this->stop('main_content') ?>