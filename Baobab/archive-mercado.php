<?php
	/* Template Name: Archivo Mercado */
	get_header();
?>
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.masonry.min.js"></script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.gpCarousel.js"></script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/prueba.js"></script>



		<?php $mercados = new WP_Query(array('post_type' => 'mercado')); if ( $mercados->have_posts() ) : $i = 0	; while ( $mercados->have_posts() && $i < 1 ) : $mercados->the_post(); ?>
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
				<?php if ( is_user_logged_in() ) { echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Enviar Mercado", "Baobab"))))."' class='btn blue'>"; echo _e("Crear Mercado</a>", "Baobab");}
				else {echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Inicia Sesión", "Baobab"))))."' class='btn blue'>"; echo _e("Inicia Sesión</a>", "Baobab");}
				?>
			</div><!-- about -->
			
			<div class="top-news">
			<a href="<?php the_permalink(); ?>">
				<div class="top-filter">
						<?php $mercados = new WP_Query(array('post_type' => 'mercado')); if ( $mercados->have_posts() ) : $i = 0	; while ( $mercados->have_posts() && $i < 1 ) : $mercados->the_post(); ?>

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
						<p class="top-dato">
						<?php _e("Su condición es ","Baobab");?><span><?php echo get_post_meta($post->ID, 'Condicion', true); ?></span> <?php _e("y su valor es", "Baobab");?> <span><?php echo get_post_meta($post->ID, 'Valor', true); ?></span>
						</p>
						<p class="movil-dato">
							<?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,25);?>...</br></br>
							<span>
								<?php echo get_post_meta($post->ID, 'Condicion', true);?>
								<?php echo get_post_meta($post->ID, 'Valor', true); ?>
							</span>
							<?php the_time ('j F, Y')?> ~ <?php the_author_meta('first_name'); ?>
						</p>
					<?php $i++; endwhile; endif; ?>
				</div><!-- top-filter -->
				</a>
			</div><!-- top-news -->
		</div><!-- portada -->

		<div class="container" id="container">
		<?php $mercados = new WP_Query('post_type=mercado&offset=-1&posts_per_page=100');if ( $mercados->have_posts() ) : while ( $mercados->have_posts() ) : $mercados->the_post(); ?>

				<figure class="item block col6">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('mercado-thumbnail'); ?>
					<div class="sub-block">
						<h3><!--<?php echo titulo_corto ('...', 60);?>--><?php echo the_title();?></h3>
					</a>
					
						<span>
							<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'mercado')
							echo ''.get_post_meta($post->ID, 'Condicion', true);?>
							<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'mercado')
							echo ''.get_post_meta($post->ID, 'Valor', true);?>
						</span>
						<p><?php the_time ('j F, Y')?> ~ <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('first_name'); ?></a></p>
					</div><!-- sub-block -->

				</figure> <!-- item block -->
				
			<?php $i++; endwhile; endif; ?>
		</div><!-- container -->
	</div> <!-- pagewrap -->
</content>
<?php get_footer() ?>