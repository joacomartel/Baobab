<?php
	/* Template Name: Enviar Debate */
	get_header();
?>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
        	// General options
        	mode : "textareas",
        	theme : "advanced",
theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink",
theme_advanced_buttons2 : "",
theme_advanced_buttons3 : "",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
});
</script>
<form method="post" action="plantilla-envia-debate.php"></form>



<div class="pagewrap">

<article id="publicacion">
<div class="wrap">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php // echo '<pre>'. print_r($post, true) .'</pre>'; ?>
			<?php if ( get_the_title() ) : ?>
			<h2 class="titulo-post"><?php _e("Crear Debate", "Baobab"); ?></h2>
			<?php endif; ?>
			<?php
				$debate_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
				$debate = $debate_id ? get_post($debate_id) : null;
				$pregunta = get_post_meta($debate_id, 'Pregunta', true);
			?>
			<form id="formulario-debate" method="post" action="<?php echo home_url(); ?>/index.php" enctype="multipart/form-data">
				<fieldset>
				<!-- Comienza el 'if' para los usuarios logueados -->
					<?php if (is_user_logged_in()){ ?>

						<h4><?php _e("Pregunta", "Baobab"); ?></h4>
							<?php if (!isset($_GET['id'])){ 
							echo '<input class="datos" name="debate[nombre]" type="text"/>';
							}else{ 
							echo '<input class="datos" name="debate[nombre]" type="text" value="'.esc_attr($debate->post_title).'"/>';
						}?>

						<h4><?php _e("Descripción", "Baobab"); ?></h4>						
						<?php if (!isset($_GET['id'])){ 
							echo '<textarea name="debate[descripcion]" class="text-input descripcion" style="width:100%">';
							echo '</textarea>';
							}else{ 
							echo '<textarea name="debate[descripcion]" class="text-input descripcion" style="width:100%">';
							echo esc_textarea( $debate->post_content );
							echo '</textarea>';
						}?>
						
						<h4><?php _e("Opciones", "Baobab");?></h4>
						<?php
						if ( isset($_GET['id']) ) {
							$opciones = get_post_meta($_GET['id'], 'Opciones', true);
							if ( $opciones ) {
								foreach ( $opciones as $opcion ) {
									echo '<input type="text" class="datos" name="debate[opciones][]" value="'. esc_attr($opcion) .'" />';
								}
							}
						}
						?>
						<input type="text" class="datos" name="debate[opciones][]" />
						<p><a href="#" id="agregar-opcion-debate" class="btn add"><?php _e("Agregar Opción", "Baobab");?></a></p>
						
						<h4><?php _e("Cierre del Debate", "Baobab");?></h4>
						<select name="debate[fecha][dia]">
							<?php for ( $i = 1; $i < 32; $i++ ) : ?>
							<option <?php date("j") == $i ? printf("selected='selected'") : printf("") ?>><?php echo str_pad($i, 2, 0, STR_PAD_LEFT); ?></option>
							<?php endfor; ?>
						</select>
						<select name="debate[fecha][mes]">
							<?php for ( $i = 1; $i <= 12; $i++ ) : ?>
							<option <?php date("n") == $i ? printf("selected='selected'") : printf("") ?>><?php echo str_pad($i, 2, 0, STR_PAD_LEFT); ?></option>
							<?php endfor; ?>
						</select>
						<select name="debate[fecha][ano]">
							<?php for ( $i = date('Y'); $i <= date('Y') + 5; $i++ ) : ?>
							<option <?php date("Y") == $i ? printf("selected='selected'") : printf("") ?>><?php echo str_pad($i, 2, 0, STR_PAD_LEFT); ?></option>
							<?php endfor; ?>
						</select>
						
						<h4><?php _e("Imagen", "Baobab");?></h4>
						<input name="debate_imagen" type="file" />
						<h4><?php _e("Categorías", "Baobab");?></h4>
						<?php baobab_category_checkbox('debate', $debate); ?>
						
						
						<input class="btn blue" type="submit" value="<?php _e("Enviar", "Baobab"); ?>" />
						<?php if ( $debate ) { ?>
							<input type="hidden" name="edit" value="true" />
						<?php } ?>
							<input type="hidden" name="action" value="enviar_debate" />
						<?php wp_nonce_field('enviar_debate', '_debate_nonce'); ?>


<?php } ?>
<!-- Termina el 'if' para los usuarios logueados -->

<!-- Comienza el 'if' para los usuarios que no-logueados -->
<?php
if ( is_user_logged_in() ) {
    echo '';
} else {
	echo  _e("Para crear un Debate debes", "Baobab");
	echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Inicia Sesión", "Baobab"))))."'>"; 
	echo _e(" Iniciar Sesión</a>", "Baobab"); 
}
?>
<!-- Termina el 'if' para los usuarios que no-logueados -->

				</fieldset>
			</form>
	<?php endwhile; endif; ?>

</div> <!-- wrap -->
</article> <!-- publicacion -->

</div> <!-- pagewrap -->
<?php get_footer(); ?>