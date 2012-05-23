jQuery(document).ready(function($){

	$('#agregar-opcion-debate').click(function(){
		var $wrap = $(this).closest('div'),
			$input = $wrap.find('input:text:last').clone();
		$wrap.find('input:text:last').after( $input );
		$wrap.find('input:text:last').val('').focus();
		return false;
	});
	
	
	$('#agregar-etapa-proyecto').click(function(){
		var $wrap = $(this).closest('div'),
			$input = $wrap.find('input:text:last').clone();
		$wrap.find('input:text:last').after( $input );
		$wrap.find('input:text:last').val('').focus();
		return false;
	});
	
	
	

});




//jQuery(document).ready(function($){

	//$('#formulario-proyecto').submit(function(){
	//	$.post( $('#formulario-proyecto').attr('action') , $('#formulario-proyecto').serialize(), function( datos ){
	//		if ( datos.status === 'ok' ) {
	//			if ( confirm(datos.message) ) {
	//				location.href = datos.url;
	//			}
	//		} else {
	//			alert(datos.message);
	//		}
	//	}, 'json' );
	//	return false;
	//});

