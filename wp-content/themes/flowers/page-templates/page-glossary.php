<?php
/**
 * Template Name: Page Glossary
 *
 * @package pliskin
 * @subpackage Flowers
 * @since Flowers 1.0
 */

get_header(); ?>

<?php
	//-- Tpl
	//$pag_tpl = get_post_meta( $post->ID, '_wp_page_template', true );
	$pag_tpl = get_page_template_slug( $post->ID );
	$pag_tpl = str_replace(array('page-templates/', '.php'), array('',''), $pag_tpl);
?>

<?php
	//-- Parameters
	$pag_ppp			=	-1;
	//$pag_act 			= 	empty(get_query_var('page')) ? 1 : get_query_var('page');
	$pag_act 			= 	1;

	//-- Pagination
	$pag_ran			=	4;
	$pag_base			=	get_permalink(0).'';
	//$pag_parent			=	get_the_ID();
	//$pag_parent			=	get_ID_by_slug( 'workshops' );

	//-- Data
	$qry 				= 	null;
	$dat 				= 	array();
	$arg 				=  	
							array(
								  'post_type'		=> 'post'
								, 'post_status'		=> 'publish' 
								, 'paged'			=> 	$pag_act 
								, 'posts_per_page'	=> 	$pag_ppp 
								, 'category_name'	=> 'glossary' 
								, 'orderby'			=> 'date'  
								, 'order'			=> 'DESC' 
							);
	//-- Respuesta
	$dat_tot 			= 	0;
	$pag_tot 			= 	0;

	//-- Llamada
	$qry 				= 	new WP_Query($arg);
	if($qry->have_posts()):
		$dat 			= 	$qry->get_posts();
		$dat_tot 		= 	count($dat);
		$pag_tot 		= 	$qry->max_num_pages;
	endif;
?>

