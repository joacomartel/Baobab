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
			<div class="column2">
				<?php the_post_thumbnail('idea-thumbnail'); ?>
				<?php the_content(); ?>
			</div>
			<a class="share-tw" title="<?php _e("Comparte en Twitter", "Baobab"); ?>" target="_blank" href="http://twitter.com/intent/tweet?text=<?php the_title(); ?> <?php the_permalink();?>&t=<?php the_title(); ?>"</a> 
			<a class="share-fb" title="<?php _e("Comparte en Facebook", "Baobab"); ?>" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>"></a>
			
			<p class="edit">
			<?php if ($post->post_author == $current_user->ID)
			{ ?><a href="<?php echo esc_url( get_permalink( get_page_by_title( __("Enviar Idea", "Baobab")))); ?>?&id=<?php the_ID(); ?>"><?php _e("Editar Publicación", "Baobab"); ?></a><?php } ?>
			</p>
			
			<?php endwhile; endif; ?>

			</div> <!-- wrap -->
		</article> <!-- publicacion -->

		<aside id="archive-list">
			<div class="wrap">
				<?php if ( is_user_logged_in() ) { echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Enviar Idea", "Baobab"))))."' class='btn blue'>"; echo _e("Crear Idea</a>", "Baobab");} ?>
				<h2><?php _e("Ideas Recientes", "Baobab"); ?></h2>
				<?php listar_ideas ();?>
				<?php dynamic_sidebar(); ?>
			</div><!-- wrap -->
		</aside><!-- archive-list -->

		<?php comments_template(); ?>

	</div> <!-- pagewrap -->
</content>

<?php get_footer(); ?>