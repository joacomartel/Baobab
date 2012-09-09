<?php 

if(is_user_logged_in() && isset($_FILES['user_avatar'])){

  // necesitamos esto para la función wp_handle_upload
  require_once ABSPATH.'wp-admin/includes/file.php';

  // ID del actual usuario
  $current_user_id = get_current_user_id();

  // Tipos de archivos permitidos
  $allowed_image_types = array(
    'jpg|jpeg|jpe' => 'image/jpeg',
    'png'          => 'image/png',
    'gif'          => 'image/gif',
  );

  // dejamos que wp haga el chequeo de los archivos...
  $status = wp_handle_upload($_FILES['user_avatar'], array('mimes' => $allowed_image_types));

  // ¿Sin errores? Dejado que se suba el archivo y lo cambiamos de tamaño
  if(empty($status['error'])){

    // cambio de tamaño
    $resized = image_resize($status['file'], MAX_AVATAR_WIDTH, MAX_AVATAR_HEIGHT, $crop = true);

    // Si el cambio de tamaño de la imagen falló, dígame por qué
    if(is_wp_error($resized))
      wp_die($resized->get_error_message());

    // Porfavor deme la url de la imagen con el tamaño cambiado
    $uploads = wp_upload_dir();
    $resized_url = $uploads['url'].'/'.basename($resized);

    // insertar la url del archivo en el actual usuario
    update_user_meta($current_user_id, 'custom_avatar', $resized_url);

  // error, muéstrate
  }else{
    wp_die(sprintf(__("Error al Subir el Archivo: %s", "Baobab"), $status['error']));

  }

}

get_header(); ?>
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.masonry.min.js"></script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.gpCarousel.js"></script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/prueba.js"></script>

<content>
<div class="pagewrap">

	<div class="profile-info w100">
		<div class="profile-avatar w20">
			<?php echo get_avatar( get_queried_object_id(), '512' );?>
			<!-- Subir Avatar -->	
			<?php if(is_user_logged_in() && get_current_user_id() === (int)get_query_var('author')): ?>
				<form method="POST" enctype="multipart/form-data" action="">
  					<input type="file" name="user_avatar" size="8" style="width:100%;"/>
  					<input type="hidden" name="action" value="wp_handle_upload" />
  					<input type="submit" class="btn green" value="Upload new Avatar" />
				</form>
			<?php endif; ?>
		</div><!-- profile-avatar -->
		
		<!-- Nombre y Apellido -->
		<div class="w75">
		<h2><?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?>
			<?php echo $curauth->first_name; echo " $curauth->last_name"; ?>
			<span><?php if ($id = $curauth->ID == $current_user->ID){ ?><?php echo '<a href="'.esc_url( get_permalink( get_page_by_title( __("Editar Perfil", "Baobab")))).'">'?><?php _e("Editar Perfil", "Baobab");?></a><?php } ?></span>
		</h2>

		<p><?php echo "$curauth->description";?></p>		
		<?php if ("$curauth->user_url") { ?><a target="_blank" class="share-url" href="<?php $id = $curauth->ID; $key = 'user_url'; echo esc_attr( get_the_author_meta( $key, $id) );?>"></a><?php } ?>
		<?php if ("$curauth->facebook") { ?><a target="_blank" class="share-fb" href="http://<?php $id = $curauth->ID; $key = 'facebook'; echo esc_attr( get_the_author_meta( $key, $id) ); ?>"></a><?php } ?>
		<?php if ("$curauth->twitter") { ?><a target="_blank" class="share-tw" href="http://www.twitter.com/<?php $id = $curauth->ID; $key = 'twitter'; echo esc_attr( get_the_author_meta( $key, $id) ); ?>"></a><?php } ?>
		</div><!-- w75 -->
	</div><!-- profile-info -->

	<h4 class="profile-title"><?php _e("Publicaciones de", "Baobab"); ?> <?php echo $curauth->first_name; ?>:</h4>

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
					
					</div><!-- sub -block -->
				</figure> <!-- item block -->
			
		<?php endwhile; ?>
		<?php else: ?>
	<?php endif; ?>
</div>
					</div><!-- container -->


</div> <!-- pagewrap -->
</content>

<?php get_footer(); ?>
