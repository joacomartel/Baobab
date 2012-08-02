<?php
/**
 * Template Name: Registro
 *
 */

/* Load registration file. */
require_once( ABSPATH . WPINC . '/registration.php' );

/* Check if users can register. */
$registration = get_option( 'users_can_register' );

/* If user registered, input info. */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'adduser' ) {
	$user_pass = wp_generate_password();
	$userdata = array(
		'user_pass' => $user_pass,
		'user_login' => esc_attr( $_POST['user_name'] ),
		'first_name' => esc_attr( $_POST['first_name'] ),
		'last_name' => esc_attr( $_POST['last_name'] ),
		'nickname' => esc_attr( $_POST['nickname'] ),
		'user_email' => esc_attr( $_POST['email'] ),
		'user_url' => esc_attr( $_POST['website'] ),
		'aim' => esc_attr( $_POST['aim'] ),
		'yim' => esc_attr( $_POST['yim'] ),
		'jabber' => esc_attr( $_POST['jabber'] ),
		'description' => esc_attr( $_POST['description'] ),
		'role' => get_option( 'default_role' ),
	);
	
	if ( !$userdata['user_login'] )
		$error = __("Es necesario un nombre de usuario", "Baobab");
	elseif ( username_exists($userdata['user_login']) )
		$error = __("Lo sentimos, ese nombre de usuario ya existe", "Baobab");
	elseif ( !is_email($userdata['user_email'], true) )
		$error = __("Debes introducir un correo electrónico válido", "Baobab");
	elseif ( email_exists($userdata['user_email']) )
		$error = __("Lo sentimos, ese correo electrónico ya está siendo utilizado", "Baobab");
	
	else{
		$new_user = wp_insert_user( $userdata );
		wp_new_user_notification($new_user, $user_pass);
		
		update_usermeta( $new_user, 'twitter', esc_attr( $_POST['twitter']  ) );
		update_usermeta( $new_user, 'facebook', esc_attr( $_POST['facebook']  ) );
		update_usermeta( $new_user, 'agree',   esc_attr( $_POST['agree']    ) );
	}
}
 
     get_header(); ?>

<div id="pagewrap">
	<article id="publicacion" class="wrap">
 

<!-- Formulario de Registro -->
			
		<?php if ( is_user_logged_in() && !current_user_can( 'create_users' ) ) : ?>

			<?php _e("¿No eres ", "Baobab"); echo'<a href="'.get_author_posts_url($current_user->id).'">'.$current_user->display_name.'</a>'; ?><?php _e("? Por favor ", "Baobab"); ?><a href="<?php echo wp_logout_url( get_permalink() ); ?>"><?php _e("Cierra Sesión","Baobab"); ?></a>						
		
		<?php elseif ( $new_user ) : ?>

			<?php
				if ( current_user_can( 'create_users' ) )
					printf( __("Tu cuenta ha sido creada correctamente", "Baobab"), $_POST['user-name'] );
				else 
					printf( __("Gracias por registrarte", "Baobab"), $_POST['user-name'] );
					printf( __("<br/>Por favor, revisa tu correo electrónico, ahí es donde recibirás tu contraseña.<br/> (Si no encuentras el correo, revisa en tu carpeta de Spam)", "Baobab") );
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
			
			
				<h2><?php _e("Datos del Usuario", "Baobab"); ?></h2>
				
					<h4><?php _e("Usuario (obligatorio)", "Baobab"); ?></h4>
					<input class="datos" name="user_name" type="text" id="user_name" value="<?php if ( $error ) echo wp_specialchars( $_POST['user_name'], 1 ); ?>" />
				
					<h4><?php _e("Nombre", "Baobab");?></h4>
					<input class="datos" name="first_name" type="text" id="first_name" value="<?php if ( $error ) echo wp_specialchars( $_POST['first_name'], 1 ); ?>" />
				
					<h4><?php _e("Apellidos", "Baobab");?></h4>
					<input class="datos" name="last_name" type="text" id="last_name" value="<?php if ( $error ) echo wp_specialchars( $_POST['last_name'], 1 ); ?>" />
				
				<br></br>
				<h2><?php _e("Información de Contacto", "Baobab"); ?></h2>
				
					<h4><?php _e("Correo Electrónico (obligatorio)", "Baobab");?></h4>
					<input class="datos" name="email" type="text" id="email" value="<?php if ( $error ) echo wp_specialchars( $_POST['email'], 1 ); ?>" />
				
					<h4><?php _e("Sitio web", "Baobab");?></h4>
					<input class="datos" name="website" type="text" id="website" value="<?php if ( $error ) echo wp_specialchars( $_POST['website'], 1 ); ?>" />
				
				<br></br>
				<h2><?php _e("Sobre ti", "Baobab"); ?></h2>
				
					<h4><?php _e("Biografía", "Baobab");?></h4>
					<textarea class="datos" name="description" id="description" rows="5" cols="30"><?php if ( $error ) echo wp_specialchars( $_POST['description'], 1 ); ?></textarea>
				
				<!-- PRUEBA -->
			
		<!-- Acá tiene que ir el avatar -->
		
				<!-- PRUEBA -->
				
				<h2><?php _e("Redes Sociales", "Baobab"); ?></h2>
				
					<h4><?php _e("Twitter", "Baobab");?></h4>
					<input class="datos" name="twitter" type="text" id="twitter" placeholder="<?php _e("@usuario","Baobab");?>" value="<?php if ( $error ) echo wp_specialchars( $_POST['twitter'], 1 ); ?>" />
					
					<h4><?php _e("Facebook", "Baobab");?></h4>
					<input class="datos" name="facebook" type="text" id="facebook" placeholder="<?php _e("www.facebook.com/tu-usuario","Baobab");?>" value="<?php if ( $error ) echo wp_specialchars( $_POST['facebook'], 1 ); ?>" />
				
				<p class="form-submit">
					<?php echo $referer; ?>
					<input name="adduser" type="submit" id="addusersub" class="button color_la" value="<?php if ( current_user_can( 'create_users' ) ) _e("Añadir Usuario", "Baobab"); else _e("Regístrate", "Baobab"); ?>" />
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