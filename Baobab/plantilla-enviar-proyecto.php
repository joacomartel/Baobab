<?php
	/* Template Name: Enviar proyecto */
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
<form method="post" action="plantilla-envia-proyecto.php"></form>
<div class="pagewrap">

<article id="publicacion">
<div class="wrap">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php // echo '<pre>'. print_r($post, true) .'</pre>'; ?>
			<?php if ( get_the_title() ) : ?>
			<h2 class="titulo-post">
			<?php _e("Crear Proyecto", "Baobab"); ?>
			</h2>
			
			<?php endif; ?>
			<?php
				$proyecto_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
				$proyecto = $proyecto_id ? get_post($proyecto_id) : null;
				$pregunta = get_post_meta($proyecto_id, 'Pregunta', true);
			?>
			
			<form method="post" action="<?php echo home_url(); ?>/index.php" enctype="multipart/form-data">
				<fieldset>
					<!-- Comienza el 'if' para los usuarios logueados -->
					<?php if (is_user_logged_in()){ ?>

						<h4><?php _e("Título", "Baobab"); ?></h4>
							<?php if (!isset($_GET['id'])){ 
							echo '<input class="datos" name="proyecto[nombre]" type="text"/>';
							}else{ 
							echo '<input class="datos" name="proyecto[nombre]" type="text" value="'.esc_attr($proyecto->post_title).'"/>';
						}?>

						<h4><?php _e("Descripción", "Baobab"); ?></h4>						
						<?php if (!isset($_GET['id'])){ 
							echo '<textarea name="proyecto[descripcion]" class="text-input descripcion" style="width:100%">';
							echo '</textarea>';
							}else{ 
							echo '<textarea name="proyecto[descripcion]" class="text-input descripcion" style="width:100%">';
							echo esc_textarea( $proyecto->post_content );
							echo '</textarea>';
						}?>
						
						<h4><?php _e("Etapas", "Baobab"); ?></h4>
						<?php
						if ( isset($_GET['id']) ) {
							$etapas = get_post_meta($_GET['id'], 'Etapas', true);
							if ( $etapas ) {
								foreach ( $etapas as $etapa ) {
									echo '<input type="text" class="datos" name="proyecto[etapas][]" value="'. esc_attr($etapa) .'" />';
								}
							}
						}
						?>
						<input class="datos" type="text" name="proyecto[etapas][]" />
						<p><a href="#" id="agregar-etapa-proyecto" class="btn add"><?php _e("Agregar Etapa", "Baobab"); ?></a></p>
						
						<h4><?php _e("Estado", "Baobab"); ?></h4>
						<select name="proyecto[estado]">
  							<option><?php _e("En Curso", "Baobab"); ?></option>
  							<option><?php _e("Finalizado", "Baobab"); ?></option>
						</select>
						
						<h4><?php _e("Imagen", "Baobab"); ?></h4>
						<input name="proyecto_imagen" type="file" />
						
						<h4><?php _e("Categorías", "Baobab"); ?></h4>
						<?php baobab_category_checkbox('proyecto', $proyecto); ?>

<input class="btn blue" type="submit" value="<?php _e("Enviar", "Baobab"); ?>" />
<?php if ( $proyecto ) { ?>	
<input type="hidden" name="edit" value="true" />
<?php } ?>
<input type="hidden" name="action" value="enviar_proyecto" />
<?php wp_nonce_field('enviar_proyecto', '_proyecto_nonce'); ?>

<?php } ?>
<!-- Termina el 'if' para los usuarios logueados -->

<!-- Comienza el 'if' para los usuarios que no-logueados -->
<?php
if ( is_user_logged_in() ) {
    echo '';
} else {
	echo _e("Para publicar un Proyecto debes", "Baobab");
	echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Inicia Sesión", "Baobab"))))."'>";
	echo _e(" Iniciar Sesión</a>", "Baobab"); 
}
?>
<!-- Termina el 'if' para los usuarios que no-logueados -->

				</fieldset>
			</form>
		</div>
	<?php endwhile; endif; ?>
</div>

</div> <!-- wrap -->
</article> <!-- publicacion -->

</div> <!-- pagewrap -->
<?php get_footer(); ?>