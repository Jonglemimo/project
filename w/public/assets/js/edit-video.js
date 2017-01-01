//video editing

$(function () {

    $(document).on('click','.deleteVideo',function () {

        var id = $(this).data('delete');
        console.log(id);
        $.ajax({
            type:'POST',
            url:$('.deleteId').val(),
            data:{
                id: id
            }
        }).done(function () {
            deleteElement(id);
        }).fail(function (response) {
            console.log(response);
        })
    });

    $(document).on('click', '.editVideo',function () {
        var href = $(this).data('edit');
        document.location.href= href;
    });

});

var deleteElement = function (id) {
    var container = $('.deleteVideo[data-delete="'+id+'"]').parent().parent();
    if(container.length > 0){
        container.remove();
    }
};