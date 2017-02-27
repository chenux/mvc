
$(document).ready(function () {
	// Obtener tabla.
	%MODULE%_table();
	// Botones.
	%MODULE%_buttons();
	// Scroll.
	%MODULE%_scroll();	
});

function %MODULE%_buttons () {

		// Botones.
		$('#box_buttons_%MODULE% #add').click(%MODULE%_add);
		$('#box_buttons_%MODULE% #edit').click(%MODULE%_edit).hide();
		$('#box_buttons_%MODULE% #remove').click(%MODULE%_remove).hide();

}


function %MODULE%_buttons_show() {

	$('#table_%MODULE% input:checkbox').change(function(){

		if ( $('#table_%MODULE% input:checked').length ) {

			$('#box_buttons_%MODULE% #edit').show();
			$('#box_buttons_%MODULE% #remove').show();

		} else {

			$('#box_buttons_%MODULE% #edit').hide();
			$('#box_buttons_%MODULE% #remove').hide();

		}

		if( $(this).is(":checked") ) {
			$(this).parent().parent().addClass('module-tabe-row-select');

		} else {
			$(this).parent().parent().removeClass();

		}

	});

}


function %MODULE%_scroll() {

	$('#box_buttons_%MODULE% #edit').hide();
	$('#box_buttons_%MODULE% #remove').hide();
	$('#box_table_%MODULE%').html( '' );
	$('#loading_table_%MODULE%').show();

	$('.theme-table-scroll').scroll(function() {

		if ( $('#table_%MODULE% ').outerHeight(true) - $(this).outerHeight(true) == $(this).scrollTop()  ) {

			console.log('Final');

			var page = $('#filters_%MODULE% ').find('#page');
			var num = parseInt(page.val());

			// Hay más filas.
			if (num > -1) {
				page.val(num + 1);
				service_%MODULE%();
			}


		}

}


function %MODULE%_table() {

	$('#box_buttons_%MODULE% #edit').hide();
	$('#box_buttons_%MODULE% #remove').hide();
	$('#box_table_%MODULE%').html( '' );
	$('#loading_table_%MODULE%').show();

	$.ajax({
		type : 'POST',
		url  : location.pathname,
		data : $('#filters_%MODULE%').serializeArray()
	}).done(function( html ) {

		// Tabla.
		$('#box_table_%MODULE%').html( html );
		$('#loading_table_%MODULE%').hide();

		// Páginas.
		%MODULE%_pages();
		// Mostrar botones.
		%MODULE%_buttons_show();


	});

}


function %MODULE%_add() {

	// Morstrar ventana.
	$('#window_%MODULE%_form').window();

	$.ajax({
		type : 'POST',
		url  : location.pathname,
		data : { module : '%MODULE%', controller : '%CONTROLLER%', action : 'add' }
	}).done(function( html ) {

		$('#window_%MODULE%_form').window('html', html);

		$('#button_%MODULE%_send').click(%MODULE%_send);
		$('#form_%MODULE%').submit_cancel();

	});

}

function %MODULE%_edit() {

	// Id.
	var id = $('#table_%MODULE%').table_get_id();

	// Morstrar ventana.
	$('#window_%MODULE%_form').window();

	$.ajax({
		type : 'POST',
		url  : location.pathname,
		data : { module : '%MODULE%', controller : '%CONTROLLER%', action : 'edit', id : id }
	}).done(function( html ) {

		$('#window_%MODULE%_form').window('html', html);

		$('#button_%MODULE%_send').click(%MODULE%_send);
		$('#form_%MODULE%').submit_cancel();

	});

}

function %MODULE%_remove() {

	// Id.
	var id = $('#table_%MODULE%').table_get_id()

	// Morstrar ventana.
	$('#window_%MODULE%_form').window();

	$.ajax({
		type : 'POST',
		url  : location.pathname,
		data : { module : '%MODULE%', controller : '%CONTROLLER%', action : 'remove', id : id }
	}).done(function( html ) {

		$('#window_%MODULE%_form').window('html', html);

		$('#button_%MODULE%_send').click(%MODULE%_send);
		$('#form_%MODULE%').submit_cancel();

	});

}


function %MODULE%_send() {

	// Limpiar formulario.
	$('#form_%MODULE%').inputs_reset();
	$('#loading_%MODULE%_form').show();

	$.ajax({
		type     : 'POST',
		url      : location.pathname,
		dataType : 'json',
		data     : $('#form_%MODULE%').serializeArray()
	}).done(function( json ) {

		$('#loading_%MODULE%_form').hide();

		// Respuesta del formulario.
		if (json.type == 'DONE') {

			// OK.
			%MODULE%_table();

			$('#window_%MODULE%_form').window('info', json.message);
			$('#window_%MODULE%_form').window('html', '');

			window.setTimeout(function() {
				$('#window_%MODULE%_form').window('close');
			}, 2000);


		} else if (json.type == 'SESSION') {

			// Sesión.
			$('#window_%MODULE%_form').window('alert', json.message);
			location.reload();

		} else if (json.type == 'INCOMPLETE') {

			// Incompleto.
			$('#window_%MODULE%_form').window('alert', json.message);
			$('#form_%MODULE%').dn_required(json.data);

		} else if (json.type == 'WARNING') {

			// Alerta.
			$('#window_%MODULE%_form').window('alert', json.message);


		} else if (json.type == 'ERROR') {

			// Error.
			$('#window_%MODULE%_form').window('error', json.message);

		}

	});


}
