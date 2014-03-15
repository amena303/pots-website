
	$(document).ready(widget_rescate);

	function widget_rescate()
	{
		//-- Slider
		$(".widget_rescate .rescate .slider").responsiveSlides({
			auto: false,             // Boolean: Animate automatically, true or false
			speed: 0,            // Integer: Speed of the transition, in milliseconds
			timeout: 5000,          // Integer: Time between slide transitions, in milliseconds
			pager: true,           // Boolean: Show pager, true or false
			nav: false,             // Boolean: Show navigation, true or false
			random: false,          // Boolean: Randomize the order of the slides, true or false
			pause: false,           // Boolean: Pause on hover, true or false
			pauseControls: true,   // Boolean: Pause when hovering controls, true or false
			prevText: "Previous",   // String: Text for the "previous" button
			nextText: "Next",       // String: Text for the "next" button
			maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
			controls: "",           // Selector: Where controls should be appended to, default is after the 'ul'
			//namespace: "sliderRescate",	// String: change the default namespace used
			before: function(){},   // Function: Before callback
			after: function(){}     // Function: After callback
		});

		//console.log("...");
		$(".widget_rescate .galeria_rescate").fancybox({
			transitionIn	:	'elastic',
			transitionOut	:	'elastic',
			speedIn			:	600,
			speedOut		:	200,
	//		'width'			:	600,
	//		'height'		:	400,
			maxWidth		:	600,
			maxHeight		:	400,
	//		'minWidth'		:	600,
	//		'minHeight'		:	400,
			autoSize		:	true,
			overlayShow		:	true,
			fitToView		:	true,
			helpers	: {
				//overlay : {
					//locked : false
				//},
				title	: {
					//type: 'outside'
					type : 'inside'
				},
				thumbs	: {
					width	: 50,
					height	: 50
				}
			}
		});

	}

