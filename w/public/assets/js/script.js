
jQuery(document).ready(function() {

	function getVote(){
		$.ajax({
			url: $('#get_vote_route').val(),
			type: 'POST',
			dataType: 'json',
			data: {
				shortTitle : $('#mainVideo').data('stitle'),
			},
		})
		.always(function(r) {
			var nb = parseInt(r.vote);
			unColorStar(nb);
			colorStar(nb);
		});
	}

	$.ajax({
		url: $('#ajax_search_route').val() ,
		dataType: 'html',
	})
	.done(function(r) {
		$('#best').html(r);
	})
	.fail(function() {
		console.log("error");
	});

	$('#btnSearch').on('click', function(e){
		e.preventDefault();
		$.ajax({
			url: $('#ajax_search_route').val(),
			type: 'POST',
			dataType: 'html',
			data: {
				search: $('#search').val()
			},
		})
		.done(function(r) {
			$('#searchVideo').html(r);
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

	$(document).on('click','#videoInfoSmall', function(){
		var urlVideo = $(this).children('img').data('shorttitle');
		var url = $('#watch_route').val();
		url += "?video=" + urlVideo;
		window.location.replace(url);
	});

	$(document).on({
		mouseenter: function(){
			var nb = $(this).data('vote');
			colorStar(nb);
			unColorStar(nb+1);
		}, 
		mouseleave: function(){
			getVote();
		}
	}, '#vote');
		

	

	$(document).on('click', '#vote', function(){
		var nb = $(this).data('vote');
		$.ajax({
			url: $('#vote_route').val(),
			type: 'POST',
			dataType: 'json',
			data: {
				shortTitle : $('#mainVideo').data('stitle'),
				stars : nb,
			},
		})
		.done(function() {
			console.log();
		})
		.fail(function(r) {
			console.log(r.responseText);
		})
		.always(function(r) {
			if (r.change == true) {
				alreadyVoted(r);
			} else {
				voted(r.response);
			}
		});
	});

	$(document).on('click', '#modifyVote', function () {
		$.ajax({
			url: $('#vote_update_route').val(),
			type: 'POST',
			dataType: 'json',
			data: {
				shortTitle : $('#mainVideo').data('stitle'),
				stars : $('#modifyVote').data('vote') ,
			},
		}).always(function(r) {
			getVote();
			hideAlert();
		});
	});

	$(document).on('click', '#cancel', function () {
		hideAlert();
	});

	getVote();

	function unColorStar(nb){
		if (nb < 6) {
			$('#vote[data-vote="'+nb+'"]').removeClass('glyphicon-star').addClass('glyphicon-star-empty');
			var vote = nb+1;
			unColorStar(vote);
		} 
	}

	function colorStar(nb){
		if (nb > 0) {
			$('#vote[data-vote="'+nb+'"]').removeClass('glyphicon-star-empty').addClass('glyphicon-star');
			var vote = nb-1;
			colorStar(vote);
		} 
	}

	function alreadyVoted(r){
		var btnVote = '<p id="alertMessage"></p>';
		btnVote += '<button id="modifyVote" type="button" data-vote="'+r.vote+'" class="btn btn-default">Modifier</button>';
		btnVote += '<button id="cancel" type="button" class="btn btn-default">Annuler</button>';
		$('#alertVote').html(btnVote);
		messageAlert(r.response);
		showAlert();
	}

	function voted(message){
		messageAlert(message);
		showAlert();
		setTimeout(function(){
			hideAlert();
		}, 8000);
	}

	function messageAlert(message){
		$('#alertMessage').html(message);
	}

	function showAlert(){
		$('#alertVote').show();
	}

	function hideAlert(){
		$('#alertVote').hide()
	}


	function debug(i){
		console.log(i);
	}
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