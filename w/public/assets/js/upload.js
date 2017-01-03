

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
            html += '<li class="list-unstyled" data-name="'
                + file.name + '"data-index="'
                + key + '">' + '<div class="upload-line"><span class="upload-name"> Nom du fichier :</span><p>'
                + file.name + '</p><span class="upload-name">| Type du fichier :</span><p>'
                + file.type +'</p><span class="upload-name">| Taille du fichier :</span><p> '
                + parseFloat(file.size /1024/1024).toFixed(2) + 'mo</p>'
                + '<button class="buttons btn btn-default removeItem"><i class="glyphicon glyphicon-trash"></i></button></div><div class="progress hide"><div class="progress-bar progress-bar-success progress-bar-striped progressBar" role="progressbar"></div></div></li>';
        };


        $('#listItems').html(html).removeClass('hide');
    },
    timeout : false,
    validateForm : function () {
        var error = '';
        if($('.title').val().length < 5){
            error += '<p class="what">Votre titre doit être supérieur à 5 caractères</p>';

        }

        if($('.category').val() == 'first'){
            error+= '<p class="what">Vous devez choisir une catégorie</p>'
        }

        if($('.description').val().length < 20){
            error += '<p class="what">Votre description doit être supérieur à 20 caractères</p>';

        }

        if(error.length > 0){
            $('#empty').html(error).removeClass('hide');

        } else {
            $('#empty').addClass('hide')
        }


       if(this.files.length > 2){

           $('#status').html('<p class="meh">Vous devez uploader une image et une vidéo uniquement</p>').removeClass('hide');

           var notGoodNumber = true

        }else if(this.files.length < 2){
           $('#status').html('<p class="meh">Vous devez uploader une image et une vidéo</p>').removeClass('hide');

            var notGoodNumber = true
       } else {
           $('#status').addClass('hide')
       }

       if(error.length > 0 || notGoodNumber == true) {
            return false;
       }

       var type = {
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
            $('#status').html('<p class="false">Les fichiers ne sont pas valides</p>').removeClass('hide');
            return false;
        }

        return true;

    },
    sendForm : function () {
        if($('#imageFile').val() == '' || $('#videoFile').val() == '' ){
            return;
        }

        $.post(currentUrl + '/mapage/upload',{
            'title' : $('input[name="title"]').val(),
            'description' : $('textarea[name="description"]').val(),
            'image' : $('#imageFile').val(),
            'video' : $('#videoFile').val(),
            'category': $('.category').val()
        }, function (data) {
            if(data.success == true)
            $('#result').html('<p class="correct">L\'upload s\'est bien terminé</p>').removeClass('hide');
            setTimeout(function()
            {
                window.location.reload();

            }, 2000);
        });
    }
};

$(function () {

    $(document).on('click','.removeItem',function () {

        var type = {
            regexImg : /image/gi,
            regexVideo : /video/gi
        };

        $('#submitUploadForm').removeClass('hide');
        $('#submitBtn').addClass('hide');

        var index = parseInt($(this).parent().parent().attr('data-index'));
        if(!isNaN(index)){
            upload.files.splice(index,1);
            upload.process();
        }

        if(upload.files.length == 1 && type.regexVideo.test(upload.files[0].files[0].type)){
            $('#UploadText').html('Envoyer une image');
        }else{
            $('#UploadText').html('Envoyer une vidéo');
        }

        if(upload.files.length == 0){
            $('#UploadText').html('Envoyer une image');
        }


    });

    $(document).on('submit','#formUpload',function (e) {
        e.preventDefault();

        if(upload.validateForm()){
            upload.files.forEach(function (file) {
                file.submit();
            });
        };
    });

    $('#fileupload').fileupload({
        dataType: 'json',
        add: function (e,data) {
            if(upload.checkParams(data)){
                $('.status').html('<p class="false">Erreur de paramétrage</p>').removeClass('hide');
                return;
            }

            var type = {
                regexImg : /image/gi,
                regexVideo : /video/gi
            };

            if(type.regexImg.test(data.files[0].type) && upload.files.length == 0) {
                $('#UploadText').html('Envoyer une vidéo');
                $('#order').addClass('hide');

            }

            if (type.regexVideo.test(data.files[0].type) && upload.files.length == 0) {

                $('#order').html('<p class="what">Vous devez envoyer une image en premier</p>').removeClass('hide');
                return;
            }

            upload.files.push(data);


            if(upload.files.length == 2){
                $('#submitBtn').removeClass('hide');
                $('#submitUploadForm').addClass('hide');
            }

            if(upload.timeout)
                clearTimeout(upload.timeout);

            upload.timeout = setTimeout(upload.process,500);

        },
        done: function (e, data) {
            if(data.result.success){

                if(data.result.type == 'unknown'){
                    $('.status').html('<p class="what">Type de fichier inconnu</p>').removeClass('hide');
                    return;
                }
                var element = data.result.type == 'image' ? $('#imageFile') : $('#videoFile');
                element.val(data.result.file);
                upload.sendForm();
            }else{
                $('.status').html('<p class="false">Erreur lors de l\'upload du fichier: ' + data.files[0].name + ' </p>').removeClass('hide');
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