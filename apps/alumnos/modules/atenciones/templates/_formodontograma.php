<script type="text/javascript">
$(document).ready(function()
{
    $("input[name=color]").click(function () {   
        if($('input:radio[name=color]:checked').val() == 'red'){
          $("#selectedcolor").val("red");
        } 
        if($('input:radio[name=color]:checked').val() == 'blue'){
          $("#selectedcolor").val("blue");
        } 
    });

    $("#botonGrabar").click(function(){
    var elemento = $(this);
    //var Id = elemento.attr("idinscripcion");
    // asigno los alumnos a las mesas 
        $.post("<?php echo url_for('atenciones/guardarodontograma'); ?>",
          $("#formGrabar").serialize(),
        function(data) {
            alert(data);
           // $('#mensajeEstudio').html(data);
          }               
      );

    });

});
</script>

 
 <form action="" id="formGrabar" method="post">
    <input type="hidden" name="selectedtab" id="selectedtab" value="<?php echo $selectedtab ?>">
    <input type="hidden" name="matricula" id="matricula" value="<?php echo $matricula ?>">
    <input type="hidden" name="idpaciente" id="idpaciente" value="<?php echo $idpaciente ?>">
    <input type="hidden" name="jsonatenciones" id="jsonatenciones" value="<?php echo $jsonatenciones ?>">
    <input type="hidden" name="selectedcolor" id="selectedcolor" value="<?php echo 'blue' ?>">

    <table cellspacing="0" class="stats" width="100%">
    <?php if(!$superadmin) { ?>
    <tr>
    <td colspan="2" align="center"><input type="button" id="botonGrabar" value="Actualizar Odontograma" /></td>
    
    </tr>
    <?php } ?>
    </table>
</form>

  <div id="container">
    <div>
        <input type="radio" name="color" value="red"> Color rojo: Prestaciones Existentes<br>
        <input type="radio" name="color" value="blue" checked> Color azul : Prestaciones requeridas<br>
    </div>
    <div id="main" role="main">      
      <div id="tratamiento">
        <h2>Tratamiento</h2>
        <select 
          data-bind=" options: tratamientosPosibles, 
                      value: tratamientoSeleccionado, 
                      optionsText: function(item){ return item.nombre; },
                      optionsCaption: 'Seleccione un tratamiento...'">
        </select>
        <ul data-bind="foreach: tratamientosAplicados">
          <li>
            P<span data-bind="text: diente.id"></span><span data-bind="text: cara"></span>
            -            
            <span data-bind="text: tratamiento.nombre"></span>
            | 
            <a href="#" data-bind="click: $parent.quitarTratamiento">Eliminar</a>
          </li>
        </ul>
      </div>
      <br>
      <div id="odontograma-wrapper">
        <h2>Odontograma</h2>
        <div id="odontograma"></div>
      </div>      
    </div>
    <footer>
      
    </footer>
  </div> 