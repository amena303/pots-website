
	$(document).ready(widget_staff);

	function widget_staff()
	{

		//-- Evento sobre data
		$('.widget_staff ul li .data .contenedor')
		//$('.pag_01 .bloque-1 .izq .colaboradores ul li:eq('+indice+') .data')
		.on('mouseenter', function(){
			//-- PADRE ------------------------
			//-- Elemento
			var that = $(this).parent().parent();
			//-- Indice
			var indice = $('.widget_staff ul li').index(that);

			//console.info('ENTRA DATA '+indice);
			var tht = $(this).parent();
			tht.css({'display':'none'});
		})
		.on('mouseleave', function(){
			//-- PADRE ------------------------
			//-- Elemento
			var that = $(this).parent().parent();
			//-- Indice
			var indice = $('.widget_staff ul li').index(that);

			//console.info('SALIR DATA '+indice);
			var tht = $(this).parent();
			tht.css({'display':'block'});
		});


		$('.widget_staff ul')
		.on('mouseenter', 'li', function(){
			//-- Elemento
			var that = $(this);
			//-- Indice
			var indice = $('.widget_staff ul li').index(that);

			//console.log('ENTRAR '+indice);

			//-- Mostrar data
			$('.widget_staff ul li:eq('+indice+') .data').css({'display':'block'});

		})
		.on('mouseleave', 'li', function(){
			//-- Elemento
			var that = $(this);
			//-- Indice
			var indice = $('.widget_staff ul li').index(that);

			//console.log('SALIR '+indice);

			//-- Mostrar data
			$('.widget_staff ul li:eq('+indice+') .data').css({'display':'none'});
		});
	}
