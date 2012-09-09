<?php
	/* Template Name: Archivo Debates */
	get_header();
?>
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.masonry.min.js"></script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.gpCarousel.js"></script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/prueba.js"></script>



		<?php $debates = new WP_Query(array('post_type' => 'debate')); if ( $debates->have_posts() ) : $i = 0	; while ( $debates->have_posts() && $i < 1 ) : $debates->the_post(); ?>
			<style type="text/css">
			.top-news {
				background:transparent url('<?php if (has_post_thumbnail()) {
			    $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail_name');
			    echo $thumb[0]; // thumbnail url
			    } ?>');
			    background-position: center center;
			    background-size: cover;
			}
			</style>
		<?php $i++; endwhile; endif; ?>

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
		          ['<?php echo $opcion->vote_text; ?>', <?php echo get_votes($opcion->id); ?>],
	   <?php } } ?>
        ]);
            
        var options = {
          title: ''
        };
        
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
		chart.draw(data, {backgroundColor: 'transparent' });}
    </script>
    
<content>
	<div class="pagewrap">
		<div class="portada">
			<div class="about">
				<?php if ( is_user_logged_in() ) { echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Enviar Debate", "Baobab"))))."' class='btn blue'>"; echo _e("Crear Debate</a>", "Baobab");}
				else {echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Inicia Sesión", "Baobab"))))."' class='btn blue'>"; echo _e("Inicia Sesión</a>", "Baobab");}
				?>
			</div><!-- about -->
			
			<div class="top-news">
			<a href="<?php the_permalink(); ?>">
				<div class="top-filter">
						<?php $debates = new WP_Query(array('post_type' => 'debate')); if ( $debates->have_posts() ) : $i = 0	; while ( $debates->have_posts() && $i < 1 ) : $debates->the_post(); ?>
						
						<?php if ( has_post_thumbnail() ) {// check if the post has a Post Thumbnail assigned to it.
							}else{
								echo'<script>
								$("div").addClass(function(index, currentClass) {
								var addedClass;
							
								if ( currentClass === "top-news" ) {
								addedClass = "noImage";
								
								}
								
								return addedClass;
								});
							</script>';
							} 
						?>

						<h3><?php echo titulo_corto ('...', 60);?></h3>
						<p><?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,25);?>...</p>
						<p class="top-dato">
						<?php the_title();?><?php _e(" concluye el ", "Baobab");?><span><?php the_modified_date('j F, Y') ?></span>
						</p>
						
						<p class="movil-dato">
							<?php $excerpt = get_the_excerpt(); echo string_limit_words($excerpt,25);?>...</br></br>
							<span><?php _e(" concluye el ", "Baobab");?><?php the_modified_date('j F, Y');?></span>
							<?php the_time ('j F, Y')?> ~ <?php the_author_meta('first_name'); ?>
						</p>
						
						<!-- <div id="chart_div" style="width: auto; height: auto; margin-top:-40px"></div> -->
					<?php $i++; endwhile; endif; ?>
				</div><!-- top-filter -->
				</a>
			</div><!-- top-news -->
		</div><!-- portada -->

		<div class="container" id="container">
		<?php $debates = new WP_Query('post_type=debate&offset=-1&posts_per_page=100');if ( $debates->have_posts() ) : while ( $debates->have_posts() ) : $debates->the_post(); ?>			
				<figure class="item block col6">
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('debate-thumbnail'); ?>
					<div class="sub-block">
						<h3><!--<?php echo titulo_corto ('...', 60);?>--><?php echo the_title();?></h3>
					</a>
					
						<span>
							<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'debate')
							echo ''._e(" concluye el ", "Baobab");?>
							<?php $post_type = get_post_type( $post->ID ); if ($post_type == 'debate')
							echo''.the_modified_date('j F, Y');?>
						</span>
						<p><?php the_time ('j F, Y')?> ~ <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('first_name'); ?></a></p>
					</div><!-- sub-block -->

				</figure> <!-- item block -->

			<?php $i++; endwhile; endif; ?>
		</div><!-- container -->
	</div> <!-- pagewrap -->
</content>
<?php get_footer() ?>