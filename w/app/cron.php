<?php

require_once __DIR__.'/../vendor/autoload.php';


$crontab = new \HybridLogic\Cron\Crontab;

function test2(){
    mkdir('/Users/Helda/Sites/Formation/Cours/group-project/project/w/tmp/'.uniqid(),0775);
}

$crontab->add_job(
    \HybridLogic\Cron\Job::factory('test')
        ->on('* * * * *')
        ->trigger(function(){
            test2();
        })
);

$crontab->add_job(
    \HybridLogic\Cron\Job::factory('autre')
        ->on('*/2 * * * *')
        ->trigger(function(){
            mkdir('/Users/Helda/Sites/Formation/Cours/group-project/project/w/tmp/test',0775);
        })
);

$count = $crontab->run();
echo "Executed $count job(s)";