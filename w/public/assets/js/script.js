
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
	})
	.always(function(r) {
		console.log(r);
		$('#video').html(r);
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
		})
		.always(function(r) {
			console.log(r);
			$('#video').html(r);
		});
		
	})
});