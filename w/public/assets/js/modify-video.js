function validateForm () {
    var error = '';

    if($('.title').val().length < 5){

        error += '<p class="false">Votre titre doit être supérieur à 5 caractères</p>';

    }

    if($('.description').val().length < 20){

        error += '<p class="what">Votre description doit être supérieur à 20 caractères</p>';

    }

    if($('.category').val().length = 0){

        error += '<p class="meh">Vous devez renseigner une catégorie</p>';
    }

    if(isNaN($('.category').val())){

        error += '<p class="false">Cette catégorie n\'existe pas</p>';
    }

    if(error.length > 0){

        $('#empty').html(error).removeClass('hide').addClass('alert alert-danger');

    }else {

        $('#empty').addClass('hide');
        return true
    }

}

$(function () {
    $(document).on('submit','#edit', function (e) {
        e.preventDefault();

        if(validateForm()){

            var modifyUrl = $('#modifyUrl').val();

            $.post(modifyUrl, {
                'title': $('input[name="title"]').val(),
                'description': $('textarea[name="description"]').val(),
                'category': $('.category').val()
            }).done(function (r) {

                console.log(r);

                if(r.success == true ){
                    $('#result').html('<p class="correct">Vos informations ont bien été mises à jour</p>').removeClass('hide');
                    setTimeout(function () {
                        $('#result').addClass('hide')
                    },3000);

                }else{
                    $('#result').html('<p class="false">Une erreur s\'est produite</p>').removeClass('hide');
                    setTimeout(function () {
                        $('#result').addClass('hide')
                    },3000);
                }
            });
        }
    });
});