<?php get_header(); ?>

<content>
	<div id="pagewrap">

		<article id="publicacion">

			<div class="wrap">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div id="avatar"><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php echo get_avatar( $post->post_author, 50 );?></a></div>
			<div class="title">
				<p><?php _e("Publicado por ", "Baobab"); ?><?php the_author_posts_link(); ?>, <?php the_time ('j F Y')?></p>
				<h3><?php the_title(); ?></h3>
				<p><?php the_category(', ') ?></p>
			</div>

			<ul class="info">
				<li>
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/single_compra.png"/>
					<h4><?php _e("Estado", "Baobab"); ?></h4><br>
					<p><?php echo get_post_meta($post->ID, 'Estado', true); ?></p>

					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/single_lista.png"/>
					<?php
						$etapas = get_post_meta($post->ID, 'Etapas', true);
						if ( $etapas ) {
							echo _e("<h4>Etapas</h4>", "Baobab");				
							echo '<ol>';
							foreach ( $etapas as $etapa ) {
								echo '<li>'. $etapa .'</li>';
							}
							echo '</ol>';
						}
					?>
				</li>
				<li>
					<h4><?php _e("Equipo", "Baobab"); ?></h4><br>
					<div class="personas"><!-- personas -->
                        <?php $personas = get_id_users_in_proyect($post->ID);
                            foreach($personas as $persona){
                                // Crear usuario
                                echo "<a href='".get_author_posts_url($persona->user_id)."'>";
                                echo get_avatar($persona->user_id, 28);
                                echo "</a>";
                            }
                        ?>
					</div><!-- end personas -->
                    
                    <?php
                    global $current_user;
                    get_currentuserinfo();
                    if(!is_user_participating($post->ID,$current_user->ID) && is_user_logged_in()) {?>
                        <!-- Interfaz del usuario logeado que no pertenece al proyecto -->
                        <form id="formulario-proyecto-unirse" method="post" action="<?php bloginfo('url'); ?>/index.php">
                           <?php wp_nonce_field('participar_proyecto', '_proyecto_unirse'); ?>
                           <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>" />
                           <input type="submit" class="button color_green" value="<?php _e("Únete", "Baobab"); ?>" />
                        </form>
                        <!-- fin interfaz -->
                    <?php } else { ?>
                        <!-- Interfaz del que ya pertenece a este proyecto -->
                        <!-- <input type="button" class="button color_green" value="Algo bkn" />-->
                        <!-- fin interfaz -->
                    <?php } ?>

<?php
if ( is_user_logged_in() ) {
    echo '';
} else {
	echo  _e("Para participar debe ", "Baobab"); echo "<a href='".site_url()."/wp-login.php'>"; echo _e("Inicia Sesión</a>", "Baobab"); 
}
?>
				</li>
			</ul>
			<div class="column2">
				<?php the_post_thumbnail('proyecto-thumbnail'); ?>
				<p><?php the_content(); ?></p>
			</div>

			<a class="share-tw" title="<?php _e("Comparte en Twitter", "Baobab"); ?>" target="_blank" href="http://twitter.com/intent/tweet?text=<?php the_title(); ?> <?php the_permalink();?>&t=<?php the_title(); ?>"</a> 
			<a class="share-fb" title="<?php _e("Comparte en Facebook", "Baobab"); ?>" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>"></a>
			<p class="edit">
			<?php if ($post->post_author == $current_user->ID){ ?><a href="<?php echo esc_url( get_permalink( get_page_by_title( __("Enviar Proyecto", "Baobab")))); ?>?&id=<?php the_ID(); ?>"><?php _e("Editar Publicación", "Baobab"); ?></a><?php } ?>
			</p> 
			<?php endwhile; endif; ?>
			</div> <!-- wrap -->

		</article> <!-- publicacion -->

		<aside id="archive-list">						
			<?php if ( is_user_logged_in() ) { echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Enviar Proyecto", "Baobab"))))."' class='button color_blue'>"; echo _e("Crear Proyecto</a>", "Baobab"); } ?>													
					
			<h2><?php _e("Últimos Proyectos", "Baobab"); ?></h2>
			<?php listar_proyectos ();?>
		</aside><!-- archive-list -->

		<?php comments_template(); ?>

	</div> <!-- pagewrap -->
</content>

<?php get_footer(); ?>
