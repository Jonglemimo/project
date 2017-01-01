<?php

namespace Controller;

use \W\Controller\Controller;
use \Model\CategoriesModel;

class DefaultController extends Controller {

	//DEFAULT HOMEPAGE
	public function home() {
		$this->show('default/home');
	}
}