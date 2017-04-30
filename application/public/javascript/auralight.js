$(function() {
	"use strict";
	$('#al_menu_item[name=front_page]').on( 'click', function() {
		window.location.href = '/';
	});
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
});
