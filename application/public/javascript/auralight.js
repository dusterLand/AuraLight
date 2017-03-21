$(function() {
	$('#al_menu_item[name=front_page]').on( 'click', function() {
		window.location.href = '/';
	});
	$('#al_menu_title').on( 'click', function () {
		window.location.href = '/';
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
})(jquery);
