

var upload = {
    files : [],
    checkParams : function (data) {
        if(typeof data == 'undefined' || typeof data.files != 'object'){
            return true;
        }
        var error = false;
        this.files.forEach(function (file) {
           if(file.files[0].name == data.files[0].name)
               error = true;
        });
        return error;
    },
    process : function () {
        var html = '';
        for(var key in upload.files){
            file = upload.files[key].files[0];
            html += '<li data-name="'+file.name+'" data-index="'+key+'">' + '<span>' + file.name + '</span><span>' + file.type +'</span><span>' + parseFloat(file.size /1024/1024).toFixed(2) + ' mo</span>' + '<i class="glyphicon glyphicon-trash removeItem"></i> <span class="progress hide"><span class="progress-bar progress-bar-info progress-bar-striped"></span></span></li>';
        };
        console.log('process');
        $('#listItems').html(html).removeClass('hide');
    },
    timeout : false
};

$(function () {
    $(document).on('click','.removeItem',function () {
        var index = parseInt($(this).parent().attr('data-index'));
        if(!isNaN(index)){
            upload.files.splice(index,1);
            upload.process();
        }
    });

    $(document).on('submit','#formUpload',function (e) {
        e.preventDefault();
        upload.files.forEach(function (file) {
            file.submit();
        })
    });

    $('#fileupload').fileupload({
        dataType: 'json',
        add: function (e,data) {
            if(upload.checkParams(data)){
                console.error('parametre erreur');
                return;
            }
            upload.files.push(data);
            console.log(data);

            if(upload.timeout)
                clearTimeout(upload.timeout);

            upload.timeout = setTimeout(upload.process,500);

        },
        done: function (e, data) {

            console.log(e);
            console.log(data);
        },
        progress: function (e,data) {

            var element = $('#listItems').find('li[data-name="'+data.files[0].name+'"] > .progress');
            if(element.length > 0){
                if(element.hasClass('hide')){
                    element.removeClass('hide');
                }
                var percent = parseInt(data.loaded / data.total * 100, 10);
                element.children().css('width', percent + '%');
            }
        }
    });
});