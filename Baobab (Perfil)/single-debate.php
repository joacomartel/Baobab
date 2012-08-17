<?php get_header(); ?>
<?php global $wpdb; ?>


<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows([
	   <?php $opciones = get_votes_from_post_id($post->ID);
	          if ( $opciones ) {
			foreach ( $opciones as $opcion ) { ?>
		          [' <?php echo $opcion->vote_text; ?>', <?php echo get_votes($opcion->id); ?>],
	   <?php } } ?>
        ]);


        var options = {
          title: '<?php// the_title(); ?>'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

 <content>
	<div id="pagewrap">

		<article id="publicacion">

			<div class="wrap">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div id="avatar"><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php echo get_avatar( $post->post_author, 50 );?></a></div>
			<div class="title">
				<p><?php _e("Publicado por ", "Baobab"); ?><?php the_author_posts_link(); ?>, <?php the_time ('j F Y')?></p>
				<h3><?php the_title(); ?></h3>
				<p><?php the_category(', ') ?></p>
			</div>

			<ul class="info">
				<li>
					<!--<img src="<?php bloginfo('stylesheet_directory'); ?>/images/single_pregunta.png"/>
					<h4>Pregunta</h4><br>
					<p><?php echo get_post_meta($post->ID, 'Pregunta', true); ?></p>  -->
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/single_fecha.png"/>
					<h4><?php _e("Cierre del Debate", "Baobab");?></h4><br>
					<p><?php the_modified_date('j F Y') ?></p>
				</li>
				<li>
                    <?php
                        global $current_user; get_currentuserinfo();
                        if(!check_voto($current_user->ID, $post->ID) && is_user_logged_in()){
                    ?>
					<!-- INTERFAZ USUARIO NO HA VOTADO -->
                    <form id="formulario-debate-realizar-voto" method="post" action="<?php bloginfo('url'); ?>/index.php">
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/single_chart.png"/>
					<?php
                        $opciones = get_votes_from_post_id( $post->ID );
						if ( $opciones ) {
							echo '<h4>';
							echo _e("Opciones", "Baobab");
							echo '</h4>';
							echo '<ol>';
							foreach ( $opciones as $opcion ) {
								echo '<li style="background: none;"><input type="radio" name="vote_id" value="'.$opcion->id.'" onclick="$(\'#submit_vote\').removeAttr(\'disabled\');"> '. $opcion->vote_text .'</input></li>';
							}
							echo '</ol>';
						}
					?>
					   <!--  <div id="chart_div" style="width: auto; height: auto;"></div> -->
                    <input type="hidden" value="<?php echo $post->ID; ?>" name="post_id" />
                    <input id="submit_vote" type="submit" value="<?php _e("Votar", "Baobab");?>" class="button color_green" disabled="disabled" />
                    <?php wp_nonce_field('realizar_voto', '_debate_realizar_voto'); ?>
              	</li>
			</ul>
                    </form>
                    <?php } else { ?>

                    <!-- INTERFAZ USUARIO QUE YA VOTO -->
					<img src="<?php bloginfo('stylesheet_directory'); ?>/images/single_chart.png"/>
					<?php
                        $opciones = get_votes_from_post_id( $post->ID );
						if ( $opciones ) {
							echo '<h4>Opciones:</h4>';
							echo '<ol>';
							foreach ( $opciones as $opcion ) {
		                        $votos = get_votes( $opcion->id );
								echo '<li style="background: none;"><!--['.$votos.']--> '.$opcion->vote_text .'</li>';
							}
							echo '</ol>';
						}

                    ?>
				</li>
			</ul>
     <div id="chart_div" style="width: auto; height: auto;"></div>
     	<?php } ?>

			<div class="column2">
				<?php the_post_thumbnail('debate-thumbnail'); ?>
				<p><?php the_content(); ?></p>
			</div>
			<a class="share-tw" title="<?php _e("Comparte en Twitter", "Baobab"); ?>" target="_blank" href="http://twitter.com/intent/tweet?text=<?php the_title(); ?> <?php the_permalink();?>&t=<?php the_title(); ?>"</a>
			<a class="share-fb" title="<?php _e("Comparte en Facebook", "Baobab"); ?>" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>"></a>

			<p class="edit">
			<?php if ($post->post_author == $current_user->ID){ ?><a href="<?php echo esc_url( get_permalink( get_page_by_title( __("Enviar Debate", "Baobab")))); ?>?&id=<?php the_ID(); ?>"><?php _e("Editar Publicación", "Baobab"); ?></a><?php } ?>
			</p>

			<?php endwhile; endif; ?>
			</div> <!-- wrap -->
		</article> <!-- publicacion -->

		<aside id="archive-list">
				<?php if ( is_user_logged_in() ) { echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Enviar Debate", "Baobab"))))."' class='button color_blue'>"; echo _e("Crear Debate</a>", "Baobab"); } ?>
			<h2><?php _e("Debates Recientes", "Baobab"); ?></h2>
			<?php listar_debates ();?>
		</aside><!-- archive-list -->

		<?php comments_template(); ?>

	</div> <!-- pagewrap -->
</content>

<?php get_footer(); ?>