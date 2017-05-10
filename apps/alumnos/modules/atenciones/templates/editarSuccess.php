<style type="text/css">
    body {font-family: "Lato", sans-serif;}

	ul.tab {
	    list-style-type: none;
	    margin: 0;
	    padding: 0;
	    overflow: hidden;
	    border: 1px solid #ccc;
	    background-color: #f1f1f1;
	}

	/* Float the list items side by side */
	ul.tab li {float: left;}

	/* Style the links inside the list items */
	ul.tab li a {
	    display: inline-block;
	    color: black;
	    text-align: center;
	    padding: 14px 16px;
	    text-decoration: none;
	    transition: 0.3s;
	    font-size: 17px;
	}

	/* Change background color of links on hover */
	ul.tab li a:hover {
	    background-color: #ddd;
	}

	/* Create an active/current tablink class */
	ul.tab li a:focus, .active {
	    background-color: #ccc;
	}

	/* Style the tab content */
	.tabcontent {
	    display: block;
	    padding: 6px 12px;
	    border: 1px solid #ccc;
	    border-top: none;
	}
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>

 <script>

  $(document).ready(function(){
    switch($('input[name="selectedtab"]').val()) {
       case '0':
            openCity('Datos',0);
           break;
       case '1':
           openCity('Prestaciones',1);
           break;
       case '2':
           openCity('Documentacion',2);
           break;
       default:
            openCity('Datos',0);
   }

    $('#pacientes_idprovincia').change(function(){
        // cargar las ciudades de la carrera al combo
        cargarComboCiudades('#pacientes_idciudadnac', $(this).val(), 0);
    });
    $('#pacientes_idobrasocial').change(function(){
        // cargar las ciudades de la carrera al combo
        cargarComboPlanes('#pacientes_idplan', $(this).val(), 0);
        actualizarOS('#osdescripcion', $(this).val(), 0);
        actualizarFormato('#ostiponroafiliado', $(this).val(), 0);
    });

  });

    $('#pacientes_idprovincia').click(function() {
		cargarComboCiudades('#pacientes_idciudadnac', $(this).val(), 0);
   	});
   	$('#pacientes_idobrasocial').click(function() {
		cargarComboPlanes('#pacientes_idplan', $(this).val(), 0);
   	});

	//Cargar combo de ciudades
	function cargarComboCiudades(combo, id, idseleccionado){
	    // cargar las ciudades de la carrera al combo
	    $.post("<?php echo url_for('provincias/obtenerciudades'); ?>",
	    { idprovincia: id },
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

	//Cargar combo de ciudades
	function actualizarOS(combo, id, idseleccionado){
	    // cargar las ciudades de la carrera al combo
	    $.post("<?php echo url_for('obrassociales/obtenerinfo'); ?>",
	    { idobrasocial: id },
	    function(data){
	      if (data){
	        $(combo).html(data.replace(/\d+/g, ''));
	        $(combo).attr('disabled',false);
	     //   $(combo).val(idseleccionado);
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
	        $(combo).html(data.substr(3,100));
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

	function openCity(cityName, idseleccionado) {
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
	    tablinks[idseleccionado].className += " active";

      switch(idseleccionado) {
         case 0:
             $('input[name="selectedtab"]').val('0');
             break;
         case 1:
             $('input[name="selectedtab"]').val('1');
             break;
         case 2:
             $('input[name="selectedtab"]').val('2');
             break;
         default:
             $('input[name="selectedtab"]').val('0');
     }
     //document.getElementById('selectedtab').value = idseleccionado;
	}

</script>

<br>
<h1 align="center" style="color:black;">Ficha del Paciente : <?php echo $paciente->getApellido().", ".$paciente->getNombre() ?></h1>
<br>

<ul class="tab">
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity('Datos',0)">Datos Personales</a></li>
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity('Prestaciones',1)">Prestaciones</a></li>
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity('Documentacion',2)">Odontograma</a></li>
</ul>



<div id="Datos" class="tabcontent">
<?php
include_partial('formpaciente', array('form' => $form, 'paciente' => $paciente, 'selectedtab' => $selectedtab)) ?>
</div>

 <div id="Prestaciones" class="tabcontent">
 <?php
 include_partial('formatenciones', array('form' => $form, 'paciente' => $paciente, 'atencioness' => $atencioness, 'selectedtab' => $selectedtab)) ?>
</div>
