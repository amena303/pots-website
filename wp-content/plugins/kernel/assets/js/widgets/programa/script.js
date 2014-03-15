
	$(document).ready(widget_programa);

	function widget_programa()
	{
		//console.log("...");
		$(".widget_programa .galeria_programa").fancybox({
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