<div id="site-main" class="site-main page-one-column <?php echo $pag_tpl; ?>">

	<!-- Specific CSS for the example -->
	<style>
		#main 
		{
			overflow: hidden;
		}

		.typeahead,
		.tt-query,
		.tt-hint {
			width: 424px;
			height: 50px;
			padding: 8px 12px;
			font-size: 24px;
			line-height: 30px;
			border: 2px solid #ccc;
			-webkit-border-radius: 8px;
			-moz-border-radius: 8px;
			border-radius: 8px;
			outline: none;
		}

		.typeahead {
			background-color: #fff;
		}

		.typeahead:focus {
			border: 2px solid #0097cf;
		}

		.tt-query {
			-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		}

		.tt-hint {
			color: #999
		}

		.tt-dropdown-menu {
			width: 422px;
			margin-top: 12px;
			padding: 8px 0;
			background-color: #fff;
			border: 1px solid #ccc;
			border: 1px solid rgba(0, 0, 0, 0.2);
			-webkit-border-radius: 8px;
			-moz-border-radius: 8px;
			border-radius: 8px;
			-webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
			-moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
			box-shadow: 0 5px 10px rgba(0,0,0,.2);
		}

		.tt-suggestion 
		{
			padding: 3px 20px;
			font-size: 18px;
			line-height: 24px;
		}
		.tt-suggestion.tt-cursor 
		{
			color: #fff;
			background-color: #0097cf;
		}
		.tt-suggestion p 
		{
			margin: 0;
		}
	</style>

	<div id="primary">

		<div id="content-area" class="content-area">
			<div id="site-content" class="site-content" role="main">

				<div class="typeahead_papa">
					<div class="typeahead_hijo" role="main">
						<span class="etiqueta">Looking for a specific word?</span> <input type="text" class="search-typeahead typeahead" data-provide="typeahead" placeholder="Type the word you are looking for" />
					</div>
				</div>

				<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();
				?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="entry-content"><?php the_content(); ?></div>
					</article>

				<?php
						// // If comments are open or we have at least one comment, load up the comment template.
						// if ( comments_open() || get_comments_number() ) {
						// 	//comments_template();
						// }
					endwhile;
				?>


				<?php
					//-- Recorrido
					if($dat_tot > 0):
				?>

					<ol id="filters">
						<?php
							$alphabets = range('A', 'Z');
							$doubleAlphabets = array();
							$count = 0;
							foreach($alphabets as $key => $alphabet):
								//$count++;
								$letter = $alphabet;
								// while ($letter <= 'Z') 
								// {
								// 	$doubleAlphabets[] = $letter;

								// 	++$letter;
								// }
						?><li data-filter="<?php echo $letter; ?>"><?php echo $letter; ?></li><?php
							endforeach;
							//var_dump($doubleAlphabets);
						?>
					</ol>

					<div id="main" class="glosario" role="main">
						<ul id="tiles">
							<!--
								These are our grid items. Notice how each one has a data-attribute assigned that
								are used for sorting. The classes match the "data-sortby" properties above.
							-->
							<?php
								//-- Recorrido
								for($con=0; $con<$dat_tot; $con++):

									//-- Articulo
									$item 			= $dat[$con];

									//-- 
									setup_postdata($item);

									//-- Data
									$post_id 		= 	$item->ID;
									$titulo 		= 	$item->post_title;
									$texto 			= 	$item->post_content;
									$slug 			= 	$item->post_name;
									//$texto 			= 	empty($item->post_excerpt)==false ? $item->post_excerpt : get_the_excerpt();
									$enlace 		= 	get_permalink($item->ID);
									$have_file		= 	get_field('have_file', $item->ID);
									$enlace_file	= 	get_field('file', $item->ID);
									//-- Autor
									$usr_id 		= 	$item->post_author;
									$usr_name 		= 	get_the_author_meta('first_name', $usr_id);
									$usr_lastname 	= 	get_the_author_meta('last_name', $usr_id);
									$usr_email 		= 	get_the_author_meta('email', $usr_id);
									//$usr_img 		= 	get_usr_image($usr_email, '210');
									$obj 			= 	get_post_custom($item->ID);
									$image 			= 	get_field('image', $item->ID);

									$let 			= 	strtoupper( $titulo[0] );
									//$let 			= 	ucfirst();
							?>

								<li data-filter-class='["<?php echo $let; ?>"]'>
									<h3><?php echo $titulo; ?></h3>
									<p><?php echo $texto; ?></p>
								</li>

							<?php
								endfor;
							?>

						</ul>
					</div>

				<?php
					endif;
				?>

				<!-- Once the page is loaded, initalize the plug-in. -->
				<script type="text/javascript">
					(function ($){
						// instantiate the bloodhound suggestion engine
						var numbers = new Bloodhound({
							  datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.title_total); }
							, queryTokenizer: Bloodhound.tokenizers.whitespace
							, limit: 10
							, local: 
							[

								<?php
									//-- Recorrido
									for($con=0; $con<$dat_tot; $con++):

										//-- Articulo
										$item 			= $dat[$con];

										//-- 
										setup_postdata($item);

										//-- Data
										$post_id 		= 	$item->ID;
										$titulo 		= 	$item->post_title;
										$texto 			= 	$item->post_content;
										$slug 			= 	$item->post_name;
										//$texto 			= 	empty($item->post_excerpt)==false ? $item->post_excerpt : get_the_excerpt();
										$enlace 		= 	get_permalink($item->ID);
										$have_file		= 	get_field('have_file', $item->ID);
										$enlace_file	= 	get_field('file', $item->ID);
										//-- Autor
										$usr_id 		= 	$item->post_author;
										$usr_name 		= 	get_the_author_meta('first_name', $usr_id);
										$usr_lastname 	= 	get_the_author_meta('last_name', $usr_id);
										$usr_email 		= 	get_the_author_meta('email', $usr_id);
										//$usr_img 		= 	get_usr_image($usr_email, '210');
										$obj 			= 	get_post_custom($item->ID);
										$image 			= 	get_field('image', $item->ID);

										$let 			= 	strtoupper( $titulo[0] );
										//$let 			= 	ucfirst();
								?>

									<?php echo ($con==0) ? '' : ','; ?>{ letter: '<?php echo $let; ?>', title_partial: '<?php echo substr($titulo, 1); ?>', title_total: '<?php echo $titulo; ?>', text: '<?php echo $texto; ?>' }

								<?php
									endfor;
								?>
							]
						});

						// initialize the bloodhound suggestion engine
						numbers.initialize();

						// instantiate the typeahead UI
						$('.search-typeahead').typeahead(null, {
							  displayKey: 	'title_total'
							, source: 		 numbers.ttAdapter()
							, name: 		'search'
							, templates: 
											{
												suggestion: Handlebars.compile([
													  '<p class="repo-first"><span class="repo-letter">{{letter}}</span><span class="repo-name">{{title_partial}}</span></p>'
													, '<p class="repo-second"><span class="repo-description">{{text}}</span></p>'
												].join(''))
											}
						});

						$('#tiles').imagesLoaded(function() {
							// Prepare layout options.
							var options = {
								  autoResize: true // This will auto-update the layout when the browser window is resized.
								, container: $('#main') // Optional, used for some extra CSS styling
								, offset: 0 // Optional, the distance between grid items
								, itemWidth: 1024 // Optional, the width of a grid item
								, fillEmptySpace: true // Optional, fill the bottom of each column with widths of flexible height
							};

							// Get a reference to your grid items.
							var handler = $('#tiles li'),
							filters = $('#filters li');

							// Call the layout function.
							handler.wookmark(options);

							/**
							* When a filter is clicked, toggle it's active state and refresh.
							*/
							var onClickFilter = function(event) {
								var item = $(event.currentTarget),
								activeFilters = [];

								if (!item.hasClass('active')) {
									filters.removeClass('active');
								}
								item.toggleClass('active');

								// Filter by the currently selected filter
								if (item.hasClass('active')) {
									activeFilters.push(item.data('filter'));
								}

								handler.wookmarkInstance.filter(activeFilters);
							}

							// Capture filter click events.
							filters.click(onClickFilter);
						});

					})(jQuery);
				</script>

			</div>
		</div>

	</div>

</div>

<?php
	//get_sidebar();
	get_footer();
?>
