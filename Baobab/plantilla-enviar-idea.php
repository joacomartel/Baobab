<?php
	/* Template Name: Enviar idea */
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
<form method="post" action="plantilla-envia-idea.php"></form>


<div class="pagewrap">
<article id="publicacion">
<div class="wrap">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php // echo '<pre>'. print_r($post, true) .'</pre>'; ?>
			<?php if ( get_the_title() ) : ?>
			<h2 class="titulo-post"><?php _e("Crear idea", "Baobab"); ?></h2>
			<?php endif; ?>
			<?php
				$idea_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
				$idea = $idea_id ? get_post($idea_id) : null;
			?>

			<form id="formulario-idea" method="post" action="<?php echo home_url(); ?>/index.php" enctype="multipart/form-data">
				<fieldset>
					<!-- Comienza el 'if' para los usuarios logueados -->
					<?php if (is_user_logged_in()){ ?>

						<h4><?php _e("Título", "Baobab"); ?></h4>
							<?php if (!isset($_GET['id'])){ 
							echo '<input class="datos" name="idea[nombre]" type="text"/>';
							}else{ 
							echo '<input class="datos" name="idea[nombre]" type="text" value="'.esc_attr($idea->post_title).'"/>';
						}?>

						<h4><?php _e("Descripción", "Baobab"); ?></h4>						
						<?php if (!isset($_GET['id'])){ 
							echo '<textarea name="idea[descripcion]" class="text-input descripcion" style="width:100%">';
							echo '</textarea>';
							}else{ 
							echo '<textarea name="idea[descripcion]" class="text-input descripcion" style="width:100%">';
							echo esc_textarea( $idea->post_content );
							echo '</textarea>';
						}?>

						<h4><?php _e("Imagen", "Baobab"); ?></h4>
						<input name="idea_imagen" type="file" />

						<h4><?php _e("Categorías", "Baobab"); ?></h4>
						<?php baobab_category_checkbox('idea', $idea); ?>

						<input class="btn blue" type="submit" value="<?php _e("Enviar", "Baobab"); ?>" />
						<?php if ( $idea ) { ?>
							<input type="hidden" name="edit" value="true" />
						<?php } ?>
							<input type="hidden" name="action" value="enviar_idea" />
						<?php wp_nonce_field('enviar_idea', '_idea_nonce'); ?>
						
<?php } ?>
<!-- Termina el 'if' para los usuarios logueados -->

<!-- Comienza el 'if' para los usuarios que no-logueados -->
<?php
if ( is_user_logged_in() ) {
    echo '';
} else {
	echo _e("Para publicar una Idea debes", "Baobab");
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