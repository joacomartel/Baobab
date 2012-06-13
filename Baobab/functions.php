<?php

/**
 * - Eventos
 * - Proyectos
 * - Debates
 * - Mercado
 * - Ideas
 **/
 

/** Varias líneas iniciales del functions son tomadas del tema Twenty Ten **/

/** Tell WordPress to run baobab_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'baobab_setup' );

if ( ! function_exists( 'baobab_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override baobab_setup() in a child theme, add your own baobab_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function baobab_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'baobab', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme allows users to set a custom background
	add_custom_background();

	// Your changeable header business starts here
	if ( ! defined( 'HEADER_TEXTCOLOR' ) )
		define( 'HEADER_TEXTCOLOR', '' );

	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	if ( ! defined( 'HEADER_IMAGE' ) )
		define( 'HEADER_IMAGE', '%s/images/logo.png' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to baobab_header_image_width and baobab_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'baobab_header_image_width', 36 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'baobab_header_image_height', 36 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Don't support text inside the header image.
	if ( ! defined( 'NO_HEADER_TEXT' ) )
		define( 'NO_HEADER_TEXT', true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See baobab_admin_header_style(), below.
	add_custom_image_header( '', 'baobab_admin_header_style' );

	// ... and thus ends the changeable header business.

}
endif;

if ( ! function_exists( 'baobab_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in baobab_setup().
 *
 * @since Twenty Ten 1.0
 */
function baobab_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;



/********** COMIENZA EL FUNCTIONS ***********/

/* Creación de los Custom Fields para la página de Perfil */
function get_extra_profile_list() {
return Array(
/* Add your custom fields, here like follows:
'slug_of_the_field_here' => 'Field name for display',
 */
'twitter' => 'Twitter',
'facebook' => 'Facebook',
'carrera' => 'Carrera',
);
}
 
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );
 
function extra_user_profile_fields( $user ) { ?>
<h3><?php _e("Otros", "blank"); ?></h3>

<p style="color:#CC0000">Para <b>Twitter</b> debes colocar sólo tu nombre de usuario, por ejemplo: <b><i>tu-usuario</i></b>
<br>Para <b>Facebook</b> debes colocar la dirección de tu perfil, por ejemplo: <b><i>www.facebook.com/tu-usuario</i></b></p>
 
<table class="form-table">
<?php foreach(get_extra_profile_list() as $key => $value) {?>
<tr>
<th><label for="<?php echo $key; ?>"><?php _e($value); ?></label></th>
<td>
<input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo esc_attr( get_the_author_meta( $key, $user->ID ) ); ?>" class="regular-text" /><br />
<!--  <span class="description"><?php _e("Ingresa tu $value."); ?></span> -->

</td>
</tr>
<?php
}
?>
</table>
<?php }
 
add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );
 
function save_extra_user_profile_fields( $user_id ) {
 
if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
 
foreach(get_extra_profile_list() as $key => $value) {
update_usermeta( $user_id, $key, $_POST[$key] );
}
}





/* Eliminar barra de administración */
function quitar_barra_administracion()	{
	return false;
}
add_filter( 'show_admin_bar' , 'quitar_barra_administracion');


/* Creo dos Menús: El Principal y el del Footer */
register_nav_menu( 'primary', 'Menú principal');
register_nav_menu( 'tertiary', 'Menú movil');
register_nav_menu( 'secondary', 'Footer');


/* Defino el tamaño de las imágenes: 'tipo'=archive-tipo.php; 'tipo-thumbnail'=single-tipo.php */
add_theme_support('post-thumbnails');

add_image_size('idea', 200, 0, true);
add_image_size('idea-thumbnail', 440, 0, true);

add_image_size('evento', 200, 0, true);
add_image_size('evento-thumbnail', 440, 0, true);

add_image_size('debate', 200, 0, true);
add_image_size('debate-thumbnail', 440, 0, true);

add_image_size('proyecto', 200, 0, true);
add_image_size('proyecto-thumbnail', 440, 0, true);

add_image_size('mercado', 200, 0, true);
add_image_size('mercado-thumbnail', 440, 0, true);


