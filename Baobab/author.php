<?php get_header(); ?>
			<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/jquery.jscrollpane.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.masonry.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.gpCarousel.js"></script>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/prueba.js"></script>

<div id="pagewrap">

	<div class="container" id="container">
		<div class="item block">
			<h1><?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?></h1>
			<h4 class="sub-block">Publicaciones de <?php echo $curauth->nickname; ?>:</h4><?php echo get_avatar( get_queried_object_id(), '512' );?>
			<!-- Nombre y Apellido -->
			<?php echo $curauth->first_name;?> <?php echo $curauth->last_name;?></br>
			<?php 
				echo "$curauth->user_url";
				echo "<br> $curauth->description";
				echo "<br>"; $id = $curauth->ID; $key = 'carrera'; echo esc_attr( get_the_author_meta( $key, $id) );
				$id = $curauth->ID; $key = 'facebook'; echo esc_attr( get_the_author_meta( $key, $id) ); echo "<br>";
				$id = $curauth->ID; $key = 'twitter'; echo esc_attr( get_the_author_meta( $key, $id) ); 		
			?>
			</div> <!-- item block -->	

	<?php
    	$entries = new WP_Query(array(
			'post_type' => array('proyecto', 'debate', 'evento', 'noticia', 'idea', 'mercado'),
			'paged' => get_query_var('paged'),
			'author' => get_queried_object_id()
		));
	?>
	<?php if ( $entries->have_posts() ) : ?>
	<ul>
		<?php while( $entries->have_posts() ) : $entries->the_post(); ?>

		<a href="<?php the_permalink(); ?>">
			<figure class="item block">
				<div class="thumbs-wrapper">
					<?php the_post_thumbnail('thumbnail_proyecto'); ?>
				</div> <!-- thumbs-wrapper -->

					<div class="sub-block">
						<h4><?php echo titulo_corto ('...', 60);?></h4>
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

		<?php endwhile; ?>
		<?php else: ?>
	<?php endif; ?>
</div>
					</div><!-- container -->


</div> <!-- pagewrap -->
<?php get_footer(); ?>
