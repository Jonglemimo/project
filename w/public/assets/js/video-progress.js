$(function () {

    /*
     * On vérifie qu'il y a des elements en attente ou en cours d'encodage
     */

    var videoInterval = false;
    if($('#currentTranscoding').length >0){
        /*
         * si c'est le cas on demare un interval qui check toutes les 2 sec l'avancement du premier element dans la div videoEncoding
         * + animation de la progression
         */
        videoInterval = setInterval(function () {
            var id = parseInt($('#currentTranscoding .videoEncoding > div:first').attr('data-id'));
            if(isNaN(id)){
                $('#currentTranscoding').remove();
                clearInterval(videoInterval);
                $('h1:first').remove();
                return;
            }
            // check la progression de la video via la function get-percentage dans le controlleur API
            $.get(homeUrl + 'api/get-percentage/'+ id, function (data) {
                // on check les données reçu
                if(typeof data != 'undefined' && typeof data.percentage != 'undefined' && !isNaN(parseInt(data.percentage))){

                    var percent = parseInt(data.percentage),
                        // on défini notre element
                        element = $('#currentTranscoding .videoEncoding > div:first');
                        // On affiche le svg
                        element.find('.wrap-loader').removeClass('hide');
                        // on calcul la progression
                    var width = parseInt(element.width()) - (parseInt(element.width()) * (percent / 100));
                    element.find('.overlay').width(width + 'px');
                    if(percent >= 100){
                        //on supprime l'élèment quand le transcoding est terminé
                        setTimeout(function (){
                            element.remove();

                        },1000);
                    }
                }
            });
        }, 2000)
    }
});