/* Acortar textos (BAJADAS) de publicación, para mostrar en el Home y Página específica de cada tipo */
function wp_limit_post($max_char, $more_link_text = '[...]',$noticiagp = false, $stripteaser = 0, $more_file = '') {
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);

   if (strlen($_GET['p']) > 0) {
      if($noticiagp) {
      echo substr($content,0,$max_char);
      }
      else {
      echo '<p>';
      echo substr($content,0,$max_char);
      echo "</p>";
      }
   }
   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
        $content = substr($content, 0, $espacio);
        $content = $content;
        if($noticiagp) {
        echo substr($content,0,$max_char);
        echo $more_link_text;
        }
        else {
        echo '<p>';
        echo substr($content,0,$max_char);
        echo $more_link_text;
        echo "</p>";
        }
   }
   else {
      if($noticiagp) {
      echo substr($content,0,$max_char);
      }
      else {
      echo '<p>';
      echo substr($content,0,$max_char);
      echo "</p>";
      }
   }
}


/* Acortando titulos por caracteres para mostrar en el Home y Página específica de cada tipo de publicación */
function titulo_corto($after = null, $length) {
	$mytitle = get_the_title();
	$size = strlen($mytitle);
	if($size>$length) {
		$mytitle = substr($mytitle, 0, $length);
		$mytitle = explode(' ',$mytitle);
		array_pop($mytitle);
		$mytitle = implode(" ",$mytitle).$after;
	}
	return $mytitle;
}


/* Comentarios */
function estorninos_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:'); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 55;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 55;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						echo '<span class="fn"><a href="'. get_author_posts_url($comment->user_id) .'">'. get_comment_author() .'</a></span>';
						printf( __( '%1$s, %2$s <span class="says"></span>'),
							sprintf(),
							sprintf( '<span="%1$s"><time pubdate datetime="%2$s">%3$s</time></span>', /*en lugar de span era un a href*/
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s'), get_comment_date(), get_comment_time() )
							)
						);					
					?>

				</div><!-- .comment-author .vcard -->			
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.'); ?></em>
					<br />
				<?php endif; ?>


			<div class="comment-content"><?php comment_text(); ?>
			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Responder'), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
			
			</div><!-- comment-content -->
	<?php
			break;
	endswitch;
}


/* REGISTRAR PUBLICACIONES */

/* Proyecto */
function registrar_tipo_proyecto(){
	register_post_type( 'proyecto', array(
		'label' => 'Proyecto',
		'public' => true,
		'show_ui' =>  true,
		'capability_type' => 'post',
		'supports' => array('title', 'editor','revisions', 'thumbnail', 'author', 'excerpt', 'comments'),
		'taxonomies' => array('category'),
		'has_archive' =>  'proyectos',
	) );
}
add_action('init', 'registrar_tipo_proyecto');
add_action('init', 'recibir_proyecto');


/* Ideas */
function registrar_tipo_idea(){
	register_post_type( 'idea', array(
		'label' => 'Idea',
		'public' => true,
		'show_ui' =>  true,
		'capability_type' => 'post',
		'supports' => array('title', 'editor', 'revisions', 'thumbnail', 'author', 'excerpt', 'comments'),
		'taxonomies' => array('category'),
		'has_archive' =>  'ideas',
	) );
}
add_action('init', 'registrar_tipo_idea');
add_action('init', 'recibir_idea');


/* Debate */
function registrar_tipo_debate(){
	register_post_type( 'debate', array(
		'label' => 'Debate',
		'public' => true,
		'show_ui' =>  true,
		'capability_type' => 'post',
		'supports' => array('title', 'editor', 'revisions', 'thumbnail', 'author', 'excerpt', 'comments','custom-fields'),
		'taxonomies' => array('category'),
		'has_archive' =>  'debates',
	) );
}
add_action('init', 'registrar_tipo_debate');
add_action('init', 'recibir_debate');
add_action('init', 'realizar_voto');


/* Eventos */
function registrar_tipo_evento(){
	register_post_type( 'evento', array(
		'label' => 'Evento',
		'public' => true,
		'show_ui' =>  true,
		'capability_type' => 'post',
		'supports' => array('title', 'editor', 'revisions', 'thumbnail', 'author', 'excerpt', 'comments'),
		'taxonomies' => array('category'),
		'has_archive' =>  'eventos',
	) );
}
add_action('init', 'registrar_tipo_evento');
add_action('init', 'recibir_evento');


