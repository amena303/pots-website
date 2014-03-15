

function goBack()
{
	window.history.back()
}


( function( $ ) {

	var body    = $( 'body' ), _window = $( window ), _document = $( document );



	_document.bind('touchmove',function(e) { e.preventDefault();});



	//-- My body is ready (yeah!)

	$( function() {

		//--Search toggle.

		$( '.search-toggle' ).on( 'click.twentyfourteen', function( event ) {

			var that    = $( this ),

				wrapper = $( '.search-box-wrapper' );



			that.toggleClass( 'active' );

			wrapper.toggleClass( 'hide' );



			if ( that.is( '.active' ) || $( '.search-toggle .screen-reader-text' )[0] === event.target ) {

				wrapper.find( '.search-field' ).focus();

			}

		} );



		// //--

		// $('a[href^="#"]:not(a[href^="#workshop"]):not(.carousel-control):not([data-target])').on('click', function(ele){

		// 	ele.preventDefault();

		// 	return false;

		// });

		// //--

		$('#primary-sidebar a').on('click', function(ele){

			ele.preventDefault();

			return false;

		});



		//-- 

		$('.scroll-pane').jScrollPane({

			autoReinitialise: true

		});



		//-- 

		//-- HOME

		//-- 



		//-- 

		$('.featured .featured_slider').carousel({

			interval: false

		});

		$('.featured .featured_slider').on('slid.bs.carousel', function() {

			//alert("slid");

		});



		//-- 

		$('.others .others_slider').carousel({

			interval: false

		});

		$('.others .others_slider').on('slid.bs.carousel', function() {

			//alert("slid");

		});



		//-- 

		//-- SERVICES

		//-- 



		//-- 

		$('.services #services_slider').carousel({

			interval: false

		});

		$('.services #services_slider').on('slid.bs.carousel', function() {

			//alert("slid");

		});



		//-- 

		$('.offices #offices_slider').carousel({

			interval: false

		});

		$('.offices #offices_slider').on('slid.bs.carousel', function() {

			//alert("slid");

		});



		//--Focus styles for menus.

		$( '.primary-navigation, .secondary-navigation' ).find( 'a' ).on( 'focus.twentyfourteen blur.twentyfourteen', function() {

			$( this ).parents().toggleClass( 'focus' );

		} );

	} );



} )( jQuery );



