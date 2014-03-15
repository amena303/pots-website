
	//-- 
	//var VAR_domain = 'http://'+'triptothemoon.org';
	//var VAR_domain = icl_home;
	var VAR_domain 	= RUTA_host;
	var VAR_lang	= icl_lang;
	//var VAR_domain = '';

	//-- HOME

	//-- 
	var getHome = function(){
		//console.log('PAGE: '+'/');
	};

	//-- PAGE

	//-- 
	var getPage = function(slug){
		console.log('PAGE: '+slug);

		//-- 
		var slugPage 		= $('.scene.skrollable-between');
		var slugPage_name 	= slugPage.data('name');

		var sendData = null;
		sendData = new Array();
		sendData.push({'name': 'slug', 'value': (slug) });
		// sendData.push({'name': 'action', 'value': 'pstCat' });
		// sendData.push({'name': 'num', 'value': (num) });
		// sendData.push({'name': 'cat', 'value': cat });
		// sendData.push({'name': 'ppp', 'value': ppp });
		//console.dir(sendData);

		//-- 
		$('.scene-'+slugPage_name+' .scene_inner .entradas').html('<div class="scene-loading" style="text-align: center;"><br/><br/>...</div>');
		$('.scene-'+slugPage_name+' .scene_inner .paginacion').html('');

		console.log('slugPage: '+slugPage_name);
		console.log('url: '+VAR_domain+'/'+(VAR_lang=='es' ? VAR_lang+'/' : '') + slug + '/');

		//-- 
		$.ajax({
			//url: RUTA_url+'/wp-admin/admin-ajax.php',
			//url: VAR_domain+'/'+slug+'/',
			url: VAR_domain+'/'+(VAR_lang=='es' ? VAR_lang+'/' : '') + slug + '/',
			type: 'post',
			//dataType: 'json',
			data: $.param(sendData)
		})
		.done(function(data){
			//-- 
			$('.scene-'+slugPage_name+' .scene_inner').html(data);
		});
	};

	//-- SINGLE

	//-- 
	var getSingle = function(slug){
		//console.log('SINGLE: '+slug);

		//-- 
		var slugPage 		= $('.scene.skrollable-between');
		var slugPage_name 	= slugPage.data('name');
		var sendData 		= null;
		//console.log('->'+slugPage_name);

		//-- 
		sendData = new Array();
		sendData.push({'name': 'slug', 'value': (slug) });

		// sendData.push({'name': 'action', 'value': 'pstCat' });
		// sendData.push({'name': 'num', 'value': (num) });
		// sendData.push({'name': 'cat', 'value': cat });
		// sendData.push({'name': 'ppp', 'value': ppp });
		//console.dir(sendData);

		//-- 
		$('.scene-'+slugPage_name+' .scene_inner .entradas').html('<div class="loading" style="text-align: center;">...</div>');
		$('.scene-'+slugPage_name+' .scene_inner .paginacion').html('');

		//-- 
		$.ajax({
			//url: RUTA_url+'/wp-admin/admin-ajax.php',
			//url: VAR_domain+'/'+slugPage_name+'/'+slug,
			url: VAR_domain+'/'+(VAR_lang=='es' ? VAR_lang+'/' : '')+(VAR_lang=='es' ? slugPage_name+'-es' : slugPage_name)+'/'+slug+'/',
			type: 'post',
			//dataType: 'json',
			data: $.param(sendData)
		})
		.done(function(data){
			//-- 
			$('.scene-'+slugPage_name+' .scene_inner').html(data);
			//-- 
			setTimeout(function(){
				$('.scene-'+slugPage_name+' .scene_inner .scroll-pane').jScrollPane({autoReinitialise: true});
			}, 0);
		});
	};

	//-- 
	var getPagination = function(page){
		//console.log('SINGLE: '+slug);

		//-- 
		var slugPage 		= $('.scene.skrollable-between');
		var slugPage_name 	= slugPage.data('name');
		var slug 			= parseInt(page);
		var sendData 		= null;
		//console.log('->'+slugPage_name);

		//-- 
		sendData = new Array();
		sendData.push({'name': 'slug', 'value': (slug) });

		// sendData.push({'name': 'action', 'value': 'pstCat' });
		// sendData.push({'name': 'num', 'value': (num) });
		// sendData.push({'name': 'cat', 'value': cat });
		// sendData.push({'name': 'ppp', 'value': ppp });
		//console.dir(sendData);

		//-- 
		$('.scene-'+slugPage_name+' .scene_inner .entradas').html('<div class="loading" style="text-align: center;">...</div>');
		$('.scene-'+slugPage_name+' .scene_inner .paginacion').html('');

		//-- 
		$.ajax({
			//url: RUTA_url+'/wp-admin/admin-ajax.php',
			//url: VAR_domain+'/'+slugPage_name+'/'+slug,
			url: VAR_domain+'/'+(VAR_lang=='es' ? VAR_lang+'/' : '')+slugPage_name+'/'+slug,
			type: 'post',
			//dataType: 'json',
			data: $.param(sendData)
		})
		.done(function(data){
			//-- 
			$('.scene-'+slugPage_name+' .scene_inner').html(data);
		});
	};

	//-- Router
	var rtr = new staterouter.Router();

	//-- Cfg
	rtr
	//-- ING
	.route('/es/', getHome)
	.route('/es/:slug/', getPage)
	.route('/es/journey-es/:slug/', getSingle)
	.route('/es/videos-es/:slug/', getSingle)
	.route('/es/journey-es/:page/', getPagination)
	.route('/es/videos-es/:page', getPagination)

	//-- ESP
	.route('/', getHome)
	.route('/:slug/', getPage)
	.route('/journey/:slug/', getSingle)
	.route('/videos/:slug/', getSingle)
	.route('/journey/:page/', getPagination)
	.route('/videos/:page', getPagination)

	//-- Perform routing of the current state
	rtr.perform();

	//-- 
	var Tower = Tower || {};

	//-- 
	Tower.SECTIONS = {};

	//-- 
	Tower.init = function() {
		//-- 
		var section_sel = $('.scenes .scene.current-menu-item').attr('data-name');
		//-- 
		var end = 0;
		//-- Incremento según sección. Casos aislados: ini, fin
		switch(section_sel){
			case 'home':
				end = 0;
			break;
			case 'about':
				end = 1000;
			break;
			default:
				end = 1000;
			break;
		}

		//-- 
		Tower.s = skrollr.init({
			constants: Tower.SECTIONS
			, beforerender: function(data) {
				//console.log('beforerender');
			}
			, render: function() {
				//console.log('render');
			}
			, easing: {
				WTF: Math.random,
					inverted: function(p) {
					return 1-p;
				}
			}
			//, smoothScrolling: true
			//, smoothScrollingDuration: 4000
		}).animateTo(Tower.SECTIONS[section_sel] + end, {duration: 500 });

		//-- 
		if (history && history.pushState) {
			$('nav.main-navigation li a').click(function() {
				//var link = $(this).parent().attr('id').replace('nav-', '');
				var dom 	= $(this).attr('href');
				var ruta 	= dom.replace(VAR_domain, '');

				var slug 	= $(this).attr('data-slug');
				var titulo 	= $(this).attr('data-titulo');
				var data 	= $(this).attr('data-data');

				//-- 
				ruta 	= ruta.substring(0,1) == '/' ? ruta : '/'+ruta;
				//console.log(slug);
				//console.log(ruta);

				//-- Scroll to position
				Tower.jumpTo(slug);

				//-- Navigate to a URL, also specifying the page's data and title
				rtr.navigate(ruta, {what: data}, titulo);

				//-- 
				return false;
			});
		}

		// $('#left h1').click(function() {
		// 	window.location.href = '/';
		// 	return false;
		// });

		// $('#begin-the-tour').click(function() { Tower.jumpTo('intro'); });
		// $('#arrow-up').click(Tower.toPrevious);
		// $('#arrow-down').click(Tower.toNext);
		// $('#frames-museum-intro').click(function() { Tower.jumpTo('intro')});
		// $('#frames-education').click(function() { Tower.jumpTo('education')});
		// $('#frames-languages').click(function() { Tower.jumpTo('languages')});
		// $('#frames-extra-curricular-activities').click(function() { Tower.jumpTo('activities')});
	};

	//-- 
	Tower.jumpTo = function(section) {
		var end = 0;
		//-- Incremento según sección. Casos aislados: ini, fin
		switch(section){
			case 'home':
				end = 0;
			break;
			case 'about':
				end = 1000;
			break;
			default:
				end = 1000;
			break;
		}
		//var end = section=='home'?0:0;
		//history.pushState({}, section, section);
		//console.log('jump');
		//console.log('JUMP to: '+Tower.SECTIONS[section]);
		Tower.s.animateTo(Tower.SECTIONS[section] + end, {duration: 100 });
	};

	//--
	Tower.getCurrent = function() {
		var scroll = $(window).scrollTop();

		//-- 
		var sectionWLength = new Array();
		for (var i in Tower.SECTIONS) {
			sectionWLength.push({section: i, end: Tower.SECTIONS[i] + 2000, mid: Tower.SECTIONS[i] + 1000});
		}

		/*var i = 0;
		for (; i<sectionWLength.length; i++) {
			if (sectionWLength[i].end > scroll) {
				break;
			}
		}

		return {
				previous: sectionWLength[Math.max(0, i-1)].section,
				current: sectionWLength[i].section,
				next: sectionWLength[Math.min(sectionWLength.length, i+1)].section
		}*/

		//-- Find the closest section center
		var i=0, min= {index: 0, section: Tower.SECTIONS[0], val: 10000};
		for (;i<sectionWLength.length; i++) {
			var val = Math.abs(scroll - sectionWLength[i].mid);
			if (val < min.val) {
				min.val = val;
				min.section = sectionWLength[i].section;
				min.index = i;
			}
		}

		//--
		return {
			previous: sectionWLength[Math.max(0, min.index-1)].section,
			current: sectionWLength[min.index].section,
			next: sectionWLength[Math.min(sectionWLength.length-1, min.index+1)].section
		}
	}

	//-- 
	Tower.toNext = function() {
		Tower.jumpTo(Tower.getCurrent().next);
	}

	//--
	Tower.toPrevious = function() {
		Tower.jumpTo(Tower.getCurrent().previous);
	}

	//-- 
	$(function() {

		//-- 
		var scenes_obj = new Object();
		var scenes_lim = $('.scenes .scene').length;

		//-- 
		$('.scenes .scene').each(function(idx, item){
			//-- 
			scenes_obj[$(this).data('name')] = $(this).data('opening');
			//-- 
			if(idx+1 == scenes_lim){
				//-- 
				//console.dir(scenes_obj);
				//-- 
				Tower.SECTIONS = scenes_obj;
				//-- 
				Tower.init();
			}
		});

		//-- JOURNEY

		//-- 

		$('.scene-journey').on('click', '.scene_inner .entradas .thumb a.img', function(e){
			//var link = $(this).parent().attr('id').replace('nav-', '');
			var nav_gen	= $('.main .izquierda nav ul li.nav-journey a');

			var slug 	= nav_gen.attr('data-slug');
			var titulo 	= nav_gen.attr('data-titulo');
			var data 	= nav_gen.attr('data-data');

			var nav 	= $(this);
			var dom 	= nav.attr('href');
			var ruta 	= dom.replace(VAR_domain, '');

			//-- 
			ruta 	= ruta.substring(0,1) == '/' ? ruta : '/'+ruta;

			//-- 
			//console.log('dom: '+dom);
			//console.log('dom: '+dom);
			//console.log('rut: '+ruta);

			//-- 
			e.preventDefault();

			//-- Navigate to a URL, also specifying the page's data and title
			rtr.navigate(ruta, {what: data}, titulo);
		});

		//--

		$('.scene').on('click', '.scene_inner .paginacion ul.pagination a.inactive', function(e){

			//-- ENLACE
			var nav 	= $(this);
			var idx 	= $('.paginacion a').index(nav[0]);
			var dom 	= nav.attr('href');
			var ruta 	= dom.replace(VAR_domain, '');

			//-- SECCION
			var slugPage 		= $('.scene.skrollable-between');
			var slugPage_name 	= slugPage.data('name');
			var sendData 		= null;
			var nav_gen	= $('.main .izquierda nav ul li.nav-'+slugPage_name+' a');
			var slug 	= nav_gen.attr('data-slug');
			var titulo 	= nav_gen.attr('data-titulo');
			var data 	= nav_gen.attr('data-data');

			//-- 
			ruta 	= ruta.substring(0,1) == '/' ? ruta : '/'+ruta;

			//-- 
			e.preventDefault();

			//console.log(idx+','+ruta+','+slug+','+titulo);

			//-- Scroll to position
			//Tower.jumpTo(slug);

			//-- Navigate to a URL, also specifying the page's data and title
			rtr.navigate(ruta, {what: data}, titulo);

		});

		//--

		$('.scene').on('click', '.breadcrumb a', function(e){

			var idx 	= $('.breadcrumb a').index($(this)[0]);
			var nav 	= $(this);
			var dom 	= nav.attr('href');
			var ruta 	= dom.replace(VAR_domain, '');
			//console.log(idx);

			//var link = $(this).parent().attr('id').replace('nav-', '');
			var nav_gen	= $('.main .izquierda nav ul li.nav-menu a[href="'+dom+'"]');
			var slug 	= nav_gen.attr('data-slug');
			var titulo 	= nav_gen.attr('data-titulo');
			var data 	= nav_gen.attr('data-data');

			//-- 
			ruta 	= ruta.substring(0,1) == '/' ? ruta : '/'+ruta;

			//-- 
			e.preventDefault();

			//console.log(idx+','+ruta+','+slug+','+titulo);

			//-- Navigate to a URL, also specifying the page's data and title
			if(idx == 0) {
				//-- 
				ruta 	= '/';
				//-- Scroll to position
				//Tower.jumpTo('home');
			}
			else {
				if(idx <= 1) {
					//Tower.jumpTo(ruta);
				}
				else {
					return false;
				}
			}

			//-- Scroll to position
			Tower.jumpTo(slug);

			//-- Navigate to a URL, also specifying the page's data and title
			rtr.navigate(ruta, {what: data}, titulo);


		});

		//--

		$('body').on('click', 'a[href="#"]', function(e){
			e.preventDefault();
		});


	});




	// var persons = ['John Doe', 'Jane Doe'];
	// var colours = ['blue', 'red'];
	// var lorem = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel augue sed mauris mattis posuere vitae at nisl. Praesent lacinia, nibh in laoreet convallis, libero enim elementum turpis, sit amet consequat nunc erat sed magna. Fusce facilisis venenatis tempus. Mauris dictum suscipit tempus. Suspendisse metus ligula, malesuada in tempor sed, placerat non nunc. Vivamus sed magna justo, at interdum libero. Aenean tristique, purus eu aliquet rutrum, lorem nisl auctor velit, ut volutpat sem velit vitae lorem. Nulla augue lectus, placerat non ultrices eget, pretium sit amet risus. Pellentesque scelerisque purus sit amet tellus ultrices sed tincidunt nunc ornare. Morbi ultricies fringilla pellentesque. Nam eu erat id felis porttitor sollicitudin in nec ligula. In tempor nulla non dolor dapibus nec porttitor est fringilla. Nulla facilisis scelerisque lorem sit amet congue. Proin eu auctor leo.';

	// function getHomePage() {
	// 	$('#heading').html('Welcome to the Homepage');
	// 	$('#content').html(lorem);
	// }

	// function getPersons() {
	// 	$('#heading').html('The Directory of Persons');
	// 	var list = $('#content').html('<ul></ul>');
	// 	$.each(persons, function(id) {
	// 		list.append('<li>' + persons[id] + '</li>');
	// 	});
	// }

	// function getPerson(id) {
	// 	var person = persons[id];
	// 	$('#heading').html('Welcome to the Page of <i>' + person + '</i>');
	// 	$('#content').html('<p>' + lorem + '</p>');
	// 	$('#content').attr('class', colours[id]);
	// }

	// function goodbye() {
	// 	$('#heading').html('Goodbye');
	// 	$('#content').html('We hope you liked this demonstration; to try for yourself, grab <a href="https://github.com/aknuds1/staterouter.js">StateRouter.js</a> and get coding!');
	// 	$('#content').attr('class', '');
	// }

