<?php

//CLASSES AUTOLOAD
require '../vendor/autoload.php';

//CONFIGURATION
require '../app/config.php';

//RARES GLOBAL FUNCTIONS
require '../W/globals.php';

//INSTANCE OUR APPLICATION WITH CONFIGURATIONS AND ROUTES
$app = new W\App($w_routes, $w_config);

//APPLICATION EXECUTION
$app->run();