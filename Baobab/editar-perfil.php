<?php

global $user_ID, $user_identity, $user_level;
if ($user_ID) {
	if($_POST) 
	{

		$message = "Your profile updated successfully.";
		$first = $wpdb->escape($_POST['first_name']);
		$last = $wpdb->escape($_POST['last_name']);
		$email = $wpdb->escape($_POST['email']);
		$user_url = $wpdb->escape($_POST['website']);
		$description = $wpdb->escape($_POST['desc']);
		$password = $wpdb->escape(isset($_POST['pwd']));
		$confirm_password = $wpdb->escape(isset($_POST['confirm']));

		update_user_meta( $user_ID, 'first_name', $first );
		update_user_meta( $user_ID, 'last_name', $last );
		update_user_meta( $user_ID, 'description', $description );
		wp_update_user( array ('ID' => $user_ID, 'user_url' => $user_url) );
		
		// Extra Profile Information
		update_user_meta( $current_user->ID, 'twitter', esc_attr( $_POST['twitter'] ) );	
		update_user_meta( $current_user->ID, 'facebook', esc_attr( $_POST['facebook'] ) );	
//		update_user_meta( $current_user->ID, 'agree', esc_attr( $_POST['agree'] ) );		
		
		if(isset($email)) {
			if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email)){ 
				wp_update_user( array ('ID' => $user_ID, 'user_email' => $email) ) ;
			}
			else { $message = "<div id='error'>Please enter a valid email id.</div>"; }
		}
		/* Update user password. */
		if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
			if ( $_POST['pass1'] == $_POST['pass2'] )
				wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
			else
				$error = __('The passwords you entered do not match.  Your password was not updated.', 'frontendprofile');
		}
		
	}
}

/*

 Template Name: Editar Perfil
 
*/

if ($user_ID) {
	$user_info = get_userdata($user_ID);
	
	get_header(); ?>

<div class="pagewrap">
	<div class="profile-edit w60">
	
	<h2><?php _e("Editar Perfil", "Baobab");?></h2>
	
			<form action="" method="post">
				<input type="text" name="first_name" placeholder="<?php _e("Nombre", "Baobab");?>" value="<?php echo $user_info->first_name; ?>"/></h2>
				<input type="text" name="last_name" placeholder="<?php _e("Apellidos", "Baobab");?>" value="<?php echo $user_info->last_name; ?>"/> <br />
				<input type="text" name="email" placeholder="<?php _e("Correo Electrónico", "Baobab");?>" value="<?php echo $user_info->user_email; ?>"/><br />
				<textarea name="desc" placeholder="<?php _e("Biografía", "Baobab");?>" rows="5"><?php echo $user_info->description; ?></textarea> <br />
				<span>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/link2.png"></img>
					<input type="text" name="website" placeholder="<?php _e("Sitio web", "Baobab");?>" value="<?php echo $user_info->user_url; ?>"/>
				</span>
				<span>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/twitter2.png"></img>
					<input  name="twitter" type="text" id="twitter" placeholder="<?php _e("@usuario","Baobab");?>" value="<?php the_author_meta( 'twitter', $current_user->ID ); ?>"/>
				</span>
				<span>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/fb2.png"></img>
					<input name="facebook" type="text" id="facebook" placeholder="<?php _e("www.facebook.com/tu-usuario","Baobab");?>" value="<?php the_author_meta( 'facebook', $current_user->ID ); ?>"/>
				</span>
				
				

				<h3><?php _e("Contraseña","Baobab");?></h3>
				<p><?php _e("Si quieres cambiar tu contraseña, escribe en los siguientes campos. De lo contrario, déjalo en blanco","Baobab");?></p>
					<input name="pass1" type="password" id="pass1" placeholder="<?php _e("Nueva Contraseña","Baobab");?>"/>
					<input name="pass2" type="password" id="pass2" placeholder="<?php _e("Repetir Contraseña","Baobab");?>"/>
				<br/><br />
				<input type="submit" name="submit" class="btn blue" value="<?php _e("Actualizar Perfil","Baobab"); ?>" id="submit" class="button color_la"/>
			</form>

	</div><!-- profile-info -->
</div><!-- pagewrap -->


	<?php get_footer();
	}
else { 

	$redirect_to = home_url('url')."/login";
	wp_safe_redirect($redirect_to);
	exit;	
}
?>
