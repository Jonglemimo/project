<?php $this->layout('layout', ['title' => $video['title'],'categories' => $categories]) ?>

<?php $this->start('main_content') ?>
<input type="hidden" id="get_vote_route" value="<?= $this->url('get_vote') ?>">
<input type="hidden" id="get_note_route" value="<?= $this->url('get_note') ?>">
<input type="hidden" id="vote_update_route" value="<?= $this->url('update_vote') ?>">
<section id="watch">
<?php
	$url = $this->assetUrl('users/'.$video['userId'].'/'.$video['shortTitle'] .'/'.$video['url']);
	$poster = $this->assetUrl('users/'.$video['userId'].'/'.$video['shortTitle'] .'/'.$video['poster_lg']);?>
	<video class="video-js vjs-default-skin vjs-big-play-centered" id="mainVideo" controls preload="auto" data-stitle='<?= $video['shortTitle'] ?>' poster='<?= $poster ?>'>
        <source src='<?= $url ?>' type="video/webm">
        <p class="vjs-no-js">
            Pour regarder cette vidéo, activer JavaScript et mettez à jours votre Navigateur
            <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
        </p>
    </video>
	<h3>Mise en ligne par <?= $video['username'] ?></h3>
	<h5><?= $video['date_created'] ?></h5>

	<i style="font-size:1.5em;"	id="vote" data-vote='1' class="glyphicon glyphicon-star-empty"></i>
	<i style="font-size:1.5em;"	id="vote" data-vote='2' class="glyphicon glyphicon-star-empty"></i>
	<i style="font-size:1.5em;"	id="vote" data-vote='3' class="glyphicon glyphicon-star-empty"></i>
	<i style="font-size:1.5em;"	id="vote" data-vote='4' class="glyphicon glyphicon-star-empty"></i>
	<i style="font-size:1.5em;"	id="vote" data-vote='5' class="glyphicon glyphicon-star-empty"></i>
	<h4>Note moyenne : <span id="note"></span></h4>
	<div id="alertVote" class="alert-vote">
		<p id="alertMessage"></p>
	</div>
	

</section>

<section class="commentary">

	<form action="#" method="post">
		<label>Votre commentaire</label><br>
		<textarea name="comment" id="comment" rows="3"></textarea><br>
		<button id="btnComment" class="buttons btn btn-default" type="submit">Envoyer</button>
	</form>

    <div class="comment-content">
        
    </div>
</section>

<?php $this->stop('main_content') ?>
<?php $this->start('script')?>
<!-- VIDEO JS CDN -->
<script src="http://vjs.zencdn.net/5.8.8/video.js"></script>
<script>
    videojs('mainVideo',{},function () {
    })
</script>
<?php $this->stop('script')?>

