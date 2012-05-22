<?php
	/* Template Name: Enviar proyecto */
	get_header();
?>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
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
<div id="pagewrap">

<article id="publicacion" class="wrap">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php // echo '<pre>'. print_r($post, true) .'</pre>'; ?>
			<?php if ( get_the_title() ) : ?>
			<h2 class="titulo-post">
				Crear Proyecto
			</h2>
			
			<?php endif; ?>
			<?php
				$proyecto_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
				$proyecto = $proyecto_id ? get_post($proyecto_id) : null;
				$pregunta = get_post_meta($proyecto_id, 'Pregunta', true);
			?>
			
			<form method="post" action="<?php bloginfo('url'); ?>/index.php" enctype="multipart/form-data">
				<fieldset>
					<!-- Comienza el 'if' para los usuarios logueados -->
					<?php if (is_user_logged_in()){ ?>

						<h4>Titulo</h4>
						<input class="datos" name="proyecto[nombre]" type="text" value="<?php echo $proyecto->post_title ? esc_attr($proyecto->post_title) : '' ?>"/>
					
						<h4>Descripción</h4>						
						<textarea name="proyecto[descripcion]" class="text-input descripcion" style="width:100%"><?php echo esc_textarea( $proyecto->post_content ); ?></textarea>
					
					<!-- TEXTO ENRIQUECIDO <?php the_editor($content_to_load); ?>-->
					
						<h4>Etapas</h4>
						<?php
							$etapas = get_post_meta($_GET['id'], 'Etapas', true);
							if ( $etapas ) {
								foreach ( $etapas as $etapa ) {
									echo '<input type="text" name="proyecto[etapas][]" value="'. esc_attr($etapa) .'" />';
								}
							}
						?>
						<input class="datos" type="text" name="proyecto[etapas][]" />
						<p><a href="#" id="agregar-etapa-proyecto">Agregar otra etapa</a></p>
						
						<h4>Estado</h4>
						<select name="proyecto[estado]">
  							<option>En Curso</option>
  							<option>Finalizado</option>
						</select>
						
						<h4>Imagen</h4>
						<input name="proyecto_imagen" type="file" />
						
						<h4>Categorías</h4>
						<?php estorninos_category_checkbox('proyecto', $proyecto); ?>
<!-- reCaptcha 				
 <script type="text/javascript"
     src="http://www.google.com/recaptcha/api/challenge?k=6Lcz7ssSAAAAAIf3QmsmK6MiUnsowqo1X8d-HRN4">
  </script>
  <noscript>
     <iframe src="http://www.google.com/recaptcha/api/noscript?k=6Lcz7ssSAAAAAIf3QmsmK6MiUnsowqo1X8d-HRN4" height="300" width="500" frameborder="0"></iframe><br>
     <textarea name="recaptcha_challenge_field" rows="3" cols="40"> </textarea>
     <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
  </noscript>	
-->

<input class="button color_la" type="submit" value="Enviar" />
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
    echo 'Para realizar un Proyecto debes <a href="/wp-login.php">Iniciar Sesión</a>.';
}
?>
<!-- Termina el 'if' para los usuarios que no-logueados -->

				</fieldset>
			</form>
		</div>
	<?php endwhile; endif; ?>
</div>

</article> <!-- publicacion -->

</div> <!-- pagewrap -->
<?php get_footer(); ?>