<?php get_header(); ?>

<content>
	<div class="pagewrap">

		<article id="publicacion">
			<div class="wrap">
			
			 <!-- No borrar el "<div id="post-..." -->	
			 <!-- <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>-->

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div id="avatar"><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php echo get_avatar( $post->post_author, 50 );?></a></div>
			<div class="title">
				<p><?php _e("Publicado por ", "Baobab"); ?><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?></a> ~ <?php the_time ('j F, Y')?></p>
				<h3><?php the_title(); ?></h3>
				<p><?php the_category(', ') ?></p>
				<p><?php the_tags(', '); ?></p>
			</div>
			<div class="column2">
				<?php the_post_thumbnail('noticia-thumbnail'); ?>
				<?php the_content(); ?>
			</div>
			<a class="share-tw" title="<?php _e("Comparte en Twitter", "Baobab"); ?>" target="_blank" href="http://twitter.com/intent/tweet?text=<?php the_title(); ?> <?php the_permalink();?>&t=<?php the_title(); ?>"</a> 
			<a class="share-fb" title="<?php _e("Comparte en Facebook", "Baobab"); ?>" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>"></a>
			<p class="edit">
			<?php if ($post->post_author == $current_user->ID){ ?> <a href="<?php echo (''.site_url().'/wp-admin/post.php?post='); ?><?php the_ID(); ?>&action=edit"><?php _e("Editar Publicación", "Baobab"); ?></a><?php } ?>
			</p>
			<?php endwhile; endif; ?>
			</div> <!-- wrap -->
		</article> <!-- publicacion -->
		<aside id="archive-list">
			<div class="wrap">
				<?php global $current_user; get_currentuserinfo(); if ($current_user->user_level == 10 ) { ?>
	  			<?php echo "<a href='".site_url()."/wp-admin/post-new.php' class='btn blue'>"; echo _e("Crear Noticia</a>", "Baobab"); ?>
				<?php } ?>
				<h2><?php _e("Noticias Recientes", "Baobab"); ?></h2>
				<?php listar_noticias ();?>
				<?php dynamic_sidebar(); ?>
			</div><!-- wrap -->
		</aside><!-- archive-list -->
		<!-- <?php wp_link_pages(); ?> No borrar...-->
		<?php comments_template(); ?>

	</div> <!-- pagewrap -->
</content>
<?php get_footer();?>

<!-- No borrar wp_footer(); -->	
<!--  <?php wp_footer();?>
<!-- No borrar comment_form(); -->	
<!-- <?php comment_form(); ?>
