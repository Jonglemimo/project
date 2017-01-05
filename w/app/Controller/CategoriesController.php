<?php
namespace Controller;

use Model\CategoriesModel;

class CategoriesController extends \Controller\DefaultController {

    public function categoryVideos($slug){

        $category = new CategoriesModel();
        $videosByCategory =$category->getVideoByCategories($slug);
        $this->show('video/category', ['videosByCategory' => $videosByCategory , 'currentCategory' => $slug]);
    }


}

