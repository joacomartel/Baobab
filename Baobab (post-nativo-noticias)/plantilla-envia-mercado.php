<?php
	/* Template Name: Enviar Mercado */
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
<form method="post" action="plantilla-envia-mercado.php"></form>

<div id="pagewrap">

<article id="publicacion" class="wrap">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php // echo '<pre>'. print_r($post, true) .'</pre>'; ?>
			<?php if ( get_the_title() ) : ?>
			<h2 class="titulo-post">
				Crear Mercado
			</h2>
			<?php endif; ?>
			<?php
				$mercado_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
				$mercado = $mercado_id ? get_post($mercado_id) : null;
				$pregunta = get_post_meta($mercado_id, 'Pregunta', true);
			?>

			<form id="formulario-mercado" method="post" action="<?php bloginfo('url'); ?>/index.php" enctype="multipart/form-data">
				<fieldset>
					<!-- Comienza el 'if' para los usuarios logueados -->
					<?php if (is_user_logged_in()){ ?>
					
						<h4>Titulo</h4>
						<input class="datos" name="mercado[nombre]" type="text" value="<?php echo $mercado->post_title ? esc_attr($mercado->post_title) : '' ?>"/>

						<h4>Descripción</h4>
						<textarea name="mercado[descripcion]" class="text-input descripcion" style="width:100%"><?php echo esc_textarea( $mercado->post_content ); ?></textarea>

						<h4>Valor</h4>
						<input name="mercado[valor]" class="datos" />

						<h4>Condición</h4>
						<select name="mercado[condicion]">
  							<option>Vendo</option>
  							<option>Compro</option>
  							<option>Transacción Finalizada</option>
						</select>

						<h4>Imagen</h4>
						<input name="mercado_imagen" type="file" />

						<h4>Categorías</h4>
						<?php estorninos_category_checkbox('mercado', $mercado); ?>

						<input class="button color_la" type="submit" value="Enviar" />
						<?php if ( $mercado ) { ?>
							<input type="hidden" name="edit" value="true" />
						<?php } ?>
							<input type="hidden" name="action" value="enviar_mercado" />
						<?php wp_nonce_field('enviar_mercado', '_mercado_nonce'); ?>
						
<?php } ?>
<!-- Termina el 'if' para los usuarios logueados -->

<!-- Comienza el 'if' para los usuarios que no-logueados -->
<?php
if ( is_user_logged_in() ) {
    echo '';
} else {
    echo 'Para publicar un producto en Mercado <a href="http://estorninos.ead.pucv.cl/wp-login.php">Iniciar Sesión</a>.';
}
?>
<!-- Termina el 'if' para los usuarios que no-logueados -->

				</fieldset>
			</form>
	<?php endwhile; endif; ?>

</article> <!-- publicacion -->


</div> <!-- pagewrap -->
<?php get_footer(); ?>
