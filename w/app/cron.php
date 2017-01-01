<?php

require_once __DIR__.'/../vendor/autoload.php';


$crontab = new \HybridLogic\Cron\Crontab;

function transcoding(){

    $ch = curl_init();

// set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, "http://localhost/Formation/Cours/group-project/project/w/public/api/transcode");
    curl_setopt($ch, CURLOPT_HEADER, 0);

// grab URL and pass it to the browser
    curl_exec($ch);

// close cURL resource, and free up system resources
    curl_close($ch);
}

function deleteRecoveryTokens(){

    $ch = curl_init();

// set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, "http://localhost/Formation/Cours/group-project/project/w/public/recovery-tokens/delete");
    curl_setopt($ch, CURLOPT_HEADER, 0);

// grab URL and pass it to the browser
    curl_exec($ch);

// close cURL resource, and free up system resources
    curl_close($ch);
}

$crontab->add_job(
    \HybridLogic\Cron\Job::factory('test')
        ->on('* * * * *')
        ->trigger(function(){
            transcoding();
        })
);

$crontab->add_job(
    \HybridLogic\Cron\Job::factory('test')
        ->on('*/30 * * * *')
        ->trigger(function(){
            deleteRecoveryTokens();
        })
);

$crontab->run();