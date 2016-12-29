<?php
foreach ($categories as $category):?>
    <li><a href="<?=$this->url('category_videos',['name' => $category['name']])?>"><?=$category['name']?></a></li>
<?php endforeach; ?>