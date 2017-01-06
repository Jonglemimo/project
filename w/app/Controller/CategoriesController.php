<?php
namespace Controller;

use Model\CategoriesModel;

class CategoriesController extends \Controller\DefaultController {

    public function categoryVideos($slug,$page = false){

        $category = new CategoriesModel();
        $totalVideos = (int)$category->getTotalVideos()['total'];
        $totalPages = ceil($totalVideos/$this->nbElements);

        if($page !== false){
            $page = (int)$page;
        }

        if($page === 0){
            $this->showNotFound();
        }else if($page === 1){

           $this->redirectToRoute('category_videos',['slug' => $slug]);
        }else if($page > $totalPages){
            $this->showNotFound();
        }

        if($page === false){
            $page = 1;
        }

        $offset  = $page * $this->nbElements - $this->nbElements;

        $videosByCategory =$category->getVideoByCategories($slug,$offset,$this->nbElements);
        $this->show('video/category', ['videosByCategory' => $videosByCategory , 'currentCategory' => $slug, 'pagination' => array('total' => $totalPages, 'current' => $page   )]);
    }


}

