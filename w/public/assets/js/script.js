
jQuery(document).ready(function() {
	var urlBase = "http://127.0.0.1:12"+homeUrl //WARNING ONLY FOR CORALIE
	var url = $(location).attr('href');
	var urlSplit = url.split('?');
	if (url == urlBase){
		getBest();
	}

	if (urlSplit[0] == urlBase+"recherche"){

		var search = urlSplit[1].split('=')[1];
		search = decodeURI(search);
		$('#search').val(search);
		getResultSearch(search);
	}

	if (urlSplit[0] == urlBase+"watch/"+$('#mainVideo').data('stitle')){
		getVote();
		showNote();
		getComment();
		setInterval(getComment, 30000);
	};

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

	function getBest(){
		$.ajax({
			url: $('#ajax_search_route').val() ,
			dataType: 'html'
		})
		.done(function(r) {
			$('#resultSearch').html(r);
		})
		.fail(function() {
			console.log("error");
		});
	}

	function getResultSearch(search){
		var route = $('#ajax_search_route').val();
		$.ajax({
			url: route,
			type: 'POST',
			dataType: 'html',
			data: {
				search: search
			},
		})
		.done(function(r) {
			$('#resultSearch').html(r);
		})
		.fail(function() {
			console.log("error");
		});
	}

	$('#btnSearch').on('click', function(e){
		e.preventDefault();
		var search = $('#search').val();
		if (urlSplit[0] != urlBase+"recherche") {
			window.location.href = urlBase+"recherche?search="+search;
		} else {
			history.pushState("", "", "recherche?search="+search);
			getResultSearch(search);
		}
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
				voted(r);
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
			showNote();
			getVote();
			hideAlert();
		});
	});

	$(document).on('click', '#cancel', function () {
		hideAlert();
	});

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
		btnVote += '<button id="modifyVote" type="button" data-vote="'+r.vote+'" class="btn buttons btn-default">Modifier</button>';
		btnVote += '<button id="cancel" type="button" class="btn buttons btn-default">Annuler</button>';
		$('#alertVote').html(btnVote);
		messageAlert(r.response);
		showAlert();
	}

	function voted(r){
		var message = r.response;
		debug(r);
		showNote();
		messageAlert(message);
		showAlert();
		setTimeout(function(){
			hideAlert();
		}, 8000);
	}

	function showNote(){
		$.ajax({
			url: $('#get_note_route').val(),
			type: 'POST',
			dataType: 'json',
			data: {
				shortTitle : $('#mainVideo').data('stitle')
			},
		})
		.done(function() {
		})
		.always(function(r) {
			var note = parseFloat(r.note);
			$('#note').html(note);
		});
		
		
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

	$('#btnComment').on('click', function(e){
		e.preventDefault();
		comment();
	});

	function comment(){
		var comment = $('#comment').val();
		var shortTitle = $('#mainVideo').data('stitle');
		var route = $('#comment_route').val();
		$.ajax({
			url: route,
			type: 'POST',
			dataType: 'json',
			data: {
				text: comment,
				shortTitle: shortTitle
			},
		})
		.done(function() {
			getComment();
			$('#comment').val('');
		})
		.fail(function() {
			console.log("error");
		})
		
	}

	function getComment(){
		var shortTitle = $('#mainVideo').data('stitle');
		var route = $('#get_comment_route').val();
		$.ajax({
			url: route,
			type: 'POST',
			dataType: 'html',
			data: {
				shortTitle: shortTitle
			},
		})
		.done(function(r) {
			$('.comment-content').html(r);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function(r) {
			console.log(r);
		});
		
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