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
				<th class="w50"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/single_fecha.png"/><?php _e("Cierre del Debate", "Baobab");?></th>
				<th class="w50"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/single_chart.png"/><?php _e("Opciones", "Baobab");?></th>
			</tr>
			<tr>
				<td><?php the_modified_date('j F Y') ?></td>
				<td>
					<ul class="info">
						<li>
							<?php 
								global $current_user; get_currentuserinfo();
								if(!check_voto($current_user->ID, $post->ID) && is_user_logged_in()){ 
							?>
							<!-- INTERFAZ USUARIO NO HA VOTADO -->
							<form id="formulario-debate-realizar-voto" method="post" action="<?php echo home_url(); ?>/index.php">
							<?php
                        		$opciones = get_votes_from_post_id( $post->ID );
								if ( $opciones ) {
									echo '<ol>';
									foreach ( $opciones as $opcion ) {
									echo '<li style="background: none;"><input type="radio" name="vote_id" value="'.$opcion->id.'" onclick="$(\'#submit_vote\').removeAttr(\'disabled\');"> '. $opcion->vote_text .'</input></li>';
								}
								echo '</ol>';
							}
							?>
							<input type="hidden" value="<?php echo $post->ID; ?>" name="post_id" />
							<input id="submit_vote" type="submit" value="<?php _e("Votar", "Baobab");?>" class="btn green" disabled="disabled" />
							<?php wp_nonce_field('realizar_voto', '_debate_realizar_voto'); ?>
						</li>
					</ul>
							</form>
				</td>
			</tr>
			
			</table>
			<?php } else { ?>
                    
                    <!-- INTERFAZ USUARIO QUE YA VOTO -->             
					<?php
                        $opciones = get_votes_from_post_id( $post->ID );
						if ( $opciones ) {
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
			</td>
			</tr>
			</table>


     <div id="chart_div" style="width: auto; height: auto;"></div>
     	<?php } ?>
			
			<div class="column2">
				<?php the_post_thumbnail('debate-thumbnail'); ?>
				<?php the_content(); ?>
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
			<div class="wrap">
				<?php if ( is_user_logged_in() ) { echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Enviar Debate", "Baobab"))))."' class='btn blue'>"; echo _e("Crear Debate</a>", "Baobab"); } ?>
				<h2><?php _e("Debates Recientes", "Baobab"); ?></h2>
				<?php listar_debates ();?>
				<?php dynamic_sidebar(); ?>
			</div><!-- wrap -->
		</aside><!-- archive-list -->

		<?php comments_template(); ?>		
	</div> <!-- pagewrap -->
</content>

<?php get_footer(); ?>