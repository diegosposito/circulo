 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>

<br>
<h1 align="center" style="color:black;">Registrar nuevas atenciones</h1>
<br>

<script>

  $(document).ready(function(){

    $('#atenciones_idobrasocial').change(function(){
        // cargar las ciudades de la carrera al combo
        cargarComboTratamientos('#atenciones_idtratamiento', $(this).val(), 0);
    });
    $('#pacientes_idobrasocial').change(function(){
        // cargar las ciudades de la carrera al combo
        cargarComboTratamientos('#atenciones_idtratamiento', $(this).val(), 0);
        //actualizarOS('#osdescripcion', $(this).val(), 0);
        //actualizarFormato('#ostiponroafiliado', $(this).val(), 0);
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

	function openCity(evt, cityName) {
	    var i, tabcontent, tablinks;
	    tabcontent = document.getElementsByClassName("tabcontent");
	    for (i = 0; i < tabcontent.length; i++) {
	        tabcontent[i].style.display = "none";
	    }
	    tablinks = document.getElementsByClassName("tablinks");
	    for (i = 0; i < tablinks.length; i++) {
	        tablinks[i].className = tablinks[i].className.replace(" active", "");
	    }
	    document.getElementById(cityName).style.display = "block";
	    evt.currentTarget.className += " active";
	}

</script>

<?php include_partial('formnew', array('form' => $form, 'paciente' => $paciente, 'idpaciente' => $idpaciente)) ?>
