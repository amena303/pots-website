

	function loadApp(){
		$("#flipbook").turn({
			width: 400,
			height: 300,
			autoCenter: true
		});
	}

	yepnope({
		test : Modernizr.csstransforms,
		yep: [RUTA_td+'/lib/js/turn.min.js'],
		nope: [RUTA_td+'/lib/js/turn.html4.min.js', RUTA_td+'/lib/css/jquery.ui.html4.css'],
		both: [RUTA_td+'/lib/js/zoom.min.js', RUTA_td+'/lib/css/jquery.ui.css', RUTA_td+'/lib/js/magazine.js', RUTA_td+'/lib/css/magazine.css'],
		complete: loadApp
	});
