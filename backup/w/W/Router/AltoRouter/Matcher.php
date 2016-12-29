<?php

namespace W\Router\AltoRouter;

class Matcher {

	//LOOK FOR A CORRESPONDENCE BETWEEN URL AND ROUTES AND CALL THE RIGHT METHOD
	public function match() {
		$router = getApp()->getRouter();
		$match = $router->match();

		if ($match) {

			$callableParts = explode('#', $match['target']);
			$controllerName = ucfirst(str_replace('Controller', '', $callableParts[0]));
			$methodName = $callableParts[1];
			$controllerFullName = 'Controller\\'.$controllerName.'Controller';
			
			$controller = new $controllerFullName();
			
			call_user_func_array(array($controller, $methodName), $match['params']);
		}
		//404
		else {
			$controller = new \W\Controller\Controller();
			$controller->showNotFound();
		}
	}
}