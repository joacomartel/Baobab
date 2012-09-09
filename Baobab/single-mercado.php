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
						<?php _e("Condición", "Baobab"); ?>
					</th>
					<th class="w34">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/single_tag.png"/>
						<?php _e("Valor", "Baobab"); ?>
					</th>
					<th class="w33">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/single_contacto.png"/>
						<?php _e("Contacto", "Baobab"); ?>
					</th>
				</tr>
				<tr>
					<td><?php echo get_post_meta($post->ID, 'Condicion', true); ?></td>
					<td><?php echo get_post_meta($post->ID, 'Valor', true); ?></td>
					<td>
						<!-- Usuario Logueado puede enviar mail --><?php if (is_user_logged_in()){ ?><a class="btn green" href="mailto:<?php the_author_meta('email'); ?>"><?php _e("Enviar Mensaje","Baobab"); ?></a><?php } ?>

					<p><!-- Usuario NO-Logueado puede NO puede enviar mail --><?php if ( is_user_logged_in() ) { echo ''; } else { echo _e("Para ponerte en contacto debes","Baobab");?></p> <?php echo "<a class='btn green' href='".esc_url( get_permalink( get_page_by_title( __("Inicia Sesión", "Baobab"))))."'>";?> <?php _e("Iniciar Sesión</a>","Baobab"); }?>
					</td>
				</tr>
			</table>

			<div class="column2">
				<?php the_post_thumbnail('mercado-thumbnail'); ?>
				<?php the_content(); ?>
			</div>
			<a class="share-tw" title="<?php _e("Comparte en Twitter", "Baobab"); ?>" target="_blank" href="http://twitter.com/intent/tweet?text=<?php the_title(); ?> <?php the_permalink();?>&t=<?php the_title(); ?>"</a> 
			<a class="share-fb" title="<?php _e("Comparte en Facebook", "Baobab"); ?>" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>"></a>

			<p class="edit">
			<?php if ($post->post_author == $current_user->ID)
			{ ?><a href="<?php echo esc_url( get_permalink( get_page_by_title( __("Enviar Mercado", "Baobab")))); ?>?&id=<?php the_ID(); ?>"><?php _e("Editar Publicación", "Baobab"); ?></a><?php } ?>
			</p>
			<?php endwhile; endif; ?>
			</div> <!-- wrap -->
		</article> <!-- publicacion -->

		<aside id="archive-list">
			<div class="wrap">
				<?php if ( is_user_logged_in() ) { echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Enviar Mercado", "Baobab"))))."' class='btn blue'>"; echo _e("Crear Mercado</a>", "Baobab");} ?>
				<h2><?php _e("Mercado Actual","Baobab"); ?></h2>
				<?php listar_mercado ();?>
				<?php dynamic_sidebar(); ?>
			</div><!-- wrap -->
		</aside><!-- archive-list -->

		<?php comments_template(); ?>

	</div> <!-- pagewrap -->
</content>

<?php get_footer(); ?>