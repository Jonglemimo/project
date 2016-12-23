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