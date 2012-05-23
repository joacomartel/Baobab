<?php
	/* Template Name: Enviar noticia */
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
<form method="post" action="plantilla-envia-noticia.php"></form>


<div id="pagewrap">
<article id="publicacion" class="wrap">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php // echo '<pre>'. print_r($post, true) .'</pre>'; ?>
			<?php if ( get_the_title() ) : ?>
			<h2 class="titulo-post">
				Crear noticia
			</h2>
			<?php endif; ?>
			<?php
				$noticia_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
				$noticia = $noticia_id ? get_post($noticia_id) : null;
			?>

			<form id="formulario-noticia" method="post" action="<?php bloginfo('url'); ?>/index.php" enctype="multipart/form-data">
				<fieldset>
					<!-- Comienza el 'if' para los usuarios logueados -->
					<?php if (is_user_logged_in()){ ?>

						<h4>Titulo</h4>
						<input class="datos" name="noticia[nombre]" type="text" value="<?php echo $noticia->post_title ? esc_attr($noticia->post_title) : '' ?>"/>

						<h4>Descripción</h4>
						<textarea name="noticia[descripcion]" class="text-input descripcion" style="width:100%"><?php echo esc_textarea( $noticia->post_content ); ?></textarea>

						<h4>Imagen</h4>
						<input name="noticia_imagen" type="file" />

						<h4>Categorías</h4>
						<?php estorninos_category_checkbox('noticia', $noticia); ?>

						<input class="button color_la" type="submit" value="Enviar" />
						<?php if ( $noticia ) { ?>
							<input type="hidden" name="edit" value="true" />
						<?php } ?>
							<input type="hidden" name="action" value="enviar_noticia" />
						<?php wp_nonce_field('enviar_noticia', '_noticia_nonce'); ?>
						
<?php } ?>
<!-- Termina el 'if' para los usuarios logueados -->

<!-- Comienza el 'if' para los usuarios que no-logueados -->
<?php
if ( is_user_logged_in() ) {
    echo '';
} else {
    echo 'Para realizar una noticia debes <a href="http://estorninos.ead.pucv.cl/wp-login.php">Iniciar Sesión</a>.';
}
?>
<!-- Termina el 'if' para los usuarios que no-logueados -->



				</fieldset>
			</form>
	<?php endwhile; endif; ?>

</article> <!-- publicacion -->


</div> <!-- pagewrap -->	
<?php get_footer(); ?>