

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
    timeout : false,
    validateForm : function () {
      /*  if(this.files.length != 2){
            console.error('vous devez uploader une image et une vidéo uniquement');
            return false;
        }*/
       /* var type = {
            image : false,
            video : false,
            regexImg : /image/gi,
            regexVideo : /video/gi
        };

        this.files.forEach(function (file) {
            file = file.files[0];
            if(type.regexImg.test(file.type)){
                type.image = true;
            }else if(type.regexVideo.test(file.type)){
                type.video = true;
            }
        });
        if(!type.image || !type.video){
            console.error('Les fichiers ne sont pas valides');
            return false;
        }*/

        return true;

    },
    sendForm : function () {
        if($('#imageFile').val() == '' || $('#videoFile').val() == '' ){
            return;
        }

        $.post(currentUrl + 'upload',{
            'title' : $('input[name="title"]').val(),
            'description' : $('textarea[name="description"]').val(),
            'image' : $('#imageFile').val(),
            'video' : $('#videoFile').val()
        }, function (data) {
            console.log(data);
        });
    }
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
            if(upload.validateForm()){
                file.submit();
            }
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
            if(data.result.success){
                console.log('upload réussi');
                if(data.result.type == 'unknown'){
                    console.error('type de fichier inconnu');
                    return;
                }
                var element = data.result.type == 'image' ? $('#imageFile') : $('#videoFile');
                element.val(data.result.file);
                upload.sendForm();
            }else{
                console.error('erreur lors de l\'upload du fichier: ' + data.files[0].name);
            }
          console.log('done',data);
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