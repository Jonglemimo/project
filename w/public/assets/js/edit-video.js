//video editing

$(function () {

    $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]',

        onConfirm: function() {
            var id = $(this).data('delete');
            $.ajax({
                type:'POST',
                url:$('.deleteId').val(),
                data:{
                    id: id
                }
            }).done(function () {
                deleteElement(id);
                if($(".latest-video").children().length === 0){
                    window.location.reload();
                }
            }).fail(function (response) {
                console.log(response);
            })
        },
        // other options
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