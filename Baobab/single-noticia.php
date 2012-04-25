<?php get_header(); ?>

<content>
	<div id="pagewrap">

		<article id="publicacion">
			<div class="wrap">
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div id="avatar"><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php echo get_avatar( $post->post_author, 50 );?></a></div>
			<div class="title">
				<p>Publicado por <?php the_author_posts_link(); ?>, el <?php the_time ('j \d\e F Y')?></p>
				<h4><?php the_title(); ?></h4>
				<p><?php the_category(', ') ?></p>
			</div>
			<?php the_post_thumbnail('noticia-thumbnail'); ?>
			<p><?php the_content(); ?></p>
			
			<a class="share-tw" title="Comparte en Twitter" target="_blank" href="http://twitter.com/intent/tweet?text=<?php the_title(); ?> <?php the_permalink();?>&t=<?php the_title(); ?>"</a> 
			<a class="share-fb" title="Comparte en Facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>"></a>
			<p class="edit">
			<?php if ($post->post_author == $current_user->ID){ ?><a href="<?php echo get_permalink_by_postname('enviar-noticia'); ?>?id=<?php the_ID(); ?>">editar</a><?php } ?>
			</p>
			<?php endwhile; endif; ?>

			</div> <!-- wrap -->
		</article> <!-- publicacion -->

		<aside id="archive-list">
			<?php if ( is_user_logged_in() ) { echo '<a href="/enviar-noticia/" class="button color_blue">Crear Noticia</a>'; } ?>
			<h2>Últimos noticias</h2>
			<?php listar_noticias ();?>
		</aside><!-- archive-list -->

		<?php comments_template(); ?>

	</div> <!-- pagewrap -->
</content>

<?php get_footer(); ?>