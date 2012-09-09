<?php
	/* Template Name: Archivo Proyectos */
	get_header();
?>
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.masonry.min.js"></script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.gpCarousel.js"></script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/prueba.js"></script>

		
		
		<?php $proyectos = new WP_Query(array('post_type' => 'proyecto')); if ( $proyectos->have_posts() ) : $i = 0	; while ( $proyectos->have_posts() && $i < 1 ) : $proyectos->the_post(); ?>
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
					<?php if ( is_user_logged_in() ) { echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Enviar Proyecto", "Baobab"))))."' class='btn blue'>"; echo _e("Crear Proyecto</a>", "Baobab"); }													
				else { echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Inicia Sesión", "Baobab"))))."' class='btn blue'>"; echo _e("Inicia Sesión</a>", "Baobab");}
				?>
			</div><!-- about -->

			<div class="top-news">
				<a href="<?php the_permalink(); ?>">
					<div class="top-filter">
						<?php $proyectos = new WP_Query(array('post_type' => 'proyecto')); if ( $proyectos->have_posts() ) : $i = 0	; while ( $proyectos->have_posts() && $i < 1 ) : $proyectos->the_post(); ?>
						
						
			<?php 
			if ( has_post_thumbnail() ) {// check if the post has a Post Thumbnail assigned to it.
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
						<?php _e("El proyecto ", "Baobab"); ?><?php the_title();?><?php _e(" se encuentra ", "Baobab"); ?><span><?php echo get_post_meta($post->ID, 'Estado', true); ?></span>
							<br><br>
							<?php $personas = get_id_users_in_proyect($post->ID);
							foreach($personas as $persona){
							// Crear usuario
							echo get_avatar($persona->user_id, 28);
							}
							?>
						</p>

						<p class="movil-dato"> 
							<?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,25);?>...</br></br>
							<span><?php _e("Estado: ", "Baobab")?><?php echo get_post_meta($post->ID, 'Estado', true); ?></span>
							<?php the_time ('j F, Y')?> ~ <?php the_author_meta('first_name'); ?>
						</p>

					<?php $i++; endwhile; endif; ?>

					</div><!-- top-filter -->
				</a>
			</div><!-- top-news -->
		</div><!-- portada -->





		<div class="container" id="container">
		<?php $proyectos = new WP_Query('post_type=proyecto&offset=-1&posts_per_page=100');if ( $proyectos->have_posts() ) : while ( $proyectos->have_posts() ) : $proyectos->the_post(); ?>
			<!-- <?php// if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<a href="<?php the_permalink(); ?>"> -->

				<figure class="item block col6">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('proyecto-thumbnail'); ?>
					<div class="sub-block">
						<h3><!--<?php echo titulo_corto ('...', 60);?>--><?php echo the_title();?></h3>
					</a>
						<span>
							<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'proyecto')
							echo  _e("Estado: ", "Baobab").get_post_meta($post->ID, 'Estado', true); ?>
						</span>
						<p><?php the_time ('j F, Y')?> ~ <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('first_name'); ?></a></p>
					</div><!-- sub-block -->

				</figure> <!-- item block -->

			<?php $i++; endwhile; endif; ?>
		</div><!-- container -->
		
<?php previous_posts_link(); ?>
				<?php //if ( function_exists('wp_pagenavi') ) wp_pagenavi(); ?>

	</div> <!-- pagewrap -->
</content>
<?php get_footer() ?>
