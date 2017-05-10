 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>

<br>
<h1 align="center" style="color:black;">Editar atenciones</h1>
<br>

<script>

  $(document).ready(function(){

    cargarComboTratamientos('#atenciones_idtratamiento', $('#atenciones_idobrasocial').val(), 0);

    $('#atenciones_idobrasocial').change(function(){
        // cargar las ciudades de la carrera al combo
        cargarComboTratamientos('#atenciones_idtratamiento', $(this).val(), 0);
    });
  });

	//Cargar combo de ciudades
	function actualizarOS(combo, id, idseleccionado){
	    // cargar las ciudades de la carrera al combo
	    $.post("<?php echo url_for('obrassociales/obtenerinfo'); ?>",
	    { idobrasocial: id },
	    function(data){
	      if (data){
	        //$(combo).html(data.substr(3,100));
	        $(combo).html(data.replace(/\d+/g, ''));
	        $(combo).attr('disabled',false);
	      //  $(combo).val(idseleccionado);
	      }else{
	        $(combo).attr('disabled',true);
	        $(combo).html("");
	      }
	    }
	  );
	}

	//Cargar combo de ciudades
	function actualizarFormato(combo, id, idseleccionado){
	    // cargar las ciudades de la carrera al combo
	    $.post("<?php echo url_for('obrassociales/obtenerformato'); ?>",
	    { idobrasocial: id },
	    function(data){
	      if (data){
	        //$(combo).html(data.replace(/\d+/g, ''));
	        $(combo).html(data.substr(1,100));
	        //$(combo).html(data);
	        $(combo).attr('disabled',false);
	      //  $(combo).val(idseleccionado);
	      }else{
	        $(combo).attr('disabled',true);
	        $(combo).html("");
	      }
	    }
	  );
	}

	//Cargar combo de tratamientos
	function cargarComboTratamientos(combo, id, idseleccionado){
	    // cargar las ciudades de la carrera al combo
	    $.post("<?php echo url_for('obrassociales/obtenertratamientos'); ?>",
	    { idobrasocial: id },
	    function(data){
	      if (data){
	        $(combo).html(data);
	        $(combo).attr('disabled',false);
	        $(combo).val(idseleccionado);
	      }else{
	        $(combo).attr('disabled',true);
	        $(combo).html("<option value='0' selected='selected' >----NINGUNA----</option>");
	      }
	    }
	  );
	}

</script>

<?php include_partial('form', array('form' => $form, 'paciente' => $paciente, 'idpaciente' => $idpaciente)) ?>
