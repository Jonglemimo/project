

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
            html += '<li class ="alert alert-success list-unstyled " data-name="'+file.name+'" data-index="'+key+'">' + '<span class="black"> Nom du fichier : </span><span>' + file.name + ' </span><span class="black"> | Type du fichier : </span><span>' + file.type +'</span><span class="black"> | Taille du fichier :</span><span> ' + parseFloat(file.size /1024/1024).toFixed(2) + ' mo</span>' + '<i class="glyphicon glyphicon-trash removeItem pull-right"></i><div class="progress hide "><div class="progress-bar progress-bar-info progress-bar-striped progressBar "></div></div></li>';
        };

        $('#listItems').html(html).removeClass('hide');
    },
    timeout : false,
    validateForm : function () {
        var error = '';
        if($('.title').val().length < 5){
            error += 'Votre titre doit être supérieur à 5 caractères <br>';

        }

        if($('.category').val() == 'first'){
            error+= 'Vous devez choisir une catégorie <br>'
        }

        if($('.description').val().length < 20){
            error += 'Votre description doit être supérieur à 20 caractères';

        }

        if(error.length > 0){
            $('#empty').html(error).removeClass('hide').addClass('alert alert-danger');

        }else {
            $('#empty').addClass('hide')
        }


       if(this.files.length > 2){

           $('#status').html('vous devez uploader une image et une vidéo uniquement').removeClass('hide').addClass('alert alert-danger');

           var notGoodNumber = true

        }else if(this.files.length < 2){
           $('#status').html('vous devez uploader une image et une vidéo').removeClass('hide').addClass('alert alert-danger');

            var notGoodNumber = true
       }else {
           $('#status').addClass('hide')
       }

       if(error.length > 0 || notGoodNumber == true){
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
            $('#status').html('Les fichiers ne sont pas valides').removeClass('hide').addClass('alert alert-danger');
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
            $('#result').html('L\'upload s\'est bien terminé').removeClass('hide').addClass('alert alert-success');
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

        if(type.regexImg.test(upload.files[0].files[0].type)){
            var statusButton = 'Envoyer une vidéo'

        }else {
            var statusButton = 'Envoyer une image'
        }

        $('#submitUploadForm').html('<label id="uploadButton" for="files"><i class="glyphicon glyphicon-open"></i><span id="UploadText">'+statusButton+'</span><input class="form-control" data-url="'+uploadUrl+'" id="fileupload" type="file" name="files[]" multiple></label><p>(Merci d\'upload une vidéo ainsi qu\'une image la représentant)</p>');

        var index = parseInt($(this).parent().attr('data-index'));
        if(!isNaN(index)){
            upload.files.splice(index,1);
            upload.process();
        }

        console.log(upload);

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
                $('.status').html('Erreur de paramétrage').removeClass('hide').addClass('alert alert-danger');
                return;
            }

            var type = {
                regexImg : /image/gi,
                regexVideo : /video/gi
            };

            if(type.regexImg.test(data.files[0].type) && upload.files.length == 0){
                $('#UploadText').html('Envoyer une vidéo');
                $('#order').addClass('hide');

            }

            if (type.regexVideo.test(data.files[0].type) && upload.files.length == 0){

                $('#order').html('vous devez envoyer une image en premier').removeClass('hide').addClass('alert alert-danger');
                return;
            }

            upload.files.push(data);


            if(upload.files.length == 2){
                $('#submitUploadForm').html(' <button type="submit" class="buttons btn btn-default">Envoyer</button>')
            }

            if(upload.timeout)
                clearTimeout(upload.timeout);

            upload.timeout = setTimeout(upload.process,500);

        },
        done: function (e, data) {
            if(data.result.success){

                if(data.result.type == 'unknown'){
                    $('.status').html('type de fichier inconnu').removeClass('hide').addClass('alert alert-danger');
                    return;
                }
                var element = data.result.type == 'image' ? $('#imageFile') : $('#videoFile');
                element.val(data.result.file);
                upload.sendForm();
            }else{
                $('.status').html('erreur lors de l\'upload du fichier: '+data.files[0].name +'').removeClass('hide').addClass('alert alert-danger');
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