 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>

  <script>

  $(document).ready(function(){
 
    $('#tratamientos_idobrasocial').change(function(){
        // cargar las ciudades de la carrera al combo
        cargarComboPlanes('#tratamientos_idplan', $(this).val(), 0);
        //actualizarOS('#osdescripcion', $(this).val(), 0);
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

	//Cargar combo de planes de obras sociales
	function cargarComboPlanes(combo, id, idseleccionado){
	    // cargar las ciudades de la carrera al combo
	    $.post("<?php echo url_for('obrassociales/obtenerplanes'); ?>",
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

<br>
<h1 align="center" style="color:black;">Nuevo Tratamiento</h1>
<br>

<?php include_partial('form', array('form' => $form)) ?>
