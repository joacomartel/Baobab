<?php
	/* Template Name: Permanente */
	get_header();
?>

<content>
	<div class="pagewrap">

		<article id="permanente">
			<div class="wrap">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<h2><?php the_title(); ?></h2>
				<div class="column2 fix">
					<?php the_content(); ?></br>
					<?php endwhile; endif; ?>
				</div><!-- column2 -->
			</div> <!-- wrap -->
		</article> <!-- publicacion -->

	</div> <!-- pagewrap -->
</content>


<?php get_footer() ?>