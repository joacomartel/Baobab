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
		<h2><?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?><?php echo $curauth->nickname; ?>
			<span><?php echo ""; $id = $curauth->ID; $key = 'carrera'; echo esc_attr( get_the_author_meta( $key, $id) ); ?>
			<?php if ($id = $curauth->ID == $current_user->ID){ ?><a href="/wp-admin/profile.php">Editar Perfil</a><?php } ?></span>
		</h2>



		<p><?php echo "$curauth->description";?></p>

		<a class="share-tw" title="Twitter de <?php echo $curauth->nickname; ?>" target="_blank" href="http://twitter.com/<?php $id = $curauth->ID; $key = 'twitter'; echo esc_attr( get_the_author_meta( $key, $id) );  ?>"</a> 
		<a class="share-fb" title="Facebook de <?php echo $curauth->nickname; ?>" target="_blank" href="http://<?php $id = $curauth->ID; $key = 'facebook'; echo esc_attr( get_the_author_meta( $key, $id) ); ?>"></a>

	</div><!-- profile-info -->

	<h4 class="profile-title">Publicaciones de <?php echo $curauth->nickname; ?>:</h4>

	<div class="container" id="container">
	
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
					<a href="<?php the_permalink(); ?>">

						
						<?php the_post_thumbnail('proyecto-thumbnail'); ?>
					</div> <!-- thumbs-wrapper -->
					<div class="sub-block">
						<h3><?php echo titulo_corto ('...', 60);?></a></h3>

						<!--<p>Publicado el <?php the_time ('j \d\e F, Y')?></p>-->
						<p>Publicado por <?php the_author_posts_link(); ?></p>
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
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'noticia')
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
						echo ''.wp_limit_post(30, '...', true);;
					}
					?>"

						<span>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'evento')
						echo ''.the_modified_date('j \d\e F'); ?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'proyecto')
						echo 'Estado: '.get_post_meta($post->ID, 'Estado', true); ?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'debate')
						echo ''.the_modified_date('j \d\e F'); ?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'mercado')
						echo ''.get_post_meta($post->ID, 'Condicion', true); ?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'noticia')
						echo ''.$my_var = get_comments_number( $post_id ).' Comentarios';?>
						<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'idea')
						echo ''.$my_var = get_comments_number( $post_id ).' Comentarios';?>
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
