
	$(document).ready(widget_noticias);

	function widget_noticias()
	{
		//-- Slider
		$(".widget_noticias .noticias .slider").responsiveSlides({
			auto: true,             // Boolean: Animate automatically, true or false
			speed: 500,            // Integer: Speed of the transition, in milliseconds
			timeout: 6000,          // Integer: Time between slide transitions, in milliseconds
			pager: true,           // Boolean: Show pager, true or false
			nav: true,             // Boolean: Show navigation, true or false
			random: false,          // Boolean: Randomize the order of the slides, true or false
			pause: false,           // Boolean: Pause on hover, true or false
			pauseControls: true,   // Boolean: Pause when hovering controls, true or false
			prevText: "Previous",   // String: Text for the "previous" button
			nextText: "Next",       // String: Text for the "next" button
			maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
			controls: "",           // Selector: Where controls should be appended to, default is after the 'ul'
			//namespace: "sliderNoticias",	// String: change the default namespace used
			//manualControls: '.sliderNoticias_pager',
			before: function(){},   // Function: Before callback
			after: function(){}     // Function: After callback
		});
	}

