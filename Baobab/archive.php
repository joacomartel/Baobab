<?php
	/* Template Name: Archivo Noticias */
	get_header();
?>
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.masonry.min.js"></script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.gpCarousel.js"></script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/prueba.js"></script>



		<?php $noticias = new WP_Query(array('post_type' => 'post')); if ( $noticias->have_posts() ) : $i = 0	; while ( $noticias->have_posts() && $i < 1 ) : $noticias->the_post(); ?>
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
				<?php if ( is_user_logged_in() ) {}
				else {echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Inicia Sesión", "Baobab"))))."' class='btn blue'>"; echo _e("Inicia Sesión</a>", "Baobab"); }
				?>
				<?php global $current_user; get_currentuserinfo(); if ($current_user->user_level == 10 ) { ?>
				<?php echo "<a href='".site_url()."/wp-admin/post-new.php' class='btn blue'>";echo _e("Crear Noticia</a>", "Baobab");}
				else{
				echo'<script>
								$("div").addClass(function(index, currentClass) {
								var addedClass;
							
								if ( currentClass === "about" ) {
								addedClass = "nothing";
								
								}
								
								return addedClass;
								});
							</script>';
				
				?>
				<?php } ?>
			</div><!-- about -->

			<div class="top-news">
				<a href="<?php the_permalink(); ?>">
					<div class="top-filter">
						<?php $noticias = new WP_Query(array('post_type' => 'post')); if ( $noticias->have_posts() ) : $i = 0	; while ( $noticias->have_posts() && $i < 1 ) : $noticias->the_post(); ?>
						
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
		<?php $noticias = new WP_Query('post_type=post&offset=-1&posts_per_page=100');if ( $noticias->have_posts() ) : while ( $noticias->have_posts() ) : $noticias->the_post(); ?>

				<figure class="item block col6">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('noticia-thumbnail'); ?>
					<div class="sub-block">
						<h3><?php echo titulo_corto ('...', 60);?></h3>
					</a>
						<p><?php the_time ('j F, Y')?> ~ <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('first_name'); ?></a></p>
					</div><!-- sub-block -->

				</figure> <!-- item block -->

			<?php $i++; endwhile; endif; ?>
		</div><!-- container -->
	</div> <!-- pagewrap -->
</content>
<?php get_footer() ?>