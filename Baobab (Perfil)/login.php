<?php
/**
 * Template Name: Login
 *
 */

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'log-in' ) :

	global $error;
	$login = wp_login( $_POST['user-name'], $_POST['password'] );
	$login = wp_signon( array( 'user_login' => $_POST['user-name'], 'user_password' => $_POST['password'], 'remember' => $_POST['remember-me'] ), false );

endif;
 
    get_header(); ?>

<div id="pagewrap">
	<article id="publicacion" class="wrap">

		
<!-- Formulario de Logueo -->

	<?php if ( is_user_logged_in() ) : ?>

		<?php global $user_ID; $login = get_userdata( $user_ID ); ?><META HTTP-EQUIV="REFRESH" CONTENT="0;URL=<?php echo site_url(); ?>">
		
		<?php elseif ( $login->ID ) : ?><?php $login = get_userdata( $login->ID ); ?><META HTTP-EQUIV="REFRESH" CONTENT="0;URL=<?php echo site_url(); ?>">
			

	<?php else : // Not logged in ?>

		<?php if ( $error ) : ?>
			<?php echo $error; ?>
		<?php endif; ?>

		<form action="<?php the_permalink(); ?>" method="post" class="sign-in">
				<h4><?php _e("Usuario", "Baobab"); ?></h4>
				<input type="text" name="user-name" id="user-name" class="datos" value="<?php echo wp_specialchars( $_POST['user-name'], 1 ); ?>" />

				<h4><?php _e("Contraseña", "Baobab"); ?></h4>
				<input type="password" name="password" id="password" class="datos" />

				<input type="submit" name="submit" class="button color_la" value="<?php _e("Inicia Sesión","Baobab"); ?>" />
				<input class="remember-me checkbox" name="remember-me" id="remember-me" type="checkbox" checked="checked" value="forever" />
				<label for="remember-me"><?php _e("Recordar mis datos","Baobab"); ?></label>
				
				<br></br>
				<input type="hidden" name="action" value="log-in" />
			
			<a href="<?php echo get_option('siteurl');?>/wp-login.php?action=lostpassword"><?php _e("¿Olvidaste tu contraseña?","Baobab"); ?></a>
		</form><!-- .sign-in -->

	<?php endif; ?>

<!-- Formulario de Logueo -->

	</article> <!-- publicacion -->
</div> <!-- pagewrap -->

<?php get_footer(); ?>