/* Mercado */
function registrar_tipo_mercado(){
	register_post_type( 'mercado', array(
		'label' => 'Mercado',
		'public' => true,
		'show_ui' =>  true,
		'capability_type' => 'post',
		'supports' => array('title', 'editor', 'revisions', 'thumbnail', 'author', 'excerpt', 'comments'),
		'taxonomies' => array('category'),
		'has_archive' =>  'mercado',
	) );
}
add_action('init', 'registrar_tipo_mercado');
add_action('init', 'recibir_mercado');

/* RECIBIR PUBLICACIONES */
// registrar participante en proyecto y en evento
add_action('init', 'registrar_participante');

/* Proyecto */
function recibir_proyecto(){
	if ( wp_verify_nonce($_POST['_proyecto_nonce'], 'enviar_proyecto') ) {
		if ( $_POST['edit'] == 'true' ) {
			$referer = $_POST['_wp_http_referer'];
			$url = parse_url($referer);
			parse_str($url['query'], $query);
			$insert = wp_update_post(array(
				'ID' => $query['id'],
				'post_title' => $_POST['proyecto']['nombre'],
				'post_content' => $_POST['proyecto']['descripcion'],
				'post_excerpt' => $_POST['proyecto']['imagen'],
				'post_type' => 'proyecto',
				'post_status' => 'publish'
			));
		} else {
			$insert = wp_insert_post(array(
				'post_title' => $_POST['proyecto']['nombre'],
				'post_content' => $_POST['proyecto']['descripcion'],
				'post_excerpt' => $_POST['proyecto']['imagen'],
				'post_type' => 'proyecto',
				'post_status' => 'publish'
			));
		}
		$out = new stdClass;
		if ( is_wp_error($insert) ) {
			$out->status = 'error';
			$out->message = 'Hubo un error al insertar el post';
		} else {
			if ( $_FILES ) {
				require_once ABSPATH .'/wp-admin/includes/file.php';
				foreach ( $_FILES as $file ) {
					if ( $file['error'] == 0 ) {
						$upload = wp_handle_upload( $file, array('test_form'=>false) );
						if ( $upload ) {
							$attachment = wp_insert_attachment(array(
								'post_mime_type' => $upload['type'],
								'post_title' => $_POST['proyecto']['nombre'],
								'post_content' => '',
								'post_status' => 'inherit'
							), $upload['file'], $insert);
							require_once(ABSPATH . 'wp-admin/includes/image.php');
							$attach_data = wp_generate_attachment_metadata( $attachment, $upload['file'] );
							wp_update_attachment_metadata( $attachment, $attach_data );
							update_post_meta( $insert, '_thumbnail_id', $attachment );
						}
					}
				}
			}
		foreach( $_POST['proyecto']['categorias'] as $categoria ){
				wp_set_post_terms( $insert, (int)$categoria, 'category', true );
			}
			if ( $_POST['proyecto']['etapas'] ) {
				$etapas = array_filter( $_POST['proyecto']['etapas'] );
				update_post_meta($insert, 'Etapas', $etapas );
			}
			if ( $_POST['proyecto']['estado'] ){
			update_post_meta( $insert, 'Estado', $_POST['proyecto']['estado'] );
			}
			wp_redirect( get_permalink($insert) );
			exit;
		}
	}
}

function registrar_participante(){
    if (wp_verify_nonce($_POST['_proyecto_unirse'], 'participar_proyecto')) {
        if(isset($_POST["post_id"])){
            // Preparar informacion
            global $current_user;       // ^
            global $wpdb;               // Usuario y database
            get_currentuserinfo();      // v
            
            // Ver que el usuario no se haya unido anteriomente
            if(!is_user_participating($_POST["post_id"], $current_user->ID)){
                $post_id = $_POST["post_id"];   // informacion del post
                $wpdb->insert("wp_participantes", array(
                        'post_id' => $post_id,
                        'user_id' => $current_user->ID
                    ));
            }
        }
        
        wp_redirect($_POST['_wp_http_referer']);
        exit;
    }
}

function is_user_participating($post_id, $user_id){
    $users = get_id_users_in_proyect($post_id);
    foreach($users as $user){
        if($user->user_id == $user_id){            
            return true;
        }
    }
    return false;
}

