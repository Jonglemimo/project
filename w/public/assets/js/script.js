
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
	$('.btnSearch').on('click', function(e){
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
		
	})
});

$(function() {


	$('#search-form-mobile').on('show.bs.collapse', function () {
			$('#login-buttons-mobile').collapse('hide');
	})
	$('#login-buttons-mobile').on('show.bs.collapse', function () {
			$('#search-form-mobile').collapse('hide');
	})
	
	$( window ).resize(function() {
		$('#login-buttons-mobile, #search-form-mobile').collapse('hide');
	});
});