<?php


	if ( ! function_exists( 'get_ID_by_slug' ) ) :
		function get_ID_by_slug($page_slug) {
			$page = get_page_by_path($page_slug);
			if ($page) {
				return $page->ID;
			} else {
				return null;
			}
		}
	endif;


	if ( ! function_exists( 'paginacion' ) ) :
		//paginacion($, $, $, $, $);
		function paginacion($pag_act, $pag_toT, $pag_ran, $pag_parent = false, $pag_base = '') {
			// Reset Post Data
			//wp_reset_postdata();

			//$pag_toT	=;Number of pages
			//$pag_ran	=;Number of links to display
			//$pgdAct	=;Actual page
			$hml = '';
			// switch(is_archive()):
				// case true:
					// $pag_base	= '/';
				// break;
				// case false:
					// if($pag_parent == false):
						// $pag_base = get_permalink($pag_parent);
					// else:
						// $pag_base	= get_permalink($pag_parent);
					// endif;
				// break;
			// endswitch;

			//--
			//$pag_base	.=	(is_archive()) ? 'page/' : '';

			//$pag_base = "";
			//$pag_base = get_permalink($pag_actual);

			//var_dump( array( '$pag_act'=>$pag_act, '$pag_toT' => $pag_toT, '$pag_ran'=>$pag_ran, '$pag_base'=>$pag_base  ));

			//$pag_ran = 6;
			$showitems = ($pag_ran * 2) + 1;
			if (empty($pag_act)) {
				$pag_act = 1;
			}
			if (1 != $pag_toT) {
				$hml .= "<ul class='pagination'>";
				if ($pag_act > 2 && $pag_act > $pag_ran + 1 && $showitems < $pag_toT) {
					//$hml		.=		"<a href='".get_pagenum_link(1)."'>&laquo;</a>";
					$hml .= "<li><a data-pag=".($pag_base - 1)." href='".$pag_base."1'>Inicio</a></li>";
				}
				if ($pag_act > 1 && $showitems < $pag_toT) {
					//$hml		.=		"<a href='".'get_pagenum_link($pag_act - 1)'."'>&lsaquo;</a>";
					$hml .= "<li><a data-pag=".($pag_act - 1)." href='".$pag_base."'". ($pag_act - 1) . "'>Anterior</a></li>";
				}
				for ($i = 1; $i <= $pag_toT; $i++) {
					if (1 != $pag_toT && (!($i >= $pag_act + $pag_ran + 1 || $i <= $pag_act - $pag_ran - 1) || $pag_toT <= $showitems )) {
						$hml .=
								( $pag_act == $i) ?
									"<li class='active'><a href='#'>". $i . " <div class='current sr-only'>" . "&nbsp;" . "</div></a></li>" :
								//"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
									"<li><a data-pag=".$i." href='".$pag_base."".$i."' class='inactive' >" . $i . "</a></li>";
					}
				}

				if ($pag_act < $pag_toT && $showitems < $pag_toT) {
					//$hml		.=	"<a href='".get_pagenum_link($pag_act + 1)."'>&rsaquo;</a>";
					$hml .= "<a data-pag=".($pag_act + 1)." href='".$pag_base."". ($pag_act + 1) . "'>Siguiente</a>";
				}
				if ($pag_act < $pag_toT - 1 && $pag_act + $pag_ran - 1 < $pag_toT && $showitems < $pag_toT) {
					//$hml		.=	"<a href='".get_pagenum_link($pag_toT)."'>&raquo;</a>";
					$hml .= "<a data-pag=".$pag_toT." href='".$pag_base."" . ($pag_toT) . "'>Final</a>";
				}
				$hml .= "</ul>\n";
				/*
				$hml .= 'pgdNum-> '.$pag_act.'<br>';
				$hml .= 'pgdTot-> '.$pag_toT.'<br>';
				$hml .= 'pgdRng-> '.$pag_ran.'<br>';
				*/
			}
			return $hml;
		}
	endif;


?>