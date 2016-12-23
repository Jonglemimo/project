<?php
	
	$w_routes = array(
		['GET',                 '/',                               'Default#home',            'default_home'],

        //Connexion
        ['GET',					'/logout',							'User#logout',			  'user_logout'],
        ['GET|POST',			'/signin',						   'User#signin',			  'user_login'],
        ['GET|POST',			'/signup',						   'User#signup',			  'user_signup'],
        ['GET',                 '/signup/success',                 'User#success',            'user_success'],

        //Administration
        ['GET|POST',            '/mapage',                         'User#userAdministration',   'user_admin'],
        ['GET',                 '/mapage/video',                   'User#userFullVideos',        'user_video'],
        ['GET',                 '/mapage/comment',                 'User#userFullComments',   'user_comment'],


        //Video
        ['GET|POST',            '/upload',                         'Upload#uploadForm',       'upload_form'],


	);