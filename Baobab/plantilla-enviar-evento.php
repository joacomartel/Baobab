<?php
	/* Template Name: Enviar evento */
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
<script type="text/javascript">
	var geocoder = new google.maps.Geocoder();
	var map;	
	var markersArray = [];

	function geocodePosition(pos) {
	  geocoder.geocode({
	    latLng: pos
	  }, function(responses) {
	    if (responses && responses.length > 0) {
	      updateMarkerAddress(responses[0].formatted_address); /*Anteriormente comentada*/
	    } else {
	      updateMarkerAddress('Cannot determine address at this location.'); /*Anteriormente comentada*/
	    }
	  });
	}

	function updateMarkerStatus(str) {
	  document.getElementById('markerStatus').innerHTML = str;
	}
	
	function updateMarkerPosition(latLng) {
	  document.getElementById('info').value = [
	    latLng.lat(),
	    latLng.lng()
	  ].join(', ');
	}
	
	function updateMarkerAddress(str) {
	  document.getElementById('lugar').value = str;
	}

	function addMarker(location) {
		clearOverlays();
	  marker = new google.maps.Marker({
	    position: location,
	    map: map,
		draggable: true
	  });
	  markersArray.push(marker);
	  map.setCenter(location);
	}

	function codeAddress()
	{
	    var address = document.getElementById('lugar').value;
	    geocoder.geocode( { 'address': address}, function(results, status) {
	      if (status == google.maps.GeocoderStatus.OK) {
				addMarker(results[0].geometry.location);
			  // Update current position info.
			  updateMarkerPosition(results[0].geometry.location);
			  geocodePosition(results[0].geometry.location);
			  
			  // Add dragging event listeners.
			  google.maps.event.addListener(marker, 'dragstart', function() {
			    updateMarkerAddress('Dragging…');
			  });
			  
			  google.maps.event.addListener(marker, 'drag', function() {

			    updateMarkerPosition(marker.getPosition());
			  });
			  
			  google.maps.event.addListener(marker, 'dragend', function() {

			    geocodePosition(marker.getPosition());
			  });
	      } else {
	        alert('Geocode was not successful for the following reason: ' + status);
	      }
	    });
	}
	function clearOverlays() {
	  	if (markersArray) {
	  	  for (i in markersArray) {
	     	 markersArray[i].setMap(null);
	    	}
	 	 }
	}
	function initialize() {
	  var latLng = new google.maps.LatLng(-33.026665, -71.582365);
	  map = new google.maps.Map(document.getElementById('map_canvas'), {
	    zoom: 15,
	    center: latLng,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  });
	}

	// Onload handler to fire off the app.

	


</script>

<form method="post" action="plantilla-enviar-evento.php"></form>


<div class="pagewrap">

<article id="publicacion">
	<div class="wrap">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php // echo '<pre>'. print_r($post, true) .'</pre>'; ?>
			<?php if ( get_the_title() ) : ?>
			<h2 class="titulo-post"><?php _e("Crear Evento", "Baobab");?></h2>
			<?php endif; ?>
			<?php
				$evento_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
				$evento = $evento_id ? get_post($evento_id) : null;
				$pregunta = get_post_meta($evento_id, 'Pregunta', true);
			?>
			<form id="formulario-evento" method="post" action="<?php echo home_url(); ?>/index.php" enctype="multipart/form-data">
				<fieldset>
				<!-- Comienza el 'if' para los usuarios logueados -->
					<?php if (is_user_logged_in()){ ?>

						<h4><?php _e("Título", "Baobab"); ?></h4>
							<?php if (!isset($_GET['id'])){ 
							echo '<input class="datos" name="evento[nombre]" type="text"/>';
							}else{ 
							echo '<input class="datos" name="evento[nombre]" type="text" value="'.esc_attr($evento->post_title).'"/>';
						}?>

						<h4><?php _e("Descripción", "Baobab"); ?></h4>						
						<?php if (!isset($_GET['id'])){ 
							echo '<textarea name="evento[descripcion]" class="text-input descripcion" style="width:100%">';
							echo '</textarea>';
							}else{ 
							echo '<textarea name="evento[descripcion]" class="text-input descripcion" style="width:100%">';
							echo esc_textarea( $evento->post_content );
							echo '</textarea>';
						}?>

						<h4><?php _e("Lugar", "Baobab"); ?></h4>
	</div> <!-- wrap -->
						<div id="p_c"></div>
						<span id="otraPos" class="button" style="display:none; float:left; text-decoration:none;"> <a href="javascript:showMap()" >Agregar Otra</a></span>
						<div id="map_form">
							<input type="hidden" id="dir_now">
	<div class="wrap2">		<input id="lugar" name="evento[lugar]" type="text" size="50" class="dato2" >
							<input id="info" name="evento[pos]" type="hidden" size="50" class="dates" >
							<input type="hidden" id="geopoint">
							<a href="javascript:codeAddress()" class="btn green"><?php _e("Ubicar", "Baobab"); ?></a>
	</div> <!-- wrap -->
							<div id="map_canvas" style="width: 100%; height: 200px; border: 10px #CCCCCC;"></div>
							<div id='p_p'></div> <!-- posicion pin -->
						</div>
						<script>initialize();</script>
	<div class="wrap2">
						<h4><?php _e("Fecha", "Baobab"); ?></h4>
						<select name="evento[fecha][dia]">
							<?php for ( $i = 1; $i < 32; $i++ ) : ?>
							<option><?php echo str_pad($i, 2, 0, STR_PAD_LEFT); ?></option>
							<?php endfor; ?>
						</select>
						<select name="evento[fecha][mes]">
							<?php for ( $i = 1; $i <= 12; $i++ ) : ?>
							<option><?php echo str_pad($i, 2, 0, STR_PAD_LEFT); ?></option>
							<?php endfor; ?>
						</select>
						<select name="evento[fecha][ano]">
							<?php for ( $i = date('Y'); $i <= date('Y') + 5; $i++ ) : ?>
							<option><?php echo str_pad($i, 2, 0, STR_PAD_LEFT); ?></option>
							<?php endfor; ?>
						</select>
						<h4><?php _e("Imagen", "Baobab"); ?></h4>
						<input name="evento_imagen" type="file" />
						<h4><?php _e("Categorías", "Baobab"); ?></h4>
						<?php baobab_category_checkbox('evento', $evento); ?>
						
						<input class="btn blue" type="submit" value="<?php _e("Enviar", "Baobab"); ?>" />
						<?php if ( $evento ) { ?>
							<input type="hidden" name="edit" value="true" />
						<?php } ?>
							<input type="hidden" name="action" value="enviar_evento" />
						<?php wp_nonce_field('enviar_evento', '_evento_nonce'); ?>
<?php } ?>
<!-- Termina el 'if' para los usuarios logueados -->
<!-- Comienza el 'if' para los usuarios que no-logueados -->
<?php
if ( is_user_logged_in() ) {
    echo '';
} else {
	echo _e("Para publicar un Evento debes", "Baobab");
	echo "<a href='".esc_url( get_permalink( get_page_by_title( __("Inicia Sesión", "Baobab"))))."'>";
	echo _e(" Iniciar Sesión</a>", "Baobab");}
?>
<!-- Termina el 'if' para los usuarios que no-logueados -->

				</fieldset>
			</form>
	<?php endwhile; endif; ?>
	</div> <!-- wrap -->
</article> <!-- publicacion -->


</div> <!-- pagewrap -->
<?php get_footer(); ?>