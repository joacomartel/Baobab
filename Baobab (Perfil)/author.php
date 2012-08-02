<?php get_header(); ?>
			<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/jquery.jscrollpane.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.masonry.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.gpCarousel.js"></script>
		<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/prueba.js"></script>

<div id="pagewrap">

	<div class="profile-info">
		<div class="profile-avatar">
			<?php echo get_avatar( get_queried_object_id(), '512' );?>
		</div><!-- profile-avatar -->
		<!-- Nombre y Apellido -->
		<h2><?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?><?php echo $curauth->display_name; ?>
			<span><em><?php echo "$curauth->first_name";  echo " $curauth->last_name"; ?></em></span>
			<span><?php if ($id = $curauth->ID == $current_user->ID){ ?><a href="<?php echo site_url(); ?>/wp-admin/profile.php"><?php _e("Editar Perfil", "Baobab");?></a><?php } ?></span>
		</h2>


		<p><?php echo "$curauth->description";?></p>
		
		<?php if ("$curauth->user_url") { ?><a target="_blank" class="share-url" href="<?php $id = $curauth->ID; $key = 'user_url'; echo esc_attr( get_the_author_meta( $key, $id) );?>"></a><?php } ?>
		<?php if ("$curauth->facebook") { ?><a target="_blank" class="share-fb" href="http://<?php $id = $curauth->ID; $key = 'facebook'; echo esc_attr( get_the_author_meta( $key, $id) ); ?>"></a><?php } ?>
		<?php if ("$curauth->twitter") { ?><a target="_blank" class="share-tw" href="http://www.twitter.com/<?php $id = $curauth->ID; $key = 'twitter'; echo esc_attr( get_the_author_meta( $key, $id) ); ?>"></a><?php } ?>
			
	</div><!-- profile-info -->

	<h4 class="profile-title"><?php _e("Publicaciones de", "Baobab"); ?> <?php echo $curauth->display_name; ?>:</h4>

	<div class="container" id="container">
	
	<?php
		$entries = new WP_Query(array(
			'post_type' => array('proyecto', 'debate', 'evento', 'noticia', 'idea', 'mercado', 'post'),
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
					<a href="<?php the_permalink(); ?>">

						
						<?php the_post_thumbnail('proyecto-thumbnail'); ?>
					</div> <!-- thumbs-wrapper -->
					<div class="sub-block">
						<h3><?php echo titulo_corto ('...', 60);?></a></h3>

						<!--<p>Publicado el <?php the_time ('j F, Y')?></p>-->
						<p><?php the_time ('j F, Y')?></p>
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
		<?php endwhile; ?>
		<?php else: ?>
	<?php endif; ?>
</div>
					</div><!-- container -->


</div> <!-- pagewrap -->
<?php get_footer(); ?>
