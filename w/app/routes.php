<?php
	
	$w_routes = array(
		['GET',                 '/',                                'Default#home',         'default_home'],

        ['GET|POST',			'/signin',							'User#signin',			'user_login'],
        ['GET|POST',			'/signup',							'User#signup',			'user_signup'],
        ['GET',                 '/signup/success',                  'User#sucess',          'user_success']
	);