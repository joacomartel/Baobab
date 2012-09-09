<?php get_header(); ?>

<content>
	<div class="pagewrap">

		<article id="permanente">
			<div class="wrap">
			<br><br>
				<h1><?php _e("Ups, hicimos algo mal...muy mal.","Baobab") ?></h1>
				<h3><?php _e("Pero podemos mejorar, lo sabemos.","Baobab") ?></h3>
			<br><br>
				<p>
				<?php echo _e("Si quieres ","Baobab"); echo '<a href="'.site_url().'">'.''; echo _e("ve al inicio","Baobab"); echo '</a>';?>				
				<?php _e("ó encuentra lo que buscas acá","Baobab") ?>
				<form class="buscador"><?php get_search_form(); ?></form>
				</p>
			</div> <!-- wrap -->
		</article> <!-- publicacion -->

	</div> <!-- pagewrap -->
</content>

<?php get_footer() ?>