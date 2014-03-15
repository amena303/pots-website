

//--
if (typeof(isNumeric) == "undefined") { 
	//--
	function isNumeric(value) {
		if (value == null || !value.toString().match(/^[-]?\d*\.?\d*$/)) return false;
		return true;
	}
}


//--
if (typeof(getUnvisibleDimensions) == "undefined") { 
		//--
	function getUnvisibleDimensions(obj) {
		if ($(obj).length == 0) {
		    return false;
		}

		var clone = obj.clone();
		clone.css({
		    visibility:'hidden',
		    width : '',
		    height: '',
		    maxWidth : '',
		    maxHeight: ''
		});
		$('body').append(clone);
		var width = clone.outerWidth(),
		    height = clone.outerHeight();
		clone.remove();
		return {w:width, h:height};
	}
}


//--
if (typeof(pad) == "undefined") { 
	//--
	function pad(n, width, z) {
		z = z || '0';
		n = n + '';
		return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
	}
}


//--
if (typeof(getRealDimensions) == "undefined") { 

	//--
	function getRealDimensions(obj, outer) {
		if ($(obj).length == 0) {
		    return false;
		}

		var width, height, offsetTop, offsetLeft, offsets;

		var clone = obj.clone();
		clone.show();
		clone.css({
		    visibility:'hidden'
		});
		$('body').append(clone);
		if (outer===true) {
		    width  = clone.outerWidth();
		    height = clone.outerHeight();
		} else {
		    width  = clone.innerWidth();
		    height = clone.innerHeight();
		}

		offsets    = clone.offset();
		offsetTop  = clone.offsets.top;
		offsetLeft = clone.offsets.left;
		clone.remove();
		return {
		    width:      width,
		    height:     height,
		    offsetTop:  offsetTop,
		    offsetLeft: offsetLeft
		};
	}
}



