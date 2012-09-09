<?php
	/* Template Name: Archivo Ideas */
	get_header();
?>
		<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/jquery.jscrollpane.css" />
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.masonry.min.js"></script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.gpCarousel.js"></script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/prueba.js"></script>
		
		
		
		<?php $ideas = new WP_Query(array('post_type' => 'idea')); if ( $ideas->have_posts() ) : $i = 0	; while ( $ideas->have_posts() && $i < 1 ) : $ideas->the_post(); ?>
			<style type="text/css">
			.top-news {
				background-image:url('<?php	if (has_post_thumbnail()) {
				$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail_name');
				echo $thumb[0]; // thumbnail url
				} ?>');
				background-position: center center;
				background-size: cover;
			}
			</style>
		<?php $i++; endwhile; endif; ?>

<content>
	<div class="pagewrap">
		<div class="portada">
			<div class="about">
				<?php if ( is_user_logged_in() ) { echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Enviar Idea", "Baobab"))))."' class='btn blue'>"; echo _e("Crear Idea</a>", "Baobab"); }
				else {echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Inicia Sesión", "Baobab"))))."' class='btn blue'>"; echo _e("Inicia Sesión</a>", "Baobab");}
				?>			
			</div><!-- about -->

			<div class="top-news">
				<a href="<?php the_permalink(); ?>">
					<div class="top-filter">
						<?php $ideas = new WP_Query(array('post_type' => 'idea')); if ( $ideas->have_posts() ) : $i = 0	; while ( $ideas->have_posts() && $i < 1 ) : $ideas->the_post(); ?>

						<?php if ( has_post_thumbnail() ) {// check if the post has a Post Thumbnail assigned to it.
							}else{
								echo'<script>
								$("div").addClass(function(index, currentClass) {
								var addedClass;
							
								if ( currentClass === "top-news" ) {
								addedClass = "noImage";
								
								}
								
								return addedClass;
								});
							</script>';
							} 
						?>

						<h3><?php echo titulo_corto ('...', 60);?></h3>
						<p><?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,25);?>...</p>

						<p class="movil-dato"> 
							<span><?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,25);?>...</span>
							<?php the_time ('j F, Y')?> ~ <?php the_author_meta('first_name'); ?>
						</p>

					<?php $i++; endwhile; endif; ?>

					</div><!-- top-filter -->
				</a>
			</div><!-- top-news -->
		</div><!-- portada -->

		<div class="container" id="container">
		<?php $ideas = new WP_Query('post_type=idea&offset=-1&posts_per_page=100');if ( $ideas->have_posts() ) : while ( $ideas->have_posts() ) : $ideas->the_post(); ?>

				<figure class="item block col6">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('idea-thumbnail'); ?>
					<div class="sub-block">
						<h3><?php echo titulo_corto ('...', 60);?></h3>
					</a>
						<p><?php the_time ('j F, Y')?> ~ <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('first_name'); ?></a></p>
					</div><!-- sub-block -->

				</figure> <!-- item block -->


				</figure> <!-- item block -->
			<?php $i++; endwhile; endif; ?>
		</div><!-- container -->
	</div> <!-- pagewrap -->
</content>
<?php get_footer() ?>