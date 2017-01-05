<?php
	foreach ($comments as $comment) : ?>
	
	<!-- COMMENTS APPEARING UNDER FULL VIDEO PAGE -->
	<div class="watch-comments">
		<div class="avatar-comments">
			<!-- USER AVATAR -->
			<img src="http://i2.kym-cdn.com/entries/icons/original/000/020/641/DVA.png" alt="Votre avatar">
	    </div>
		
		<!-- DATE OF THE COMMENT AND AUTHOR -->
		<div class="date-user-comments">
	        <h5 class="title-date">Le <span class="date"><?= $comment['date_posted'] ?></span></h5>

			<h5>Par <p><?= $comment['username'] ?></p></h5>
		</div>
		
		<!-- COMMENT CONTENT -->
        <p class="text-comments"><?= $comment['content'] ?></p>
    </div>

	<?php endforeach;?>