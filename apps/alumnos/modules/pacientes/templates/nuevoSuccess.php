<h1>Modificar de Datos Personales de Alumnos</h1>

<style>
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
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
</style>

<script>
$(document).ready(function(){
  var date = new Date();
  var mes = date.getMonth()+1;
  var dia = date.getDate();
  var fecha = (dia<10 ? '0' : '') + dia + '-' + (mes<10 ? '0' : '') + mes + '-' +date.getFullYear();  

  $('#nrodocumento').attr('readonly',true); 
  $('#idciudadnac').attr('disabled',true);  
 
  <?php if ($idciudadnac==0){ ?>
    $('#idprovincia').attr('disabled',true);
    $('#idciudad').attr('disabled',true);
  <?php }else{ ?>
        cargarComboProvincias('#provincianacimiento', <?php echo $idpaisnac ?>, <?php echo $idprovincianac ?>);
        cargarComboCiudades('#ciudadnacimiento', <?php echo $idprovincianac ?>, <?php echo $idciudadnac ?>);
  <?php } ?>
   $('#idprovincia').focusin(function() {
      // cargar las ciudades de la carrera al combo
        cargarComboCiudades('#idciudadnac', $(this).val(), 0);
    });  
    $('#idprovincia').change(function(){
        // cargar las ciudades de la carrera al combo
        cargarComboCiudades('#idciudadnac', $(this).val(), 0);
    }); 
    $('#idprovincia').change(function(){
        // cargar las ciudades de la carrera al combo
        cargarComboCiudades('#idciudadnac', $(this).val(), 0);
    });       

    
    
 
// Valida el formulario
function validarFormInfoPersonal(){
  //var regexp = /^\d{1,2}\-\d{1,2}\-\d{4}$/;
  var regexpfecha = /^((?:0?[1-9])|(?:[12]\d)|(?:3[01]))\-((?:0?[1-9])|(?:1[0-2]))\-((?:19|20)\d\d)$/;
  var resultado = true;
    
  if (!regexpfecha.test($('#fechanac').val())) {
    resultado = "Debe ingresar una Fecha de Nacimiento válida.";
  }
  if($("#idciudadnac").attr('disabled')) {
    resultado = "Debe seleccionar una Ciudad.";
  } 
  if($("#nombre").val()=="") {
    resultado = "Debe ingresar un Nombre.";
  } 
  if($("#apellido").val()=="") {
    resultado = "Debe ingresar un Apellido.";
  }
  return resultado;
} 

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
// Cargar combo de provincias
function cargarComboProvincias(combo, id, idseleccionado){
    // cargar las ciudades de la carrera al combo
    $.post("<?php echo url_for('paises/obtenerprovincias'); ?>",
          { idpais: id },
          function(data){
            $(combo).html(data);
            $(combo).attr('disabled',false);
            $(combo).val(idseleccionado);
          }
  );  
} 

</script>

<script type="text/javascript">

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

  $('#botonGuardarInfoPersonal').click(function() {
      var validado = validarFormInfoPersonal();
      $('#botonGuardarInfoPersonal').attr("disabled","disabled").delay(5000);
      if(validado == true) {
            // guardar la informacion personal del alumnos ingresada
          $.post("<?php echo url_for('alumnos/guardarinformacionpersonal'); ?>",
            $('#formGuardarInfoPersonal').serialize(),
          function(data){
              var obj = jQuery.parseJSON(data);
            $('#mensajeInfoPersonal').html(obj.mensaje);
            if (obj.id!=0){
                $('#id').val(obj.id);
                $('#formGuardarInfoPersonal #nroafiliado').val(obj.nroafiliado);
                $('#formGuardarContacto #id').val(obj.id);
            }
            //$('#tabs').tabs("option", "disabled", []);
          }
          );
          
    } else {
      alert(validado);
    } 
      window.setTimeout( function(){ $('#botonGuardarInfoPersonal').removeAttr("disabled") }, 5000 );
      //$('#botonGuardarInfoPersonal').removeAttr("disabled");
    return false;
    });   
</script>

<ul class="tab">
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Datos')">Datos Personales</a></li>
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Contacto')">Contacto</a></li>
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Documentacion')">Documentacion</a></li>
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'Guardar')">Guardar</a></li>
</ul>


 <div id="Datos" class="tabcontent">
  <form action="" id="formGuardarInfoPersonal" method="post">
    <table cellspacing="0" class="stats" width="100%">
      <tfoot>
        <tr>
          <td colspan="6" align="center">
              <input type="submit" value="Guardar" id="botonGuardarInfoPersonal"/>
          </td>
        </tr>
      </tfoot>
      <tbody>
        <tr>
          <td colspan="4">
            <b><font color="red"><div id="mensajeInfoPersonal"></div></font></b>
          </td>
        </tr>  
        <tr>
          <td width="19%">
            Carrera:
          </td>       
          <td colspan="3">
            <b><?php echo $carrera ?></b>
          </td>
        </tr>     
        <tr>
          <td>
            <?php echo $form['apellido']->renderLabel() ?>
          </td>
          <td width="15%">
            <?php echo $form['apellido']->render() ?>
          </td>
          <td width="15%">
            <?php echo $form['nombre']->renderLabel() ?>
          </td>
          <td>
            <?php echo $form['nombre']->render() ?>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $form['nrodoc']->renderLabel() ?>
          </td>
          <td>
            <?php echo $form['nrodoc']->render() ?>
          </td>
        </tr>           
        <tr>
          <td>
            <?php echo $form['idsexo']->renderLabel() ?>
          </td>
          <td>
            <?php echo $form['idsexo']->render() ?>
          </td>
          <td>
            <?php echo $form['estadocivil']->renderLabel() ?>
          </td>
          <td>
            <?php echo $form['estadocivil']->render() ?>
          </td>
        </tr>      
        <tr>
          <td colspan="4">Lugar de Nacimiento:</td>
        </tr>  
      <tr>
          <td></td>
          <td>
            <?php echo $form['idciudadnac']->renderLabel() ?>
          </td>
          <td colspan="2">
            <?php echo $form['idciudadnac']->render() ?>
          </td>
        </tr> 
        <tr>
          <td></td>
          <td>
            <?php echo $form['idciudadnac']->renderLabel() ?>
          </td>
          <td colspan="2">
            <?php echo $form['idciudadnac']->render() ?>
          </td>
        </tr> 
        <tr>
          <td><?php echo $form['fechanac']->renderLabel() ?>
          </td>
          <td colspan="3">
            <?php echo $form['fechanac']->render() ?> Ej: 22-08-1997
          </td>
        </tr>         
      </tbody>
    </table>  
    </form>
  </div>
   <div id="contacto" class="tabcontent">
   <form action="" id="formGuardarContacto" method="post">
    <table cellspacing="0" class="stats" width="100%">   
      <tfoot>
        <tr>
          <td colspan="6" align="center">
            <?php echo $form['nroafiliado']->render() ?>
            
            <input type="submit" value="Guardar" id="botonGuardarContacto"/>
          </td>
        </tr>
      </tfoot>    
      <tbody>
        <tr>
          <td colspan="6">
            <b><font color="red"><div id="mensajeContacto"></div></font></b>
          </td>
        </tr>
        <tr>
          <td width="11%">
            <?php echo $form['direccion']->renderLabel() ?>
          </td>
          <td>
            <?php echo $form['direccion']->render() ?>
          </td>
          <td width="10%">
            <?php echo $form['direccion']->renderLabel() ?>
          </td>
          <td>
            <?php echo $form['direccion']->render() ?>
          </td>
        </tr>  
        <tr>
          <td>
            <?php echo $form['telefono']->renderLabel() ?>
          </td>
          <td colspan="6">
            <?php echo $form['telefono']->render() ?> - <?php echo $form['telefono']->render() ?>
          </td>
        </tr>   
        <tr>
          <td>
            <?php echo $form['celular']->renderLabel() ?>
          </td>
          <td colspan="6">
            <?php echo $form['celular']->render() ?> - <?php echo $form['celular']->render() ?>
          </td>
        </tr>   
        <tr>
          <td>
            <?php echo $form['email']->renderLabel() ?>
          </td>
          <td colspan="6">
            <?php echo $form['email']->render() ?>
          </td>
        </tr> 
      </tbody>
    </table>
    </form>
  </div>
  <div id="documentacion" class="tabcontent">
  <form action="" id="formGuardarDocumentacion" method="post">
    <table cellspacing="0" class="stats" width="100%">  
      <tfoot>
        <tr>
          <td colspan="2" align="center">
            <?php echo $form['nroafiliado']->render() ?>
            <input type="submit" value="Guardar" id="botonGuardarDocumentacion"/>
          </td>
        </tr>
      </tfoot> 
      <tbody>
           
                      
       </tbody>
    </table>  
    </form>
  </div>  
  <div id="datos" class="tabcontent">
  <form action="" id="formAgregarEstudio" method="post">
    <table cellspacing="0" class="stats" width="100%">  
      <tbody>
        <tr>
          <td colspan="4">
            <b><font color="red"><div id="mensajeEstudio"></div></font></b>
          </td>
        </tr>  
        <tr>
          <td width="17%">
            <?php echo $form['apellido']->renderLabel() ?>
          </td>
          <td colspan="3">
            <?php echo $form['apellido']->render() ?>
          </td>
        </tr>   
        <tr>
          <td>
            <?php echo $form['nroafiliado']->renderLabel() ?>
          </td>
          <td colspan="3">
            <?php echo $form['nroafiliado']->render() ?>
          </td>
        </tr> 
        <tr>
          <td>
            <?php echo $form['nroafiliado']->renderLabel() ?>
          </td>
          <td colspan="3">
            <?php echo $form['nroafiliado']->render() ?>
          </td>
        </tr> 
        <tr>
          <td>
            <?php echo $form['nroafiliado']->renderLabel() ?>
          </td>
          <td colspan="3">
            <?php echo $form['nroafiliado']->render() ?>
          </td>
        </tr> 
        <tr>
          <td colspan="4"><b>Lugar del Establecimiento:</b></td>
        </tr>         
      <tr>
        <td></td>
          <td width="13%">
            <?php echo $form['idciudadnac']->renderLabel() ?>
          </td>
          <td colspan="2">
            <?php echo $form['idciudadnac']->render() ?>
          </td>
        </tr>  
      <tr>
        <td></td>
          <td>
            <?php echo $form['idciudadnac']->renderLabel() ?>
          </td>
          <td colspan="2">
            <?php echo $form['idciudadnac']->render() ?>
          </td>
        </tr> 
        <tr>
          <td></td>
          <td>
            <?php echo $form['idciudadnac']->renderLabel() ?>
          </td>
          <td colspan="2">
            <?php echo $form['idciudadnac']->render() ?>
          </td>
        </tr>           
        <tr>
          <td>
            <?php echo $form['fechanac']->renderLabel() ?>
          </td>
          <td colspan="3">
            <?php echo $form['fechanac']->render() ?>
          </td>
        </tr> 
        <tr>
          <td>
            <?php echo $form['nroafiliado']->renderLabel() ?>
          </td>
          <td colspan="3">
            <?php echo $form['nroafiliado']->render() ?> <?php echo $form['nroafiliado']->render() ?>
          </td>
        </tr>         
        <tr>
          <td>
            <?php echo $form['activo']->renderLabel() ?>
          </td>
          <td>
            <?php echo $form['activo']->render() ?>
          </td>
          <td width="25%">
            <?php echo $form['activo']->renderLabel() ?>
          </td>
          <td>
            <?php echo $form['activo']->render() ?>
          </td>         
        </tr> 
        <tr>
          <td>
            <?php echo $form['nroafiliado']->renderLabel() ?>
          </td>
          <td>
            <?php echo $form['nroafiliado']->render() ?>
          </td>
          <td>
            <?php echo $form['nroafiliado']->renderLabel() ?>
          </td>
          <td>
            <?php echo $form['nroafiliado']->render() ?>
          </td>         
        </tr> 
        <tr>
          <td colspan="4" align="center">
            <?php echo $form['nroafiliado']->render() ?>        
            <input type="submit" name="botonAgregarEstudio" class="botonAgregarEstudio" value="Guardar" id="botonAgregarEstudio"/>
          </td>
        </tr>                                                     
        <tr>
          <td colspan="4" align="center"><div id="estudiosPrevios"></div></td>
        </tr>
       </tbody>
    </table>  
    </form>
  </div>  
  <div id="guardar" class="tabcontent">
    <table cellspacing="0" class="stats" width="100%">  
    <tr><td>
      <div id='camara' align='center'>
        
      </div>
      </td></tr>
      <tr><td align="center">
      <form action="" method="post">
        <input type="submit" onclick="camGrabar(); return false;" id="botonGrabar" value="Grabar"/>
        <input type="submit" onclick="camCancelar(); return false;" id="botonCancelar" value="Cancelar" style='display:none'/>
        <input type="submit" onclick="camGuardar(); return false;" id="botonGuardar" value="Guardar" style='display:none'/>
      </form>
      </td></tr>
      </table>
  </div>  

