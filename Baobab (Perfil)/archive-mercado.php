<?php
	/* Template Name: Archivo Mercado */
	get_header();
?>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/jquery.jscrollpane.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.masonry.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.gpCarousel.js"></script>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/prueba.js"></script>



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
	<div id="pagewrap">
		<h2><?php _e("Mercado Actual","Baobab"); ?></h2>
		<a href="<?php echo $_SERVER["REQUEST_URI"] ?>/feed" title="<?php _e('Syndicate this site using RSS'); ?>">
		<img src="http://www.mozilla.org/images/feed-icon-14x14.png" alt="RSS Feed" title="RSS Feed" /></a>
		
		<div class="portada">
			<div class="about">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/portada-mercado.png"/>
				<?php _e("<p>En <span>Mercado</span> puedes poner en venta o comprar artículos y colocarte en contacto con quien lo ofrece.</p>", "Baobab"); ?>
				<?php if ( is_user_logged_in() ) { echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Enviar Mercado", "Baobab"))))."' class='button color_blue'>"; echo _e("Crear Mercado</a>", "Baobab");}
				else {echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Inicia Sesión", "Baobab"))))."' class='button color_blue'>"; echo _e("Inicia Sesión</a>", "Baobab");}
				?>
			</div><!-- about -->
			
			<div class="top-news">
			<a href="<?php the_permalink(); ?>">
				<div class="top-filter">
						<?php $mercados = new WP_Query(array('post_type' => 'mercado')); if ( $mercados->have_posts() ) : $i = 0	; while ( $mercados->have_posts() && $i < 1 ) : $mercados->the_post(); ?>
						<h3><?php echo titulo_corto ('...', 60);?></h3>
						<p><?php wp_limit_post(150, '...', true) ?></p>
						<p class="top-dato">
						<?php _e("Su condición es ","Baobab");?><span><?php echo get_post_meta($post->ID, 'Condicion', true); ?></span> <?php _e("y su valor es", "Baobab");?> <span><?php echo get_post_meta($post->ID, 'Valor', true); ?></span>
						</p>
					<?php $i++; endwhile; endif; ?>
				</div><!-- top-filter -->
				</a>
			</div><!-- top-news -->
		</div><!-- portada -->

		<div class="container" id="container">
		<?php $mercados = new WP_Query('post_type=mercado&offset=-1&posts_per_page=100');if ( $mercados->have_posts() ) : while ( $mercados->have_posts() ) : $mercados->the_post(); ?>
				<figure class="item block">
					<div class="thumbs-wrapper">
						<?php the_post_thumbnail('proyecto-thumbnail'); ?>
					</div> <!-- thumbs-wrapper -->
					<div class="sub-block">
						<a href="<?php the_permalink(); ?>">
						<h3><?php echo titulo_corto ('...', 60);?></h3>
						<p class="block-text"><?php wp_limit_post(90, '...', true) ?></p>
						</a>
						<p><?php the_time ('j F, Y')?></p>
						<p><?php the_category(', ') ?></p>
					</div><!-- sub-block -->

					<figcaption id="clickeable" onclick="location.href='<?php the_permalink(); ?>';" style="cursor:pointer;">
						<a href="<?php the_permalink(); ?>">
							<p>"<?php 
							//limit post if has an image
							if(has_post_thumbnail()) {
							echo ''.wp_limit_post(100, '...', true);
							} else {
							echo ''.wp_limit_post(20, '...', true);;
							}
							?>""
							<span><?php echo get_post_meta($post->ID, 'Condicion', true); ?></span>
							</p>
						</a>
					</figcaption>

				</figure> <!-- item block -->
				
			<?php $i++; endwhile; endif; ?>
		</div><!-- container -->
	</div> <!-- pagewrap -->
</content>
<?php get_footer() ?>