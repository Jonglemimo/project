<?php $this->layout('layout', ['title' => 'Ma page']);
$this->start('main_content');?>
    <a href="<?=$this->url('user_info')?>">Mes infos</a>
    <h4>Mes vidéos</h4>

    <section class="container-fluid videoContainer">
        <?php if(is_array($videos)):?>
            <div class="row col-md-12">
                <?php foreach ($videos as $video):?>
                <div class="col-md-4 col-md-push-2 text-center">
                    <video src="<?=$video['url']?>" controls></video>
                    <p><?=$video['title'] ?></p>
                    <p><?=$video['description'] ?></p>
                </div>
                <?php endforeach;?>
                <a href="<?=$this->url('user_video')?>" class="col-md-offset-7">Voir plus</a>
            </div>
        <?php else: echo $videos ?>
        <?php endif; ?>
    </section>

    <section class="container-fluid">
        <h4>Mes derniers commentaires</h4>
        <?php if(isset($comments)):?>
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
            <a href="<?=$this->url('user_comment')?>" class = "col-md-offset-7">Voir plus</a>
        <?php endif; ?>
    </section>

<?php $this->stop('main_content') ?>