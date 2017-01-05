<?php
	foreach ($comments as $comment) : ?>
        <p><?php echo $comment['date_posted']?></p>
        <p><?php echo $comment['username'] ?></p>
        <p><?php echo $comment['content'] ?></p>
	<?php endforeach;?>