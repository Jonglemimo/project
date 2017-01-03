<?php
foreach ($categories as $category):?>
    <li><a href="<?=$this->url('category_videos',['slug' => $category['slug']])?>"><?=$category['name']?></a></li>
<?php endforeach; ?>