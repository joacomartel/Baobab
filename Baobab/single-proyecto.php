<?php get_header(); ?>

<content>
	<div class="pagewrap">

		<article id="publicacion">

			<div class="wrap">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div id="avatar"><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php echo get_avatar( $post->post_author, 50 );?></a></div>
			<div class="title">
				<p><?php _e("Publicado por ", "Baobab"); ?><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?></a> ~ <?php the_time ('j F, Y')?></p>
				<h3><?php the_title(); ?></h3>
				<p><?php the_category(', ') ?></p>
				<p><?php the_tags(', '); ?></p>
			</div>

			<table class="w100">
			<tr>
				<th class="w33">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/single_compra.png"/>
					<?php _e("Estado", "Baobab"); ?>
				</th>
				<th class="w34">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/single_lista.png"/>
					<?php _e("Etapas", "Baobab"); ?>
				</th>
				<th class="w33">
					<?php _e("Equipo", "Baobab"); ?>
				</th>
			</tr>
			<tr>
				<td><?php echo get_post_meta($post->ID, 'Estado', true); ?></td>
				<td><?php
						$etapas = get_post_meta($post->ID, 'Etapas', true);
						if ( $etapas ) {
							echo '<ol>';
							foreach ( $etapas as $etapa ) {
								echo '<li>'. $etapa .'</li>';
							}
							echo '</ol>';
						}
					?>
				</td>
				<td>
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
                        <form id="formulario-proyecto-unirse" method="post" action="<?php echo home_url(); ?>/index.php">
                           <?php wp_nonce_field('participar_proyecto', '_proyecto_unirse'); ?>
                           <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>" />
                           <input type="submit" class="btn green" value="<?php _e("Únete", "Baobab"); ?>" />
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
	echo'<p>'; echo  _e("Para participar debe ", "Baobab"); echo'</p>'; echo "<a class='btn green' href='".esc_url( get_permalink( get_page_by_title( __("Inicia Sesión", "Baobab"))))."'>"; echo _e("Inicia Sesión</a>", "Baobab"); 
}
?>
				</td>
			</tr>
			</table>

			<div class="column2">
				<?php the_post_thumbnail('proyecto-thumbnail'); ?>
				<?php the_content(); ?>
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
			<div class="wrap">
				<?php if ( is_user_logged_in() ) { echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Enviar Proyecto", "Baobab"))))."' class='btn blue'>"; echo _e("Crear Proyecto</a>", "Baobab"); } ?>													
				<h2><?php _e("Últimos Proyectos", "Baobab"); ?></h2>
				<?php listar_proyectos ();?>
				<?php dynamic_sidebar(); ?>
			</div><!-- wrap -->
		</aside><!-- archive-list -->

		<?php comments_template(); ?>

	</div> <!-- pagewrap -->
</content>

<?php get_footer(); ?>
