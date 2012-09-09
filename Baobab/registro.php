<?php
/**
 * Template Name: Registro
 *
 */

/* Load registration file. */
require_once( ABSPATH . WPINC . '/user.php' );

/* Check if users can register. */
$registration = get_option( 'users_can_register' );

/* If user registered, input info. */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'adduser' ) {
	$userdata = array(
		'user_pass' =>  $pwd1 = $wpdb->escape(trim($_POST['pwd1'])),
		'user_login' => esc_attr( $_POST['email'] ),
		'first_name' => esc_attr( $_POST['first_name'] ),
		'last_name' => esc_attr( $_POST['last_name'] ),
		'user_email' => esc_attr( $_POST['email'] ),
		'role' => get_option( 'default_role' ),
	);
	
	if ( !$userdata['user_login'] )
		$error = __("Es necesario un correo electrónico para tu registro", "Baobab");
	elseif ( username_exists($userdata['user_login']) )
		$error = __("Lo sentimos, ese correo electrónico ya está siendo utilizado", "Baobab"); //$error = __("Lo sentimos, ese nombre de usuario ya existe", "Baobab");
	elseif ( !$userdata['user_email'] ) //	elseif ( !is_email($userdata['user_email'], true) )
		$error = __("Debes introducir un correo electrónico válido", "Baobab");
	elseif ( email_exists($userdata['user_email']) )
		$error = __("Lo sentimos, ese correo electrónico ya está siendo utilizado", "Baobab");
	elseif ( !$userdata['first_name'] )
		$error = __("Debes introducir tu Nombre", "Baobab");
	elseif ( !$userdata['last_name'] )
		$error = __("Debes introducir tus Apellidos", "Baobab");
		
		
elseif ( !$userdata['user_pass'] )
$error = __("Debes introducir un password", "Baobab");


	else{
		$new_user = wp_insert_user( $userdata );
//		wp_new_user_notification($new_user, $user_pass);
//		update_user_meta( $new_user, 'agree',   esc_attr( $_POST['agree']    ) );
	}
}
 
     get_header(); ?>

<div class="pagewrap">
	<article id="publicacion" class="wrap">
 

<!-- Formulario de Registro -->
			
		<?php if ( is_user_logged_in() && !current_user_can( 'create_users' ) ) : ?>

			<?php _e("¿No eres ", "Baobab"); echo'<a href="'.get_author_posts_url($current_user->ID).'">'.$current_user->display_name.'</a>'; ?><?php _e("? Por favor ", "Baobab"); ?><a href="<?php echo wp_logout_url( get_permalink() ); ?>"><?php _e("Cierra Sesión","Baobab"); ?></a>						
		
		<?php elseif (isset($new_user)):?>

			<?php
				if ( current_user_can( 'create_users' ) )		 
					printf( __("Tu cuenta ha sido creada correctamente", "Baobab"), isset($_POST['user-name']));
				else 
					printf( __("Gracias por registrarte", "Baobab"), isset($_POST['user-name']) );
					printf( __("<br/>Desde ahora, puedes acceder al sitio con tu correo electrónico y la contraseña que has escogido", "Baobab") );
			?>

		<?php else : ?>

			<?php if ( $error ) : ?>
				<p class="error">
					<?php echo $error; ?>
				</p><!-- .error -->
			<?php endif; ?>

			<?php if ( current_user_can( 'create_users' ) && $registration ) : ?>
			<em><?php _e("Los usuarios pueden registrarse o puedes crearlos manualmente aquí", "Baobab"); ?></em>

			<?php elseif ( current_user_can( 'create_users' ) ) : ?>
			<em><?php _e("Los usuarios NO pueden registrarse, pero puedes tú sí crearlos desde aquí", "Baobab"); ?></em>
			
			<?php endif; ?>
			<?php if ( $registration || current_user_can( 'create_users' ) ) : ?>

			<form method="post" id="adduser" class="user-forms" action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
			
			
	        <h3><?php _e("¿Aún no tienes una cuenta? Regístrate", "Baobab"); ?></h3>				
					
					<h4><?php _e("Nombre", "Baobab");?></h4>
					<input class="datos" name="first_name" type="text" id="first_name" value="<?php if ( $error ) echo esc_html( $_POST['first_name'], 1 ); ?>" />
				
					<h4><?php _e("Apellidos", "Baobab");?></h4>
					<input class="datos" name="last_name" type="text" id="last_name" value="<?php if ( $error ) echo esc_html( $_POST['last_name'], 1 ); ?>" />
				
					<h4><?php _e("Correo Electrónico", "Baobab");?></h4>
					<input class="datos" name="email" type="text" id="email" value="<?php if ( $error ) echo esc_html( $_POST['email'], 1 ); ?>" />
					
			<h4> <?php _e("Contraseña","Baobab");?></h4>
        	<input type="password" value="" name="pwd1" id="pwd1" class="datos"/>

				<p class="form-submit">
					<?php $referer; ?>
					<input name="adduser" type="submit" id="addusersub" class="btn blue" value="<?php if ( current_user_can( 'create_users' ) ) _e("Añadir Usuario", "Baobab"); else _e("Regístrate", "Baobab"); ?>" />
					<?php wp_nonce_field( 'add-user' ) ?>
					<input name="action" type="hidden" id="action" value="adduser" />
				</p><!-- .form-submit -->

			</form><!-- #adduser -->

			<?php endif; ?>
		<?php endif; ?>
			
<!-- Formulario de Registro -->

	</article> <!-- publicacion -->
</div> <!-- pagewrap -->

<?php get_footer(); ?>