function get_id_users_in_proyect($post_id){
    global $wpdb;
    $query = "SELECT user_id FROM wp_participantes WHERE post_id = $post_id";
    $result = $wpdb->get_results($query);
    return $result;
}

/* Idea */
function recibir_idea(){
	if ( wp_verify_nonce($_POST['_idea_nonce'], 'enviar_idea') ) {
		if ( $_POST['edit'] == 'true' ) {
			$referer = $_POST['_wp_http_referer'];
			$url = parse_url($referer);
			parse_str($url['query'], $query);
			$insert = wp_update_post(array(
				'ID' => $query['id'],
				'post_title' => $_POST['idea']['nombre'],
				'post_content' => $_POST['idea']['descripcion'],
				'post_excerpt' => $_POST['idea']['imagen'],
				'post_type' => 'idea',
				'post_status' => 'publish'
			));
		} else {
			$insert = wp_insert_post(array(
				'post_title' => $_POST['idea']['nombre'],
				'post_content' => $_POST['idea']['descripcion'],
				'post_excerpt' => $_POST['idea']['imagen'],
				'post_type' => 'idea',
				'post_status' => 'publish'
			));
		}
		$out = new stdClass;
		if ( is_wp_error($insert) ) {
			$out->status = 'error';
			$out->message = 'Hubo un error al insertar el post';
		} else {
			if ( $_FILES ) {
				require_once ABSPATH .'/wp-admin/includes/file.php';
				foreach ( $_FILES as $file ) {
					if ( $file['error'] == 0 ) {
						$upload = wp_handle_upload( $file, array('test_form'=>false) );
						if ( $upload ) {
							$attachment = wp_insert_attachment(array(
								'post_mime_type' => $upload['type'],
								'post_title' => $_POST['idea']['nombre'],
								'post_content' => '',
								'post_status' => 'inherit'
							), $upload['file'], $insert);
							require_once(ABSPATH . 'wp-admin/includes/image.php');
							$attach_data = wp_generate_attachment_metadata( $attachment, $upload['file'] );
							wp_update_attachment_metadata( $attachment, $attach_data );
							update_post_meta( $insert, '_thumbnail_id', $attachment );
						}
					}
				}
			}
			foreach( $_POST['idea']['categorias'] as $categoria ){
				wp_set_post_terms( $insert, (int)$categoria, 'category', true );
			}
			wp_redirect( get_permalink($insert) );
			exit;
		}
	}
}


/* Mercado */
function recibir_mercado(){
	if ( wp_verify_nonce($_POST['_mercado_nonce'], 'enviar_mercado') ) {
		if ( $_POST['edit'] == 'true' ) {
			$referer = $_POST['_wp_http_referer'];
			$url = parse_url($referer);
			parse_str($url['query'], $query);
			$insert = wp_update_post(array(
				'ID' => $query['id'],
				'post_title' => $_POST['mercado']['nombre'],
				'post_content' => $_POST['mercado']['descripcion'],
				'post_excerpt' => $_POST['mercado']['imagen'],
				'post_type' => 'mercado',
				'post_status' => 'publish'
			));
		} else {
			$insert = wp_insert_post(array(
				'post_title' => $_POST['mercado']['nombre'],
				'post_content' => $_POST['mercado']['descripcion'],
				'post_excerpt' => $_POST['mercado']['imagen'],
				'post_type' => 'mercado',
				'post_status' => 'publish'
			));
		}
		$out = new stdClass;
		if ( is_wp_error($insert) ) {
			$out->status = 'error';
			$out->message = 'Hubo un error al insertar el post';
		} else {
			if ( $_FILES ) {
				require_once ABSPATH .'/wp-admin/includes/file.php';
				foreach ( $_FILES as $file ) {
					if ( $file['error'] == 0 ) {
						$upload = wp_handle_upload( $file, array('test_form'=>false) );
						if ( $upload ) {
							$attachment = wp_insert_attachment(array(
								'post_mime_type' => $upload['type'],
								'post_title' => $_POST['mercado']['nombre'],
								'post_content' => '',
								'post_status' => 'inherit'
							), $upload['file'], $insert);
							require_once(ABSPATH . 'wp-admin/includes/image.php');
							$attach_data = wp_generate_attachment_metadata( $attachment, $upload['file'] );
							wp_update_attachment_metadata( $attachment, $attach_data );
							update_post_meta( $insert, '_thumbnail_id', $attachment );
						}
					}
				}
			}
			foreach( $_POST['mercado']['categorias'] as $categoria ){
				wp_set_post_terms( $insert, (int)$categoria, 'category', true );
			}
			if ( $_POST['mercado']['valor'] ){
				update_post_meta( $insert, 'Valor', $_POST['mercado']['valor'] );
			}
			if ( $_POST['mercado']['condicion'] ){
			update_post_meta( $insert, 'Condicion', $_POST['mercado']['condicion'] );
			}
			wp_redirect( get_permalink($insert) );
			exit;
		}
	}
}


