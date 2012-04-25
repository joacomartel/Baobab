<?php
	/* Template Name: Archivo Proyectos */
	get_header();
?>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/jquery.jscrollpane.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.masonry.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.gpCarousel.js"></script>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/prueba.js"></script>

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

<content>
	<div id="pagewrap">
		<h2>Proyectos Recientes</h2>
		<a href="<?php $bloginfo = get_bloginfo(); ?>feed/" title="<?php _e('Syndicate this site using RSS'); ?>">
		<img src="http://www.mozilla.org/images/feed-icon-14x14.png" alt="RSS Feed" title="RSS Feed" /></a>

		<div class="portada">
		
			<div class="about">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/portada-proyecto.png"/>
				<p>En un <span>Proyecto</span> puedes vincular ideas, listar tareas y generar conversaciones. ¡Únete!</p>
				<?php if ( is_user_logged_in() ) { echo '<a href="/enviar-proyecto/" class="button color_blue">Crear Proyecto</a>';}
				else {echo '<a href="/wp-login.php" class="button color_blue">Inicia Sesión</a>';}
				?>
			</div><!-- about -->

			<div class="top-news">
				<a href="<?php the_permalink(); ?>">
					<div class="top-filter">
						<?php $proyectos = new WP_Query(array('post_type' => 'proyecto')); if ( $proyectos->have_posts() ) : $i = 0	; while ( $proyectos->have_posts() && $i < 1 ) : $proyectos->the_post(); ?>
					
						<h4><?php echo titulo_corto ('...', 60);?></h4>
						<p><?php wp_limit_post(150, '...', true) ?></p>
						<p class="top-dato">
						El proyecto <?php the_title();?> se encuentra <span><?php echo get_post_meta($post->ID, 'Estado', true); ?></span>
							<br><br>
							<?php $personas = get_id_users_in_proyect($post->ID);
							foreach($personas as $persona){
							// Crear usuario
							echo get_avatar($persona->user_id, 28);
							}
							?>
						</p>
					<?php $i++; endwhile; endif; ?>

					</div><!-- top-filter -->
				</a>
			</div><!-- top-news -->
		</div><!-- portada -->

			
		<div class="container" id="container">
		<?php $proyectos = new WP_Query('post_type=proyecto&offset=-1&posts_per_page=100');if ( $proyectos->have_posts() ) : while ( $proyectos->have_posts() ) : $proyectos->the_post(); ?>
			<?php// if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
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
					
					<figcaption id="clickeable" onclick="location.href='<?php the_permalink(); ?>';" style="cursor:pointer;">
						<a href="<?php the_permalink(); ?>">
							<p>"<?php 
							//limit post if has an image
							if(has_post_thumbnail()) {
							echo ''.wp_limit_post(100, '...', true);
							} else {
							echo ''.wp_limit_post(30, '...', true);;
							}
							?>""
							<span><?php echo get_post_meta($post->ID, 'Estado', true); ?></span>
							</p>
						</a>
					</figcaption>
				</figure> <!-- item block -->
			<?php $i++; endwhile; endif; ?>
		</div><!-- container -->
		
<?php previous_posts_link(); ?>
				<?php //if ( function_exists('wp_pagenavi') ) wp_pagenavi(); ?>

	</div> <!-- pagewrap -->
</content>
<?php get_footer() ?>
