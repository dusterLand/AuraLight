$(function() {
	"use strict";
	// Front page link
	$('#al_menu_item[name=front_page]').on( 'click', function() {
		window.location.href = '/';
	});
	// Title is front page link
	$('#al_menu_title').on( 'click', function () {
		window.location.href = '/';
	});
//	$('body').on( 'click', '#button_test_jquery', function() {
//		console.log( 'click' );
//		alert( 'jQuery test successful.' );
//	});
	$('#button_test_jquery').on( 'click', function () {
		console.log( 'jQuery test successful' );
		alert( 'jQuery test successful' );
	});
	// Dunno why this has params, can probably be cleaned up...
	$('#test_login').on( 'click', function() {
		var $params = array(
			'LichKing56',
			'filler'
		);
//		var $username = 'LichKing56';
//		var $password = 'filler';
//		$.post(
//		'url': '/FrontPage/userlogin',
//		'data': $params,
//		)
	});
	// Testing jQuery post AJAX
	$('#button_test_post_return').on( 'click', function() {
		console.log( 'test jQuery post button clicked' );
		$.post( '/frontpage/Becky', {
			'data': 'butt',
			'dataType': 'json'
		}).done( function( data ) {
			alert( data.data );
			console.log( data );
		}, "json").always( function() {
			console.log( "AJAX complete.");
		});
	});
});
