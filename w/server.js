var cron = require('node-cron'),
    child_process = require('child_process'),
    path = __dirname + '/app/cron.php';

cron.schedule('* * * * *', function(){
    console.log(path);
     child_process.spawn('php',[path]);
    /*console.log(path);*/
});