<?php

$this->layout('layout', ['title' => 'Mes commentaires']);
$this->start('main_content');?>

    <section class="container-fluid">

    <?php if(is_array($comments)):?>
        <?php foreach ($comments as $comment):?>

            <div class='col-md-12'>
                <div class="col-md-8">
                    <video src="<?=$comment['url']?>" controls></video>
                </div>

                <div class="col-md-4  col-md-offset-4">
                    <p>Titre : <?=$comment['title'] ?></p>
                    <p>Commentaire : <?=$comment['content']?></p>
                </div>
            </div>

        <?php endforeach;?>
        <?php else: ?>

        <p><?=$comments?></p>
        
    <?php endif; ?>
</section>

<?php $this->stop('main_content') ?>