<?php

namespace W\Controller;

use W\Security\AuthentificationModel;
use W\Security\AuthorizationModel;

//BASE CONTROLLER TO EXTEND
class Controller {

	//FOLDERS PATH VIEWS
	const PATH_VIEWS = '../app/Views';

	//GENERATE THE URL OF THE NAMED PATH
	public static function generateUrl($routeName, $params = array(), $absolute = false) {

		$params = (empty($params)) ? array() : $params;
		$app = getApp();
    	$router = $app->getRouter();
    	$routeUrl = $router->generate($routeName, $params);
		$url = $routeUrl;
		
		if($absolute) {
	    	$u = \League\Url\Url::createFromServer($_SERVER);
			$url = $u->getBaseUrl() . $routeUrl;
		}

		return $url;
	}

	//URI WHERE TO REDIRECT
	public function redirect($uri) {
		header("Location: $uri");
		die();	
	}

	//REDIRECT TO THE NAMED PATH
	public function redirectToRoute($routeName, array $params = array()) {
		$uri = $this->generateUrl($routeName, $params);
    	$this->redirect($uri);
	}

	//SHOW THE TEMPLATE
	public function show($file, array $data = array()) {

		//INCLUDE THE PATH TO THE VIEWS
		$engine = new \League\Plates\Engine(self::PATH_VIEWS);

		//LOAD THE EXTENSIONS
		$engine->loadExtension(new \W\View\Plates\PlatesExtensions());
		$app = getApp();

		//SHOW ONLY SOME DATAS
		$engine->addData([
				'w_user' 		  => $this->getUser(),
				'w_current_route' => $app->getCurrentRoute(),
				'w_site_name'	  => $app->getConfig('site_name'),
			]);

		//REMOVE THE .PHP EXTENSION
		$file = str_replace('.php', '', $file);

		//SHOW TEMPLATE
		echo $engine->render($file, $data);
		die();
	}

	//SHOW 403 PAGE
	public function showForbidden() {

		header('HTTP/1.0 403 Forbidden');
		$file = self::PATH_VIEWS.'/w_errors/403.php';

		if(file_exists($file)) {
			$this->show('w_errors/403');
		} else {
			die('403');
		}
	}

	//SHOW 404 PAGE
	public function showNotFound() {

		$file = self::PATH_VIEWS.'/w_errors/404.php';

		if(file_exists($file)) {
			$this->show('w_errors/404');
		} else {
			die('404');
		}	
	}

	//RETRIEVE THE LOGGED USER
	public function getUser() {
		$authenticationModel = new AuthentificationModel();
		$user = $authenticationModel->getLoggedUser();
		return $user;
	}

	//ALLOW ACCESS TO ONE OR MORE USERS
	public function allowTo($roles) {

		if (!is_array($roles)) {
			$roles = [$roles];
		}

		$authorizationModel = new AuthorizationModel();

		foreach($roles as $role) {
			if ($authorizationModel->isGranted($role)) {
				return true;
			}
		}
		$this->showForbidden();
	}

	//JSON RETURN
	public function showJson($data) {

		header('Content-type: application/json');
		$json = json_encode($data, JSON_PRETTY_PRINT);

		if($json) {
			die($json);
		} else {
			die('Error in json encoding');
		}
	}
}