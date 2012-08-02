<?php get_header(); ?>

<content>
	<div id="pagewrap">

		<article id="publicacion">
			<div class="wrap">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div id="avatar"><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php echo get_avatar( $post->post_author, 50 );?></a></div>
			<div class="title">
				<p><?php _e("Publicado por ", "Baobab"); ?><?php the_author_posts_link(); ?>, el <?php the_time ('j \d\e F Y')?></p>
				<h3><?php the_title(); ?></h3>
				<p><?php the_category(', ') ?></p>
			</div>
			<ul class="info second">
				<li>
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/single_compra.png"/>
					<h4><?php _e("Condición", "Baobab"); ?></h4><br>
					<p><?php echo get_post_meta($post->ID, 'Condicion', true); ?></p>
				</li>
				<li>
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/single_tag.png"/>
					<h4><?php _e("Valor", "Baobab"); ?></h4>
					<p><?php echo get_post_meta($post->ID, 'Valor', true); ?></p>
				</li>
				<li>
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/single_contacto.png"/>
					<h4><?php _e("Contacto", "Baobab"); ?></h4><br>
				<!-- Usuario Logueado puede enviar mail --><?php if (is_user_logged_in()){ ?><a class="button color_green" href="mailto:<?php the_author_email(); ?>"><?php _e("Enviar Mensaje","Baobab"); ?></a><?php } ?>
				<!-- Usuario NO-Logueado puede NO puede enviar mail --><?php if ( is_user_logged_in() ) { echo ''; } else { echo "Para ponerte en contacto debes <a href='".site_url()."/wp-login.php'>Iniciar Sesión</a>"; }?>
				</li>
			</ul>
			<div class="column2">
				<?php the_post_thumbnail('mercado-thumbnail'); ?>
				<p><?php the_content(); ?></p>
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
				<?php if ( is_user_logged_in() ) { echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Enviar Mercado", "Baobab"))))."' class='button color_blue'>"; echo _e("Crear Mercado</a>", "Baobab");} ?>
			<h2><?php _e("Mercado Actual","Baobab"); ?></h2>
			<?php listar_mercado ();?>
		</aside><!-- archive-list -->

		<?php comments_template(); ?>

	</div> <!-- pagewrap -->
</content>

<?php get_footer(); ?>