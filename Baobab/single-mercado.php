<?php get_header(); ?>

<content>
	<div id="pagewrap">

		<article id="publicacion">
			<div class="wrap">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div id="avatar"><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php echo get_avatar( $post->post_author, 50 );?></a></div>
			<div class="title">
				<p>Publicado por <?php the_author_posts_link(); ?>, el <?php the_time ('j \d\e F Y')?></p>
				<h3><?php the_title(); ?></h3>
				<p><?php the_category(', ') ?></p>
			</div>
			<ul class="info second">
				<li>
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/single_compra.png"/>
					<h4>Condición</h4><br>
					<p><?php echo get_post_meta($post->ID, 'Condicion', true); ?></p>
				</li>
				<li>
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/single_tag.png"/>
					<h4>Valor</h4>
					<p><?php echo get_post_meta($post->ID, 'Valor', true); ?></p>
				</li>
				<li>
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/single_contacto.png"/>
					<h4>Contacto</h4><br>
				<!-- Usuario Logueado puede enviar mail --><?php if (is_user_logged_in()){ ?><a class="button color_green" href="mailto:<?php the_author_email(); ?>">Enviar Mensaje</a><?php } ?>
				<!-- Usuario NO-Logueado puede NO puede enviar mail --><?php if ( is_user_logged_in() ) { echo ''; } else { echo "Para ponerte en contacto debes <a href='".site_url()."/wp-login.php'>Iniciar Sesión</a>"; }?>
				</li>
			</ul>
			<div class="column2">
				<?php the_post_thumbnail('mercado-thumbnail'); ?>
				<p><?php the_content(); ?></p>
			</div>
			<a class="share-tw" title="Comparte en Twitter" target="_blank" href="http://twitter.com/intent/tweet?text=<?php the_title(); ?> <?php the_permalink();?>&t=<?php the_title(); ?>"</a> 
			<a class="share-fb" title="Comparte en Facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>"></a>

			<p class="edit">
			<?php if ($post->post_author == $current_user->ID)
			{ ?><a href="<?php echo get_permalink_by_postname('enviar-mercado'); ?>?&id=<?php the_ID(); ?>">editar</a><?php } ?>
			</p>
			<?php endwhile; endif; ?>
			</div> <!-- wrap -->
		</article> <!-- publicacion -->

		<aside id="archive-list">
				<?php if ( is_user_logged_in() ) { echo "<a href='".get_permalink_by_postname('enviar-mercado')."' class='button color_blue'>Crear Mercado</a>";} ?>
			<h2>Último en Mercado</h2>
			<?php listar_mercado ();?>
		</aside><!-- archive-list -->

		<?php comments_template(); ?>

	</div> <!-- pagewrap -->
</content>

<?php get_footer(); ?>