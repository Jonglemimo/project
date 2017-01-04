<?php


	$w_routes = array(

	    ['GET',                 '/',                               'Default#home',                 'default_home'],

        //Connexion
        ['GET',			        '/logout',						   'User#logout',			       'user_logout'],
        ['GET|POST',		    '/signin',						   'User#signin',			       'user_login'],
        ['GET|POST',		    '/signup',						   'User#signup',			       'user_signup'],
        ['GET',                 '/signup/success',                 'User#success',                 'user_success'],

        //Reset password
        ['GET|POST',            '/signin/lost_pass',               'RecoveryToken#lostPassword',   'user_lostpass'],
        ['GET|POST',            '/signin/reset_pass/[:token]',     'RecoveryToken#resetPassword',  'user_resetpass'],

        //Administration
        ['GET|POST',            '/mapage',                         'User#userAdministration',      'user_admin'],
        ['GET|POST',            '/mapage/info',                    'User#userInfo',                'user_info'],
        ['GET',                 '/mapage/video',                   'User#userFullVideos',          'user_video'],
        ['GET',                 '/mapage/comment',                 'User#userFullComments',        'user_comment'],


        //Video
        ['GET|POST', 		    '/search',			               'Video#search', 		           'search'],
        ['GET|POST',            '/watch/[:shortTitle]',            'Video#watch',                  'watch'],
        ['GET|POST',            '/watchAjax',                      'Video#watchVideo',             'watch_ajax'],
        ['GET|POST',            '/mapage/video/delete',            'Video#deleteVideoById',        'delete_video'],
        ['GET|POST',            '/mapage/video/edit/[i:id]',       'Video#editVideo',              'edit_video'],
        ['GET|POST',            '/mapage/upload',                  'Video#uploadForm',             'upload_form'],
        ['GET|POST',            '/vote',                           'Video#vote',                   'vote'],
        ['GET|POST',            '/getVote',                        'Video#getVote',                'get_vote'],
        ['GET|POST',            '/updateVote',                     'Video#updateVote',             'update_vote'],


        //Catégories
        ['GET|POST',            '/categories/',                    'Categories#categories',        'categories_get'],
        ['GET',                 '/category/[:slug]',               'Categories#categoryVideos',    'category_videos'],

        //cron task

        ['GET',                 '/api/transcode',                  'Api#transcode',               'cron_transcode'],
        ['GET',                 '/api/get-percentage/[:id]',       'Api#getpercentage',           'get_percentage'],
        ['GET',                 '/recovery-tokens/delete',         'Api#deleteTokens',            'delete_recoveryTokens']


      
	);

