<?php
namespace Services;

use \GO\Scheduler;

class SchedulerService
{
    private $scheduler = false;


    function __construct()
    {
        $this->scheduler = new Scheduler(array(
            'emailFrom' => 'victor.tarrieu@yahoo.fr'
        ));
    }

    public function test(){

        $this->scheduler->call('test2')->every()->minute()->output('/Users/Helda/Sites/Formation/Cours/group-project/project/w/tmp/test.log');
        $this->scheduler->run();

         echo "Executed 1 job(s)";
    }

    public function test2(){
        mkdir('/Users/Helda/Sites/Formation/Cours/group-project/project/w/tmp/'.uniqid(),0775);
    }

}