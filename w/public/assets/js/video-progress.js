$(function () {
    var videoInterval = false;
    if($('#currentTranscoding').length >0){
        videoInterval = setInterval(function () {
            var id = parseInt($('#currentTranscoding .videoEncoding > div:first').attr('data-id'));
            if(isNaN(id)){
                $('#currentTranscoding').remove();
                clearInterval(videoInterval);
                return;
            }

            $.get(currentUrl + 'api/get-percentage/'+ id, function (data) {

                if(typeof data != 'undefined' && typeof data.percentage != 'undefined' && !isNaN(parseInt(data.percentage))){

                    var percent = parseInt(data.percentage),
                        element = $('#currentTranscoding .videoEncoding > div:first');
                        element.find('.wrap-loader').removeClass('hide');
                    var width = parseInt(element.width()) - (parseInt(element.width()) * (percent / 100));
                    element.find('.overlay').width(width + 'px');
                    if(percent >= 100){
                        setTimeout(function (){
                            element.remove();
                        },1000);
                    }
                }
            });
        }, 2000)
    }
});
