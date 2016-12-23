<?php
	
	$w_routes = array(
		['GET|POST', '/', 'Default#home', 'default_home'],

		['GET|POST', '/search', 'Video#search', 'search'],
        ['GET|POST',			'/signin',							'User#signin',			'user_login'],
        ['GET|POST',			'/signup',							'User#signup',			'user_signup'],
        ['GET',                 '/signup/success',                  'User#sucess',          'user_success']

	);