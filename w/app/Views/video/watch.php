<?php $this->layout('layout', ['title' => $video['title']]) ?>

<?php $this->start('main_content') ?>
<input type="hidden" id="get_vote_route" value="<?= $this->url('get_vote') ?>">
<section id="watch">
<?php
	$url = $this->assetUrl('users/'.$video['userId'].'/'.$video['shortTitle'] .'/'.$video['url']);
	$poster = $this->assetUrl('users/'.$video['userId'].'/'.$video['shortTitle'] .'/'.$video['poster_lg']);?>
	<video id="mainVideo" src='<?= $url ?>' controls data-stitle='<?= $video['shortTitle'] ?>' poster='<?= $poster ?>'></video>
	<h3>Mise en ligne par <?= $video['username'] ?></h3>
	<h5><?= $video['date_created'] ?></h5>
	<i style="font-size:1.5em;"	id="vote" data-vote='1' class="glyphicon glyphicon-star-empty"></i>
	<i style="font-size:1.5em;"	id="vote" data-vote='2' class="glyphicon glyphicon-star-empty"></i>
	<i style="font-size:1.5em;"	id="vote" data-vote='3' class="glyphicon glyphicon-star-empty"></i>
	<i style="font-size:1.5em;"	id="vote" data-vote='4' class="glyphicon glyphicon-star-empty"></i>
	<i style="font-size:1.5em;"	id="vote" data-vote='5' class="glyphicon glyphicon-star-empty"></i>
	
	<div id="alertVote" class="alert-vote">
		<p id="alertMessage"></p>
	</div>
	
</section>
<section class="commentary">
	
</section>
<?php $this->stop('main_content') ?>