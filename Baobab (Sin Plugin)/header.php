	<!DOCTYPE HTML>

<html lang="es-ES">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"> <!-- responsive -->
	<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->
	<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/yui.css" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/script.js"></script>
	<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.ico">
	<link rel="apple-touch-icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/apple-touch-icon.png" >
	
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>
	<?php wp_head(); ?>

	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-27363795-1']);
		_gaq.push(['_trackPageview']);
		(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
</head>

<body <?php body_class('custom-background'); ?>>

<header>
	<div id="pagewrap">
		<a href="<?php echo site_url(); ?>"><img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" /></a>
		<h1><a href="<?php echo site_url(); ?>"><?php bloginfo('title');?></a></h1>
		<div class="group-header">
			<nav id="login">
			<!-- Si el Usuario ESTÁ logueado, sale su Nombre -->
				<menu>
					<?php if (is_user_logged_in () ) global $current_user; get_currentuserinfo(); if (is_user_logged_in () ) echo get_avatar( $current_user->id, 28); ?>
					<?php if (is_user_logged_in () ) {
						echo'<li class="caret">';
						echo '<a href="#">'. $current_user->display_name .'&nbsp;</a>' . "\n";
						echo'<ul class="sub-menu">';
						echo '<a href="'. get_author_posts_url($current_user->id) .'">';
						echo _e("Publicaciones</a>", "Baobab");
						echo'<li><a href="'.site_url().'/wp-admin/profile.php">';
						echo _e("Editar</a></li>", "Baobab");
						echo'<li class="divider">';
						echo '<a href="'.wp_logout_url( home_url() ).'">';
						echo _e("Salir</a>", "Baobab");
						echo'</li>';
						echo'</ul>';
						echo'</li>';
						}
					?>
			<!-- Y está la opción de Editar -->
				</menu>
			<!-- Si el Usuario está NO ESTÁ logueado, debe Ingresar -->
				<?php if ( is_user_logged_in()) { echo ''; } else { 
					echo "<a href='".site_url()."/wp-login.php'>";
					echo _e("Inicia Sesión</a>","Baobab"); 
					echo _e(" o ", "Baobab");
					echo "<a href='".site_url()."/wp-register.php'>";
					echo _e("Regístrate</a>", "Baobab"); 
					}?>
					
			</nav> <!-- login -->
				<nav id="buscador"><?php get_search_form(); ?></nav>
		</div><!-- group-header -->
			<menu class="menu-general"> <?php wp_nav_menu(array('theme_location'=>'primary'));?>  </menu>
			<menu class="menu-movil"> <?php wp_nav_menu(array('theme_location'=>'tertiary'));?>  </menu>
		
		<!-- ALALALALALA 
		<?php _e("La página que buscas no existe", "Baobab"); ?>
		<?php the_content(__("Leer más...", "Baobab")); ?>
		<?php _e("Prueba", "Baobab"); ?>
		-->


	</div> <!-- pagewrap -->
</header>