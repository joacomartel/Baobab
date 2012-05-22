<?php
	/* Template Name: Enviar evento */
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
<script type="text/javascript">
	var geocoder = new google.maps.Geocoder();
	var map;	
	var markersArray = [];




function initialize() {
  var haightAshbury = new google.maps.LatLng(37.7699298, -122.4469157);
  var mapOptions = {
    zoom: 12,
    center: haightAshbury,
    mapTypeId: google.maps.MapTypeId.TERRAIN
  };
  map =  new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

  google.maps.event.addListener(map, 'click', function(event) {
    addMarker(event.latLng);
  });
}

function codeAddress()
{
    var address = document.getElementById('lugar').value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
      		addMarker(results[0].geometry.location);
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

function addMarker(location) {
  marker = new google.maps.Marker({
    position: location,
    map: map
  });
  markersArray.push(marker);
  map.setCenter(location);
}

// Removes the overlays from the map, but keeps them in the array
function clearOverlays() {
  if (markersArray) {
    for (i in markersArray) {
      markersArray[i].setMap(null);
    }
  }
}

// Shows any overlays currently in the array
function showOverlays() {
  if (markersArray) {
    for (i in markersArray) {
      markersArray[i].setMap(map);
    }
  }
}

// Deletes all markers in the array by removing references to them
function deleteOverlays() {
  if (markersArray) {
    for (i in markersArray) {
      markersArray[i].setMap(null);
    }
    markersArray.length = 0;
  }
}
						  
</script>


<form method="post" action="plantilla-envia-evento.php"></form>


<div id="pagewrap">

<article id="publicacion" class="wrap">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php // echo '<pre>'. print_r($post, true) .'</pre>'; ?>
			<?php if ( get_the_title() ) : ?>
			<h2 class="titulo-post">
				Crear Evento
			</h2>
			<?php endif; ?>
			<?php
				$evento_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
				$evento = $evento_id ? get_post($evento_id) : null;
				$pregunta = get_post_meta($evento_id, 'Pregunta', true);
			?>
			<form id="formulario-evento" method="post" action="<?php bloginfo('url'); ?>/index.php" enctype="multipart/form-data">
				<fieldset>
				<!-- Comienza el 'if' para los usuarios logueados -->
					<?php if (is_user_logged_in()){ ?>

						<h4>Titulo</h4>
						<input class="datos" name="evento[nombre]" type="text" value="<?php echo $evento->post_title ? esc_attr($evento->post_title) : '' ?>"/>
						<h4>Descripción</h4>
						<textarea name="evento[descripcion]" class="text-input descripcion" style="width:100%"><?php echo esc_textarea( $evento->post_content ); ?></textarea>
						<h4>Lugar</h4>
						<!--<input name="evento[lugar]" class="datos" />-->
						<div id="p_c"></div>
						<span id="otraPos" class="button" style="display:none; float:left; text-decoration:none;"> <a href="javascript:showMap()" >Agregar Otra</a></span>
						<div id="map_form">
							<input type="hidden" id="dir_now">
							<input id="lugar" name="evento[lugar]" type="text" size="50" class="datos" >
							<input type="hidden" id="geopoint">
							<a href="javascript:codeAddress()" class="button tagadd">Ubicar</a>
							<div id="map_canvas" style="width: 100%; height: 300px; border: 10px #CCCCCC;"></div>
							<div id='p_p'></div> <!-- posicion pin -->
						</div>
						<script>initialize();</script>

						<h4>Fecha</h4>
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
						<h4>Imagen</h4>
						<input name="evento_imagen" type="file" />
						<h4>Categorías</h4>
						<?php estorninos_category_checkbox('evento', $evento); ?>
						
						<input class="button color_la" type="submit" value="Enviar" />
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
    echo 'Para realizar un Evento debes <a href="http://estorninos.ead.pucv.cl/wp-login.php">Iniciar Sesión</a>.';
}
?>
<!-- Termina el 'if' para los usuarios que no-logueados -->

				</fieldset>
			</form>
	<?php endwhile; endif; ?>

</article> <!-- publicacion -->


</div> <!-- pagewrap -->
<?php get_footer(); ?>