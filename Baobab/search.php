<?php
/*
Template Name: Search Page
*/
global $wp_query;
?>


<?php get_header(); ?>

		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/jquery.jscrollpane.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.masonry.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.gpCarousel.js"></script>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/prueba.js"></script>

<content>
	<div id="pagewrap">
		<h2>Búsqueda</h2>
	
		<div class="container" id="container">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<a href="<?php the_permalink(); ?>">

				<figure class="item block">
					<div class="thumbs-wrapper">
						<?php the_post_thumbnail('proyecto-thumbnail'); ?>
					</div> <!-- thumbs-wrapper -->
					<div class="sub-block">
						<h4><?php echo titulo_corto ('...', 60);?></h4>
			</a>

						<a href="<?php the_permalink(); ?>">
							<p class="block-text"><?php wp_limit_post(90, '...', true) ?></p>
						</a>
						
						<p><?php the_time ('j \d\e F, Y')?></p>
						<p><?php the_category(', ') ?></p>
					</div><!-- sub-block -->
					
					<figcaption>
						<div id="avatar"><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php echo get_avatar( $post->post_author, 50 );?></a></div>
						Publicado por, <?php the_author_posts_link(); ?>

						<a href="<?php the_permalink(); ?>">
							<p><?php wp_limit_post(100, '...', true) ?></p>
							<div class="comentarios"><?php comments_popup_link( __( '0' ), __( '1' ), __( '%' ) ) ?></div>
						</a>
					</figcaption>

				</figure> <!-- item block -->

			<?php $i++; endwhile; endif; ?>
		</div><!-- container -->
	</div> <!-- pagewrap -->
</content>

<?php get_footer() ?>

