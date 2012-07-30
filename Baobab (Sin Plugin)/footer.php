<footer>
	<div id="pagewrap">
		<h1><a href="<?php echo site_url(); ?>"><?php bloginfo('title');?></a></h1>
		<p><?php bloginfo('description');?></p>
		<?php wp_nav_menu(array('theme_location'=>'secondary')); ?>
	</div><!-- pagewrap -->
</footer>
</body>
</html>