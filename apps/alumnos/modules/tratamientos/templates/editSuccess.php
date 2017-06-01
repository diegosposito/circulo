 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>

  <script>

  $(document).ready(function(){

    cargarComboPlanesInicial('#tratamientos_idplan');

    $('#tratamientos_idobrasocial').change(function(){
        // cargar las ciudades de la carrera al combo
        cargarComboPlanes('#tratamientos_idplan', $(this).val(), 0);
        //actualizarOS('#osdescripcion', $(this).val(), 0);
    });

  });

  //Cargar combo de planes de obras sociales
	function cargarComboPlanesInicial(combo){
	    // cargar las ciudades de la carrera al combo
	    $.post("<?php echo url_for('obrassociales/obtenerplanes'); ?>",
	    { idobrasocial: $("#idobrasocial").val(), idplan: $("#idplan").val() },
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
<h1 align="center" style="color:black;">Editar Tratamiento</h1>
<br>

<?php include_partial('form', array('form' => $form, 'idplan' => $idplan, 'idobrasocial' => $idobrasocial)) ?>
