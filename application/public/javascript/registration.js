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
	
	$('body').on("focusout", "#regemail", function(){
		var input_val = $(this).val();
		var is_success = validate_email(input_val);
		
		if(!is_success){
			$("#regemail").focus();
		}
	});
	
	$( 'body' ).on("focusout", "#reguserpassverify", function(){
		if ($('#reguserpass').val() !== $('#reguserpassverify').val()) {
			alert("Your passwords do not match. Please try again.")
			$('#reguserpass').focus();
		}
	});
	
	$( 'body' ).on("focusout", "#regusername", function(){
		var input_val = $(this).val();
		console.log( 'before ValidateRegistrationInfo' );
		$.post( '/frontpage/ValidateRegistrationInfo', {
				'regusername' : input_val
		}).done( function ( data ) {
			console.log( 'done response from ValidateRegistrationInfo' );
			if (data['success'] == 0){
				alert("Username is already used. Please choose a new name.");		
				$("#regusername").focus();	
			}else if (data['success'] == 1){
				console.log( 'ValidateRegistrationInfo: user does not currently exist - continue' );			
			}else{
				console.log( 'ValidateRegistrationInfo: unknown response' );
			}
			var is_success = true;
		}).fail( function ( data ) {
			console.log( 'fail ValidateRegistrationInfo' );
		}).always( function(){
		});	
	});
	
	$( 'body' ).on( 'click', '#submit_registration_info', function() {
		var registration_username = $('input#regusername').val();
		var registration_userpass = $('input#reguserpass').val();
		var registration_firstname = $('input#regfirstname').val();
		var registration_middlename = $('input#regmiddlename').val();
		var registration_lastname = $('input#reglastname').val();
		var registration_email = $('input#regemail').val();
		console.log( 'SubmitRegistrationInfo: Starting....' );
		$.post( '/frontpage/SubmitRegistrationInfo', {
			'regusername': registration_username,
			'reguserpass': registration_userpass,
			'regfirstname': registration_firstname,
			'regmiddlename': registration_middlename,
			'reglastname': registration_lastname,
			'regemail': registration_email
		}).done( function( regdata) {
			console.log( 'SubmitRegistrationInfo: done response ' + regdata['success'] );
			window.location.href = '/';
		}).fail( function( jqXHR, textStatus, errorThrown ) {
			console.log('SubmitRegistrationInfo: Failed' + errorThrown);
		}).always( function() {
			console.log('SubmitRegistrationInfo: Always');
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
