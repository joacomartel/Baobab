	<!DOCTYPE HTML>

<html <?php language_attributes(); ?>>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"> <!-- responsive -->
	<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->
	<title><?php bloginfo('name'); ?> | <?php is_home() ? bloginfo('description') : is_author() ? bloginfo('description') : wp_title(''); ?></title>
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,700,700italic,600italic,600' rel='stylesheet' type='text/css'>
	<!-- Cargar less -->
	<link rel="stylesheet/less" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/less/baobab.less">
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/less-1.3.0.min.js"></script>
	
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/script.js"></script>
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-touch-icon.png" >	
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>

	<?php wp_head(); ?>
	
</head>

<body <?php body_class('custom-background'); ?>>

<header>
	<div class="pagewrap full">
		<a href="<?php echo site_url(); ?>"><img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" /></a>
		<h1><a href="<?php echo site_url(); ?>"><?php bloginfo('title');?></a></h1>
		
		<script>
			$(function() {
				$('.menu a').each(function() {
					if ( $(this).parent('li').children('ul').size() > 0 ) {
						$(this).append('<span class="dwn">▼</span>');
					}
				});
			});
		</script>
		<div class="max-right">
			<div class="fix-right">
				<form><?php get_search_form(); ?></form>
				<nav id="login">
					<!-- Si el Usuario ESTÁ logueado, sale su Nombre, sus Publicaciones, la opción de Editar y la de Salir -->
					<ul class="menu">
						<li class="dropdown">
						<?php if (is_user_logged_in () ) global $current_user; get_currentuserinfo(); if (is_user_logged_in () ) echo get_avatar( $current_user->ID, 28); ?>
						<?php if (is_user_logged_in () ) {
							echo '<a href="#">'.$current_user->first_name .'';
							echo ' '.$current_user->last_name .'&nbsp;</a>' . "\n";
							echo '<ul class="sub-menu">';
							echo '<li>';
							echo '<a href="'. get_author_posts_url($current_user->ID) .'">';
							echo _e("Publicaciones</a>", "Baobab");
							echo '</li>';
							echo'<li><a href="'.esc_url( get_permalink( get_page_by_title( __("Editar Perfil", "Baobab")))).'">';
							echo _e("Editar</a></li>", "Baobab");
							echo'<li class="divider">';
							echo '<a href="'.wp_logout_url( home_url() ).'">';
							echo _e("Salir</a>", "Baobab");
							echo'</li>';
							echo'</ul>';
							echo'</li>';
							}
						?>
					</ul>
				<!-- Si el Usuario NO ESTÁ logueado, debe Iniciar Sesión o Registrarse -->
					<?php if ( is_user_logged_in()) { echo ''; } else { 
						echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Inicia Sesión", "Baobab"))))."'>";
						echo _e("Inicia Sesión</a>","Baobab"); 
						echo _e(" o ", "Baobab");
						echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Registro", "Baobab"))))."'>";
						echo _e("Regístrate</a>", "Baobab"); 
						}?>
						
				</nav> <!-- login -->
			</div><!-- fix-right -->
		</div><!-- max-right -->
		
		<nav id="menu"><?php wp_nav_menu(array('theme_location'=>'primary'));?> </nav>

		<!-- movil -->
		<script type="text/javascript">
			$(function() {
				$(".btleft").click(function() {
					if ($(".btleft").hasClass("bt")) {
						$(".btleft").removeClass("bt");
						$(".btleft").addClass("clicked");
						$("#menu2").show();
					} else {
						$(".btleft").removeClass("clicked");
						$(".btleft").addClass("bt");
						$("#menu2").hide();
					}
				});
			});
		</script>
		<script type="text/javascript">
			$(function() {
				$(".btright").click(function() {
					if ($(".btright").hasClass("bt")) {
						$(".btright").removeClass("bt");
						$(".btright").addClass("clicked");
						$("#menu3").show();
					} else {
						$(".btright").removeClass("clicked");
						$(".btright").addClass("bt");
						$("#menu3").hide();
					}
				});
			});
		</script>
		<div id="box">
			<a href="#" class="bt btleft"><span></span><span></span><span></span></a>
			<a href="<?php echo site_url(); ?>" class="bt btmiddle"><h1><?php bloginfo('title');?></h1></a>

				<?php if ( is_user_logged_in()) { 
					echo '<a href="#" class="bt btright fixedR">';
					echo get_avatar( $current_user->ID, 28);
					echo '<span>&#9660;</span>';
					echo '</a>';
					}
					
					else { 
					echo "<a class='bt btright' href='".site_url()."/wp-login.php'>";
					echo _e("Inicia Sesión</a>","Baobab"); 
				}?>
			
			</a>
		</div>
		<div id="menu2">
			<div class="triangle"></div>
			<div class="tooltip_menu">
				<?php wp_nav_menu(array('theme_location'=>'tertiary'));?>
			</div>
		</div>
		<?php if (is_user_logged_in () ) {
			echo '<div id="menu3">';
			echo '<div class="triangle"></div>';
			echo '<div class="tooltip_menu">';
			echo '<a href="'. get_author_posts_url($current_user->ID) .'">';
			echo _e("Publicaciones</a>", "Baobab");
			echo'<a href="'.esc_url( get_permalink( get_page_by_title( __("Editar Perfil", "Baobab")))).'">';
			echo _e("Editar</a>", "Baobab");
			echo '<a href="'.wp_logout_url( home_url() ).'">';
			echo _e("Salir</a>", "Baobab");
			echo '</div>';
			}
			else{
			echo '<div class="tooltip_menu">';
			echo'</div>';
			echo'</div>';
			}
		?>

	</div> <!-- pagewrap -->
</header>