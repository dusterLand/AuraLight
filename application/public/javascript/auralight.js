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
	// Test jQuery button
	$('#button_test_jquery').on( 'click', function () {
		console.log( 'jQuery test successful' );
		alert( 'jQuery test successful' );
	});
	// Process login
	$( 'body' ).on( 'click', '#submit_login', function() {
		var login_username = $('input#username').val();
		var login_userpass = $('input#userpass').val();
		$.post( '/frontpage/UserLogin', {
			'username': login_username,
			'userpass': login_userpass,
			'dataType': 'json'
		}).done( function( data ) {
			location.reload( true );
		}).always( function() {
		});
	});
	// Process logout
	$( 'body' ).on( 'click', '#submit_logout', function() {
		$.post( '/frontpage/UserLogout', {
		}).done( function( data ) {
			location.reload( true );
		}).always( function () {
		});
	});
});
