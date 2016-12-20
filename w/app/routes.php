<?php
	
	$w_routes = array(
		['GET',                 '/',                                'Default#home',         'default_home'],

        ['GET|POST',			'/signin',							'User#login',			'user_login'],
        ['GET|POST',			'/signup',							'User#signup',			'user_signup'],

	);