<?php
namespace Controller;

use Model\CategoriesModel;
use W\Controller\Controller;

class CategoriesController extends Controller
{

    public function categories(){
        $category = new CategoriesModel();
        $categories = $category->getCategories();
        $this->show('default/categories', ['categories' => $categories]);
    }

    public function categoryVideos($category){
        $category = new CategoriesModel();
        $videosByCategory =$category->getVideoByCategories($category);
        $this->show('video/category', ['videosByCategory' => $videosByCategory]);
    }
}

