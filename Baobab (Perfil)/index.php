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
		<h2><?php _e("Últimas Publicaciones", "Baobab"); ?></h2>
		<div class="container" id="container">
			<?php $proyectos = new WP_Query(array('post_type' => array('proyecto', 'debate', 'evento', 'mercado', 'idea', 'post'))); 			 
			if ( $proyectos->have_posts() ) : ; while ( $proyectos->have_posts()  ) : $proyectos->the_post();?>
			
				<figure class="item block">

					<div class="thumbs-wrapper">
						<a href="<?php the_permalink(); ?>">

						
						<?php the_post_thumbnail('proyecto-thumbnail'); ?>
					</div> <!-- thumbs-wrapper -->
					<div class="sub-block">
						<h3><?php echo titulo_corto ('...', 60);?></a></h3>

						<!--<p>Publicado el <?php the_time ('j F, Y')?></p>-->
						<p><?php _e("Publicado por ", "Baobab"); ?><?php the_author_posts_link(); ?></p>
						<p><?php the_category(', ') ?></p>

						<!-- me muestra el tipo de post
						<div id="info"><?php echo ''.get_post_type( $post->ID ); ?></div> -->


						<!-- para cada post un color -->
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'evento')
						echo '<div class="post-box type-evento"></div>'; ?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'proyecto')
						echo '<div class="post-box type-proyecto"></div>'; ?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'debate')
						echo '<div class="post-box type-debate"></div>'; ?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'mercado')
						echo '<div class="post-box type-mercado"></div>'; ?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'idea')
						echo '<div class="post-box type-idea"></div>'; ?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'post')
						echo '<div class="post-box type-noticia"></div>'; ?>


					</div><!-- sub-block -->
					<figcaption id="clickeable" onclick="location.href='<?php the_permalink(); ?>';" style="cursor:pointer;">
					<a href="<?php the_permalink(); ?>">
					<p>"
					
					<?php 
					//This must be in one loop
					if(has_post_thumbnail()) {
						echo ''.wp_limit_post(100, '...', true);
					} else {
						echo ''.wp_limit_post(20, '...', true);;
					}
					?>"

						<span>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'evento')
						echo ''.the_modified_date('j F, Y'); ?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'proyecto')
						echo  _e("Estado: ", "Baobab").get_post_meta($post->ID, 'Estado', true); ?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'debate')
						echo ''.the_modified_date('j F, Y'); ?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'mercado')
						echo ''.get_post_meta($post->ID, 'Condicion', true); ?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'idea')
						echo ''.$my_var = get_comments_number( $post_id );?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'idea')
						echo  _e(" Comentarios", "Baobab");?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'post')
						echo ''.$my_var = get_comments_number( $post_id );?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'post')
						echo _e(" Comentarios", "Baobab");?>
						</span>
					</p>
					</a>
					</figcaption>

				</figure> <!-- item block -->	
		<?php endwhile; else : echo wpautop( 'Lo siento, no encontré publicaciones' ); endif; ?>
		</div><!-- container -->
	</div> <!-- pagewrap -->
</content>
<?php get_footer(); ?>