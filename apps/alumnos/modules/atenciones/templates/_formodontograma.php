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

    $("#tratamientos").click(function(){
    
        var node = document.getElementById('odontograma');
        domtoimage.toPng(node)
            .then(function (dataUrl) {
               var img = new Image();
               img.src = dataUrl;
               $("#odontoimg").val(dataUrl);
             })
             .catch(function (error) {
                 console.error('oops, something went wrong!', error);
        });
    });

    $("#botonGrabar").click(function(){
    
        var node = document.getElementById('odontograma');
        domtoimage.toPng(node)
            .then(function (dataUrl) {
               var img = new Image();
               img.src = dataUrl;
               $("#odontoimg").val(dataUrl);
             })
             .catch(function (error) {
                 console.error('oops, something went wrong!', error);
        });

        var elemento = $(this);

        $.post("<?php echo url_for('atenciones/guardarodontograma'); ?>",
              $("#formGrabar").serialize(),
              function(data) {
               //   alert(data);
                  var el = document.createElement("div");
                  el.setAttribute("style","height:30px;font-weight: bold;position:absolute;top:90%;left:40%;color:white;background-color:#7DBF0D;");
                  el.innerHTML = "Se ha guardado correctamente el Odontograma";
                  setTimeout(function(){
                    el.parentNode.removeChild(el);
                  },3000);
                  document.body.appendChild(el);
                 // $('#mensajeEstudio').html(data);
                }               
          ); // end post
   
    }); //end botongrabar->click()

   /*  $("#botonPrint").click(function(){
             var node = document.getElementById('odontograma');
             domtoimage.toPng(node)
              .then(function (dataUrl) {
                  var img = new Image(); 
                  img.src = dataUrl;
                  $("#odontoimg").val(dataUrl);
              })
              .catch(function (error) {
                  console.error('oops, something went wrong!', error);
              });
    });*/

});
</script>

 
 <form action="" id="formGrabar" method="post">
    <input type="hidden" name="selectedtab" id="selectedtab" value="<?php echo $selectedtab ?>">
    <input type="hidden" name="matricula" id="matricula" value="<?php echo $matricula ?>">
    <input type="hidden" name="idpaciente" id="idpaciente" value="<?php echo $idpaciente ?>">
    <input type="hidden" name="jsonatenciones" id="jsonatenciones" value="<?php echo $jsonatenciones ?>">
    <input type="hidden" name="selectedcolor" id="selectedcolor" value="<?php echo 'blue' ?>">
    <input type="hidden" name="odontoimg" id="odontoimg" value="">

     <?php
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'DieGo123';
        $secret_iv = 'ReiNo123';
         
        // hash
        $key = hash('sha256', $secret_key);
            
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
         
        $output = openssl_encrypt($fichaimp, $encrypt_method, $key, 0, $iv);
        $id_encriptado = base64_encode($output);
      ?>
  
    <table cellspacing="0" class="stats" width="100%">
    <?php if(!$superadmin) { ?>
    <tr>  <td width="20%" align="left"> <a target=_blank href="<?php echo url_for('atenciones/imprimirficha?id='.$id_encriptado) ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/print.png' align='center' size='20'  height='20' width="20"  /></a>Imprimir odontograma actual</td></tr>
    <tr>  <td width="20%" align="left"> <a target=_blank href="<?php echo url_for('atenciones/imprimirficha?id='.$id_encriptado.'&estado=vacio') ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/print.png' align='center' size='20'  height='20' width="20"  /></a>Imprimir odontograma en blanco</td></tr>
    <tr>
    <td colspan="2" align="center"><input type="button" id="botonGrabar" value="Actualizar Odontograma" /></td>
    </tr>
   <!-- <tr>
     <td colspan="2" align="center"><input type="button" name="botonPrint" id="botonPrint" value="Guardar Imagen odontograma" /></td>
    </tr> -->
    <?php } ?>
    </table>
</form>

<form action="<?php echo url_for('atenciones/editar?id='.$idpaciente) ?>" method="post">
    <input type="hidden" name="selectedtab" id="selectedtab" value="<?php echo $selectedtab ?>">
   
    <table cellspacing="0" class="stats" width="100%">
    <?php if(!$superadmin) { ?>
    <tr><td colspan="2" align="center"><INPUT type="text" id="filtrofec" name="filtrofec" size="10" value="<?php echo date('d/m/Y'); ?>"></td></tr>

    <tr><td colspan="2" align="center"><input type="submit" id="botonFiltrar" value="Filtrar por fecha" /></td></tr>
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
        <select id="tratamientos" name="tratamientos"
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