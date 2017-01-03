
jQuery(document).ready(function() {
	
	$.ajax({
		url: $('#ajax_search_route').val() ,
		dataType: 'html',
	})
	.done(function(r) {
		$('#video').html(r);
	})
	.fail(function() {
		console.log("error");
	});
	$('#btnSearch').on('click', function(e){
		e.preventDefault();
		$.ajax({
			url: $('#ajax_search_route').val() ,
			type: 'POST',
			dataType: 'html',
			data: {
				search: $('#search').val()
			},
		})
		.done(function(r) {
			$('#video').html(r);
		})
		.fail(function() {
			console.log("error");
		});

	});
	$.ajax({
		url : $('#category').val(),
		type : 'POST',
		dataType : 'html',
	}).done( function (r) {
		$('.categories').html(r);
    }).fail(function (r) {
        $('.categories').html('Il n\'y a aucune catégories');
    });

});

	$(document).on('click','#videoInfoSmall', function(){
		var urlVideo = $(this).children('img').data('unique');
		var url = $('#watch_route').val();
		url += "?video=" + urlVideo;
		window.location.replace(url);
	});


$(function() {

	//SEARCH BAR AND SIGNIN/LOGIN SHOWING
	$('#search-form-mobile').on('show.bs.collapse', function () {
		$('#login-buttons-mobile').collapse('hide');
	});
	$('#login-buttons-mobile').on('show.bs.collapse', function () {
		$('#search-form-mobile').collapse('hide');
	});
	
	//SHOWING ONLY ONE AT ONCE
	$( window ).resize(function() {
		$('#login-buttons-mobile, #search-form-mobile').collapse('hide');
	});

	//SIDE NAVIGATION SHOWING OR NOT ON MOBILE
	$('#mySidenav').on('click', function() {
		if ( !$('.sidenav').hasClass('open') ){
	    	$('.sidenav').addClass('open')
	    } else {
	    	$('.sidenav').removeClass('open')
	    }
	});
});