/* Debate */
function recibir_debate(){
    global $wpdb;
	if ( wp_verify_nonce($_POST['_debate_nonce'], 'enviar_debate') ) {
			add_filter('wp_insert_post_data', 'filtrar_fecha_debate', 10, 2);
		if ( $_POST['edit'] == 'true' ) {
			$referer = $_POST['_wp_http_referer'];
			$url = parse_url($referer);
			parse_str($url['query'], $query);
			$insert = wp_update_post(array(
				'ID' => $query['id'],
				'post_title' => $_POST['debate']['nombre'],
				'post_content' => $_POST['debate']['descripcion'],
				'post_excerpt' => $_POST['debate']['imagen'],
				'post_type' => 'debate',
				'post_status' => 'publish'
			));
		} else {
			$insert = wp_insert_post(array(
				'post_title' => $_POST['debate']['nombre'],
				'post_content' => $_POST['debate']['descripcion'],
				'post_excerpt' => $_POST['debate']['imagen'],
				'post_type' => 'debate',
				'post_status' => 'publish'
			));
		}
		$out = new stdClass;
		if ( is_wp_error($insert) ) {
			$out->status = 'error';
			$out->message = 'Hubo un error al insertar el post';
		} else {
			if ( $_FILES ) {
				require_once ABSPATH .'/wp-admin/includes/file.php';
				foreach ( $_FILES as $file ) {
					if ( $file['error'] == 0 ) {
						$upload = wp_handle_upload( $file, array('test_form'=>false) );
						if ( $upload ) {
							$attachment = wp_insert_attachment(array(
								'post_mime_type' => $upload['type'],
								'post_title' => $_POST['debate']['nombre'],
								'post_content' => '',
								'post_status' => 'inherit'
							), $upload['file'], $insert);
							require_once(ABSPATH . 'wp-admin/includes/image.php');
							$attach_data = wp_generate_attachment_metadata( $attachment, $upload['file'] );
							wp_update_attachment_metadata( $attachment, $attach_data );
							update_post_meta( $insert, '_thumbnail_id', $attachment );
						}
					}
				}
			}
			foreach( $_POST['debate']['categorias'] as $categoria ){
				wp_set_post_terms( $insert, (int)$categoria, 'category', true );
			}
			if ( $_POST['debate']['pregunta'] ) {
				update_post_meta($insert, 'Pregunta', $_POST['debate']['pregunta'] );
			}
			if ( $_POST['debate']['opciones'] ) {
				$opciones = array_filter( $_POST['debate']['opciones'] );
       	         for($i = 0; $i < sizeof($opciones); $i++){
				if($_POST['edit'] != 'true'){
		             		$wpdb->insert("wp_votes", 
       	                           	array(
                                   	     'post_id' => $insert,
	                                        'vote_text' => $opciones[$i]
              	                      ));
				}
                	}                
			update_post_meta($insert, 'Opciones', $opciones );
			
		  }
			wp_redirect( get_permalink($insert) );
			exit;
		}
	}
}
function filtrar_fecha_debate( $data, $postarr ){
	if ( $data['post_type'] === 'debate' ) {
		$data['post_modified'] = $_POST['debate']['fecha']['ano'] .'-'. $_POST['debate']['fecha']['mes'] .'-'. $_POST['debate']['fecha']['dia'] .' 00:00:00';
	}
	return $data;
}

