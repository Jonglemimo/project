function validateForm () {
    var error = '';

    if($('.title').val().length < 5){

        error += 'Votre titre doit être supérieur à 5 caractères <br>';

    }

    if($('.description').val().length < 20){

        error += 'Votre description doit être supérieur à 20 caractères';

    }

    if($('.category').val().length = 0){

        error += 'Vous devez renseigner une catégorie';
    }

    if(isNaN($('.category').val())){

        error += 'Cette catégorie n\'existe pas';
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
                    $('#result').html('Vos informations ont bien été mises à jours').removeClass('hide').addClass('alert alert-success');
                    setTimeout(function () {
                        $('#result').addClass('hide')
                    },3000);

                }else{
                    $('#result').html('Une erreur s\'est produite').removeClass('hide').addClass('alert alert-danger');
                    setTimeout(function () {
                        $('#result').addClass('hide')
                    },3000);
                }
            });
        }
    });
});