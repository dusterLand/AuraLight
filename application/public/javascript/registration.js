$(function() {
	"use strict";
	$('#al_menu_item[name=registration]').on( 'click', function() {
		window.location.href = '/';
	});
	$('#al_menu_title').on( 'click', function () {
		window.location.href = '/';
	});
	// Test jQuery button
	$('#button_test_jquery').on( 'click', function () {
		console.log( 'jQuery test successful' );
		alert( 'jQuery test successful' );
	});
	
	$('body').on("focusout", "#email", function(){
		var input_val = $(this).val();
		var is_success = validate_email(input_val);
		
		if(!is_success){
			$("#email").focus();
		}
	});
	
	$( 'body' ).on("focusout", "#username", function(){
		var input_val = $(this).val();
		console.log( 'before ValidateRegistrationInfo' );
		$.post( '/frontpage/ValidateRegistrationInfo', {
				'username' : input_val
		}).done( function ( data ) {
			console.log( 'success ValidateRegistrationInfo' );
			var is_success = true;
		}).fail( function ( data ) {
			console.log( 'fail ValidateRegistrationInfo' );
			var is_success = false;
			$("#username").focus();
		}).always( function(){
		});	
	});
	
	$( 'body' ).on( 'click', '#submit_registration_info', function() {
		var registration_username = $('input#username').val();
		var registration_userpass = $('input#userpass').val();
		var registration_firstname = $('input#firstname').val();
		var registration_middlename = $('input#middlename').val();
		var registration_lastname = $('input#lastname').val();
		var registration_email = $('input#email').val();
		console.log( 'before SubmitRegistrationInfo' );
		$.post( '/frontpage/SubmitRegistrationInfo', {
			'username': registration_username,
			'userpass': registration_userpass,
			'firstname': registration_firstname,
			'middlename': registration_middlename,
			'lastname': registration_lastname,
			'email': registration_email
		}).done( function( data ) {
			console.log( 'in done SubmitRegistrationInfo' );
			window.location.href = '/';
		}).always( function() {
		});
	});
	
	
	
	
	//email verification
	var validate_email = function(email){
		var pattern = /^([a-zA-A0-9_.-])+@([a-zA-Z0-9_.-])+([a-zA-Z])+/;
		var is_email_valid = false;
		if(email.match(pattern) != null){
			is_email_valid = true;
		}
		return is_email_valid;
	}

	
	
	
	
});