function realizar_voto(){
    if ( wp_verify_nonce($_POST['_debate_realizar_voto'], 'realizar_voto') && $_POST) {
        if(isset($_POST["vote_id"]) && isset($_POST["post_id"]) && isset($_POST['vote_id']))
        {
	     if(!is_numeric($_POST["vote_id"]) || !is_numeric($_POST["post_id"]) || !is_numeric($_POST["vote_id"])){
		return null;
	     }

            // Preparar informacion
            global $current_user;       // ^
            global $wpdb;               // Usuario
            get_currentuserinfo();      // v
            
            $vote_id = $_POST["vote_id"];   // informacion del post
            $user_id = $current_user->ID;   //login del usuario
            $post_id = $_POST["post_id"];
            
            // Ver si el usuario no voto anteriormente en este post
            if(!check_voto($user_id, $post_id))
            {
                $wpdb->insert("wp_votes_user", 
                            array(
                                        'post_id' => $post_id,
                                        'vote_id' => $vote_id,
                                        'user_id' => $user_id
                                ));
            }
            
            wp_redirect($_POST['_wp_http_referer']);
            exit;
        }
    }
}
function check_voto($user_id, $post_id){
    if(!is_numeric($user_id) || !is_numeric($post_id)){
	return null;
    }
    global $wpdb;
    $query = "SELECT * FROM wp_votes_user WHERE user_id = $user_id and post_id = $post_id";
    $result = $wpdb->get_row($query, ARRAY_N);
    if(is_null($result))
        return false;
    else
        return true;
}

function get_votes_from_post_id($post_id){
	if(!is_numeric($post_id)){
	 return null;
	}

	global $wpdb;
	return $wpdb->get_results("SELECT * FROM wp_votes WHERE post_id = $post_id");
}

function get_votes($vote_id){
    if(!is_numeric($vote_id)){
	return null;
    }
    global $wpdb;
    $query = "SELECT * FROM wp_votes_user WHERE vote_id = $vote_id";
    $result = $wpdb->get_results($query);
    return sizeof($result);
}

/* Evento */
function recibir_evento(){
	if ( wp_verify_nonce($_POST['_evento_nonce'], 'enviar_evento') ) {
		add_filter('wp_insert_post_data', 'filtrar_fecha_evento', 10, 2);
		if ( $_POST['edit'] == 'true' ) {
			$referer = $_POST['_wp_http_referer'];
			$url = parse_url($referer);
			parse_str($url['query'], $query);
			$insert = wp_update_post(array(
				'ID' => $query['id'],
				'post_title' => $_POST['evento']['nombre'],
				'post_content' => $_POST['evento']['descripcion'],
				'post_excerpt' => $_POST['evento']['imagen'],
				'post_type' => 'evento',
				'post_status' => 'publish'
			));
		} else {
			$insert = wp_insert_post(array(
				'post_title' => $_POST['evento']['nombre'],
				'post_content' => $_POST['evento']['descripcion'],
				'post_excerpt' => $_POST['evento']['imagen'],
				'post_type' => 'evento',
				'post_status' => 'publish'
			));
		}
		$out = new stdClass;
		if ( is_wp_error($insert) ) {
			$out->status = 'error';
			$out->message = 'Hubo un error al insertar el post';
		} else {
			if ( $_FILES ) {
				require_once ABSPATH .'/wp-admin/includes/file.php';
				foreach ( $_FILES as $file ) {
					if ( $file['error'] == 0 ) {
						$upload = wp_handle_upload( $file, array('test_form'=>false) );
						if ( $upload ) {
							$attachment = wp_insert_attachment(array(
								'post_mime_type' => $upload['type'],
								'post_title' => $_POST['evento']['nombre'],
								'post_content' => '',
								'post_status' => 'inherit'
							), $upload['file'], $insert);
							require_once(ABSPATH . 'wp-admin/includes/image.php');
							$attach_data = wp_generate_attachment_metadata( $attachment, $upload['file'] );
							wp_update_attachment_metadata( $attachment, $attach_data );
							update_post_meta( $insert, '_thumbnail_id', $attachment );
						}
					}
				}
			}
			foreach( $_POST['evento']['categorias'] as $categoria ){
				wp_set_post_terms( $insert, (int)$categoria, 'category', true );
			}
			if ( $_POST['evento']['lugar'] ){
				update_post_meta( $insert, 'Lugar', $_POST['evento']['lugar'] );
				update_post_meta( $insert, 'Geo', $_POST['evento']['pos'] );
			}
	
			wp_redirect( get_permalink($insert) );
			exit;
		}
	}
}

