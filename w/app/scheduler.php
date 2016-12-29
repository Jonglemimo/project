<?php

use \GO\Scheduler;

require_once __DIR__.'/../vendor/autoload.php';

$sheduler = new Scheduler(array(
    'emailFrom' => 'victor.tarrieu@yahoo.fr'
));

function test2(){
    mkdir('/Users/Helda/Sites/Formation/Cours/group-project/project/w/tmp/'.uniqid(),0775);
}

$sheduler->call('test2')->every()->minute()->output('/Users/Helda/Sites/Formation/Cours/group-project/project/w/tmp/test.log');
$sheduler->run();
