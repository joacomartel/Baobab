<?php
	/* Template Name: Enviar Debate */
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
<form method="post" action="plantilla-envia-debate.php"></form>



<div id="pagewrap">

<article id="publicacion" class="wrap">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php // echo '<pre>'. print_r($post, true) .'</pre>'; ?>
			<?php if ( get_the_title() ) : ?>
			<h2 class="titulo-post">
				Crear Debate
			</h2>
			<?php endif; ?>
			<?php
				$debate_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
				$debate = $debate_id ? get_post($debate_id) : null;
				$pregunta = get_post_meta($debate_id, 'Pregunta', true);
			?>
			<form id="formulario-debate" method="post" action="<?php bloginfo('url'); ?>/index.php" enctype="multipart/form-data">
				<fieldset>
				<!-- Comienza el 'if' para los usuarios logueados -->
					<?php if (is_user_logged_in()){ ?>

						<h4>Pregunta</h4>
						<input class="datos" name="debate[nombre]" type="text" value="<?php echo $debate->post_title ? esc_attr($debate->post_title) : '' ?>"/>
						<h4>Descripción</h4>
						<textarea name="debate[descripcion]" class="text-input descripcion" style="width:100%"><?php echo esc_textarea( $debate->post_content ); ?></textarea>
						
						<!-- <h4>Pregunta</h4>
						<input type="text" name="debate[pregunta]" class="datos" <?php echo $pregunta ? ' value="'. esc_attr($pregunta) .'"' : '' ?> /> -->
						<h4>Opciones</h4>
						<?php
							$opciones = get_post_meta($_GET['id'], 'Opciones', true);
							if ( $opciones ) {
								foreach ( $opciones as $opcion ) {
									echo '<input type="text" name="debate[opciones][]" value="'. esc_attr($opcion) .'" />';
								}
							}
						?>
						<input type="text" class="datos" name="debate[opciones][]" />
						<p><a href="#" id="agregar-opcion-debate">Agregar otra opción</a></p>
						
						<h4>Cierre del Debate</h4>
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
						
						<h4>Imagen</h4>
						<input name="debate_imagen" type="file" />
						<h4>Categorías</h4>
						<?php estorninos_category_checkbox('debate', $debate); ?>
						
						
						<input class="button color_la" type="submit" value="Enviar" />
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
    echo 'Para realizar un Debate debes <a href="http://estorninos.ead.pucv.cl/wp-login.php">Iniciar Sesión</a>.';
}
?>
<!-- Termina el 'if' para los usuarios que no-logueados -->

				</fieldset>
			</form>
	<?php endwhile; endif; ?>
</article> <!-- publicacion -->

</div> <!-- pagewrap -->
<?php get_footer(); ?>