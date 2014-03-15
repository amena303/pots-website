<?php
if ( ! function_exists( 'get_domain_root' ) ) :
	function get_domain_root() {
		$domain_name =  preg_replace('/^www\./','',$_SERVER['SERVER_NAME']);

//			$domain = get_option('siteurl'); //or home
//			$domain = str_replace('http://', '', $domain);
//			$domain = str_replace('www', '', $domain); //add the . after the www if you don't want it
//			$domain = strstr($domain, '/', true); //PHP5 only, this is in case WP is not root
		return $domain_name;

	//    $domain = get_option('siteurl'); //or home
	//	$nowww = ereg_replace('www\.','', $domain);
	//	$domain = parse_url($nowww);
	//	if(!empty($domain["host"]))
	//	{
	//		return $domain["host"];
	//	}
	//	else
	//	{
	//		return $domain["path"];
	//	}
	}
endif;

/*
* Gets the excerpt of a specific post ID or object
* @param - $text
* @param - $length - int - the length of the excerpt in words
* @param - $tags - string - the allowed HTML tags. These will not be stripped out
* @param - $extra - string - text to append to the end of the excerpt
*/
function do_excerpt($text = '', $length = 100, $tags = '<a><em>', $extra = '...') {
	$the_excerpt = $text;
	$the_excerpt = strip_shortcodes(strip_tags($the_excerpt), $tags);
	$the_excerpt = preg_split('/\b/', $the_excerpt, $length * 2+1);
	$excerpt_waste = array_pop($the_excerpt);
	$the_excerpt = implode($the_excerpt);
	$the_excerpt .= $extra;

	return apply_filters('the_content', $the_excerpt);
}
?>