function filtrar_fecha_evento( $data, $postarr ){
	if ( $data['post_type'] === 'evento' ) {
		$data['post_modified'] = $_POST['evento']['fecha']['ano'] .'-'. $_POST['evento']['fecha']['mes'] .'-'. $_POST['evento']['fecha']['dia'] .' 00:00:00';
	}
	return $data;
}

function get_permalink_by_postname( $postname ){
	global $wpdb;
	$id = $wpdb->get_var( $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_name =%s", $postname) );
	return get_permalink( $id );
}



/* LISTAR PUBLICACIONES */

/*Noticias*/
function listar_noticias(){
	global $post;
	$the_post = $post;
	$noticias = new WP_Query(array(
		'post_type' => 'post',
	));
	if ( $noticias->have_posts() ) : $i = 0;
		echo '<ul><div class="circle"></div>';
			while( $noticias->have_posts() && $i < 4 ) : $noticias->the_post();
			echo '<li>';
			echo ' en <a href="'. the_author_posts_link() .'</a>';
			echo '<a href="'. the_category(', ') .'</a>';
			echo '<a href="'. get_the_date() .'</a>';
			echo '<h5><a href="'. get_permalink() .'">'. titulo_corto ('...', 50) .'</a></h5>';
			echo '</li>';
			$i++;
			endwhile;
		echo '</ul>';
	endif;
	$post = $the_post;

}

add_action('save_post', 'save_noticias_metabox');
function save_noticias_metabox( $postid ){
	update_post_meta( $postid, '_lugar', $_POST['noticia']['lugar'] );
}


/*Ideas*/
function listar_ideas(){
	global $post;
	$the_post = $post;
	$ideas = new WP_Query(array(
		'post_type' => 'idea',
	));
	if ( $ideas->have_posts() ) : $i = 0;
		echo '<ul><div class="circle"></div>';
			while( $ideas->have_posts() && $i < 4 ) : $ideas->the_post();
			echo '<li>';
			echo ' en <a href="'. the_author_posts_link() .'</a>';
			echo '<a href="'. the_category(', ') .'</a>';
			echo '<a href="'. get_the_date() .'</a>';
			echo '<h5><a href="'. get_permalink() .'">'. titulo_corto ('...', 50) .'</a></h5>';
			echo '</li>';
			$i++;
			endwhile;
		echo '</ul>';
	endif;
	$post = $the_post;

}

add_action('save_post', 'save_ideas_metabox');
function save_ideas_metabox( $postid ){
	update_post_meta( $postid, '_lugar', $_POST['idea']['lugar'] );
}


/*Eventos*/
function listar_eventos(){
	global $post;
	$the_post = $post;
	$eventos = new WP_Query(array(
		'post_type' => 'evento',
	));
	if ( $eventos->have_posts() ) : $i = 0;
		echo '<ul><div class="circle"></div>';
			while( $eventos->have_posts() && $i < 4 ) : $eventos->the_post();
			echo '<li>';
			echo ' en <a href="'. the_author_posts_link() .'</a>';
			echo '<a href="'. the_category(', ') .'</a>';
			echo '<a href="'. get_the_date() .'</a>';
			echo '<h5><a href="'. get_permalink() .'">'. titulo_corto ('...', 50) .'</a></h5>';
			echo '</li>';			
			$i++;
			endwhile;
		echo '</ul>';
	endif;
	$post = $the_post;

}
add_action('save_post', 'save_eventos_metabox');
function save_eventos_metabox( $postid ){
	update_post_meta( $postid, '_lugar', $_POST['evento']['lugar'] );
}


/*Debates*/
function listar_debates(){
	global $post;
	$the_post = $post;
	$debates = new WP_Query(array(
		'post_type' => 'debate',
	));
	if ( $debates->have_posts() ) : $i = 0;
		echo '<ul>';
			while( $debates->have_posts() && $i < 4 ) : $debates->the_post();
			echo '<li>';
			echo ' en <a href="'. the_author_posts_link() .'</a>';
			echo '<a href="'. the_category(', ') .'</a>';
			echo '<a href="'. get_the_date() .'</a>';
			echo '<h5><a href="'. get_permalink() .'">'. titulo_corto ('...', 50) .'</a></h5>';
			echo '</li>';
			$i++;
			endwhile;
		echo '</ul>';
	endif;
	$post = $the_post;

}

add_action('save_post', 'save_debates_metabox');
function save_debates_metabox( $postid ){
	update_post_meta( $postid, '_lugar', $_POST['debate']['lugar'] );
}


/*Proyectos*/
function listar_proyectos(){
	global $post;
	$the_post = $post;
	$proyectos = new WP_Query(array(
		'post_type' => 'proyecto',
	));
	if ( $proyectos->have_posts() ) : $i = 0;
		echo '<ul><div class="circle"></div>';
			while( $proyectos->have_posts() && $i < 4 ) : $proyectos->the_post();
			echo '<li>';
			echo ' en <a href="'. the_author_posts_link() .'</a>';
			echo '<a href="'. the_category(', ') .'</a>';
			echo '<a href="'. get_the_date() .'</a>';
			echo '<h5><a href="'. get_permalink() .'">'. titulo_corto ('...', 50) .'</a></h5>';
			echo '</li>';	
			$i++;
			endwhile;
		echo '</ul>';
	endif;
	$post = $the_post;

}

add_action('save_post', 'save_proyectos_metabox');
function save_proyectos_metabox( $postid ){
	update_post_meta( $postid, '_lugar', $_POST['proyecto']['lugar'] );
}

/*Mercado*/
function listar_mercado(){
	global $post;
	$the_post = $post;
	$mercado = new WP_Query(array(
		'post_type' => 'mercado',
	));
	if ( $mercado->have_posts() ) : $i = 0;
		echo '<ul><div class="circle"></div>';
			while( $mercado->have_posts() && $i < 4 ) : $mercado->the_post();
			echo '<li>';
			echo ' en <a href="'. the_author_posts_link() .'</a>';
			echo '<a href="'. the_category(', ') .'</a>';
			echo '<a href="'. get_the_date() .'</a>';
			echo '<h5><a href="'. get_permalink() .'">'. titulo_corto ('...', 50) .'</a></h5>';
			echo '</li>';
			$i++;
			endwhile;
		echo '</ul>';
	endif;
	$post = $the_post;

}

add_action('save_post', 'save_mercado_metabox');
function save_mercado_metabox( $postid ){
	update_post_meta( $postid, '_lugar', $_POST['mercado']['lugar'] );
}



/**
 * @param string $objeto tipo de objeto que se va a enviar o editar
 * @param object $edit objeto que se está editando
 **/
function estorninos_category_checkbox( $objeto, $edit = false ){
	if ( $edit ) {
		$edit_terms = get_the_terms( $edit->ID, 'category' );
		$post_terms = array();
		if ( $edit_terms ) { foreach ( $edit_terms as $et ) {
			$post_terms[] = $et->term_id;
		} }
	}
	$terms = get_terms('category', array('hide_empty'=>false));
	if ( $terms ) {
		echo '<ul>';
		foreach ( $terms as $term ) {
			$exits = in_array($term->term_id, $post_terms) ? ' checked="checked" ' : '';
			echo '<li><label for="'. $term->slug .'"><input '. $exits .' type="checkbox" name="'. $objeto .'[categorias][]" value="'. $term->term_id .'" id="'. $term->slug .'" /> '. $term->name .'</label></li>';
		}
		echo '</ul>';
	}
}

function estorninos_search_query( $request ){
    $dummy_query = new WP_Query();  // the query isn't run if we don't pass any query vars
    $dummy_query->parse_query( $request );

    // this is the actual manipulation; do whatever you need here
    if ( $dummy_query->is_search() ) {
		$request['post_type'] = 'any';
		$request['post_per_page'] = 10;
        //$request['category_name'] = 'news';
	}

	return $request;
}
add_filter('request', 'estorninos_search_query');

/* Permito Widgets */
if ( function_exists('register_sidebars') )
register_sidebars(1);



/**
 * add a default-gravatar to options
 */
if ( !function_exists('fb_addgravatar') ) {
	function fb_addgravatar( $avatar_defaults ) {
		$myavatar = get_bloginfo('template_directory') . '/images/avatar.png';
		$avatar_defaults[$myavatar] = 'Estornino';
		return $avatar_defaults;
	}
	add_filter( 'avatar_defaults', 'fb_addgravatar' );
}