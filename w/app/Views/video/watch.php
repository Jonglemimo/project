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
	
</section>
<?php $this->stop('main_content') ?>