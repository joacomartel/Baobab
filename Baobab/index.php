<?php get_header(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/jquery.jscrollpane.css" />
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.masonry.min.js"></script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.gpCarousel.js"></script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/prueba.js"></script>

<content>
	<div class="pagewrap">
		<h2><?php _e("Últimas Publicaciones", "Baobab"); ?></h2>
		<div class="container" id="container">
			<?php $proyectos = new WP_Query(array('post_type' => array('proyecto', 'debate', 'evento', 'mercado', 'idea', 'post'))); 			 
			if ( $proyectos->have_posts() ) : ; while ( $proyectos->have_posts()  ) : $proyectos->the_post();?>
			
				<figure class="item block col6">

					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('proyecto-thumbnail'); ?>
					</a>
					
					<div class="sub-block">
						<h2>
						<!-- para cada post un color -->
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'evento'){
							echo '<div class="post-box type-evento"></div>';
							
							echo '<h2 class="evento">' .get_post_type( $post->ID ); '</h2>';
							}
						?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'proyecto'){
							echo '<div class="post-box type-proyecto"></div>';
							echo '<h2 class="proyecto"
							">' .get_post_type( $post->ID ); '</h2>';
							}
						?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'debate'){
							echo '<div class="post-box type-debate"></div>';
							echo '<h2 class="debate">' .get_post_type( $post->ID ); '</h2>';
							}
						?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'mercado'){
							echo '<div class="post-box type-mercado"></div>';
							echo '<h2 class="mercado">' .get_post_type( $post->ID ); '</h2>';
							}
						?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'idea'){
							echo '<div class="post-box type-idea"></div>';
							echo '<h2 class="idea">' .get_post_type( $post->ID ); '</h2>';
							}
						?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'post'){
							echo '<div class="post-box type-noticia"></div>';
							echo '<h2 class="noticia">' .get_post_type( $post->ID ); '</h2>';
							}
						?>
						
						</h2>

						<a href="<?php the_permalink(); ?>">
							<h3><?php echo the_title();?></h3>
						</a>					
					
						<span>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'evento')
						echo ''.the_modified_date('j F, Y'); ?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'proyecto')
						echo  _e("Estado: ", "Baobab").get_post_meta($post->ID, 'Estado', true); ?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'debate')
						echo ''._e(" concluye el ", "Baobab");?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'debate')
						echo''.the_modified_date('j F, Y');?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'mercado')
						echo ''.get_post_meta($post->ID, 'Condicion', true);?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'mercado')
						echo ''.get_post_meta($post->ID, 'Valor', true);?>
						<!-- 
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'idea')
						echo ''.$my_var = get_comments_number( $post_id );?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'idea')
						echo  _e(" Comentarios", "Baobab");?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'post')
						echo ''.$my_var = get_comments_number( $post_id );?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'post')
						echo _e(" Comentarios", "Baobab");?>
						-->
						</span>
					
					<p><?php the_time ('j F, Y')?> ~ <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('first_name'); ?></a></p>

					<!--  
						<p> <?php _e("Publicado por ", "Baobab"); ?><?php the_author_posts_link(); ?></p>
						<p> ˜ <?php the_category(', ') ?></p>
					-->
					
					</div><!-- sub -block -->
				</figure> <!-- item block -->
		<?php endwhile; else : echo wpautop( 'Lo siento, no encontré publicaciones' ); endif; ?>
		</div><!-- container -->
	</div> <!-- pagewrap -->
</content>
<?php get_footer(); ?>