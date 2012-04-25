<?php get_header() ?>		
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/jquery.jscrollpane.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.masonry.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.gpCarousel.js"></script>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/prueba.js"></script>

<div id="pagewrap">
	<div class="container" id="container">

<?php
	$entries = new WP_Query(array(
		'post_type' => array('proyecto', 'debate', 'evento', 'noticia', 'mercado', 'idea'),
		'paged' => get_query_var('paged'),
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'terms' => get_queried_object_id(),
				'field' => 'id'
			)
		)
	));
	if ( $entries->have_posts() ) {
		while ( $entries->have_posts() ) {
			$entries->the_post();
?>
			<a href="<?php the_permalink(); ?>">

				<div class="item block">
					<div class="thumbs-wrapper">
						<?php the_post_thumbnail('proyecto'); ?>
					</div> <!-- thumbs-wrapper -->
					<h4><?php echo titulo_corto ('...', 60);?></h4>
			</a>
					<p><?php wp_limit_post(100, '...', true) ?></p>
					
				<div class="comentarios"><?php comments_popup_link( __( '0' ), __( '1' ), __( '%' ) ) ?></div>
				</div> <!-- item block -->

<?php
		}
	}
?>

			</div><!-- container -->

</div><!-- pagewrap -->

<?php get_footer() ?>



<!-- AAAAAA -->