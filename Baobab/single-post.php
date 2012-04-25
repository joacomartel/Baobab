<?php get_header(); ?>
	
	
	<aside id="lista-archivos">
		<h1>Ultimos Debates</h2>
		<?php listar_debates ();?>

		<?php listar_eventos ();?>

		<?php listar_proyectos ();?>

		<?php listar_notas ();?>
	</aside><!-- lista-archivos -->
	
	
	<article id="publicacion">
	
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="titulo"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></div>
		<div class="autor">Publicado por <?php the_author_posts_link()?> el <?php the_time ('j \d\e F Y')?></div>
		<div class="categorias"><?php the_category('') ?></div>
		<br><?php the_content(); ?></br>
		<?php endwhile; endif; ?>

	</article> <!-- publicacion -->

	
	
	<div id="contenedor-comentario">
		<?php comments_template( 's', true ); ?>
	</div>
	
<?php get_footer(); ?>