
<script>
$(document).ready(function(){

    $('#atenciones_importe').attr('disabled','disabled');
    $('#atenciones_coseguro').attr('disabled','disabled');

    $('#botonGuardarAtencion').click(function() {
      $('#atenciones_importe').attr('disabled', false);
      $('#atenciones_coseguro').attr('disabled',false);
      var validado = validarFormAtencion();
      $('#botonGuardarAtencion').attr("disabled","disabled").delay(500000000);
      if(validado == true) {
            // guardar la informacion personal del alumnos ingresada
          $.post("<?php echo url_for('atenciones/create'); ?>",
            $('#formGuardarAtencion').serialize(),
          function(data){
            var obj = jQuery.parseJSON(data);
            $('#mensajeSuccess').html('Registro ingresado correctamente!!');
            $('#mensajeError').html('');
          }
          );

          $('#atenciones_importe').attr('disabled','disabled');
          $('#atenciones_coseguro').attr('disabled','disabled');

    } else {
      $('#mensajeError').html(validado);
      $('#mensajeSuccess').html('');
    }
      window.setTimeout( function(){ $('#botonGuardarAtencion').removeAttr("disabled") }, 50000000 );
      //$('#botonGuardarInfoPersonal').removeAttr("disabled");
    return false;
    });

    $('#atenciones_idtratamiento').change(function(){
        cargarImportes($("#atenciones_idtratamiento").val());
    });


});

function validarFormAtencion(){
  var resultado = true;
  if($("#atenciones_idtratamiento").val() <= 0) {
    resultado = "Debe seleccionar un Tratamiento.";
  }

  return resultado;
}

//Cargar estudios previos
function cargarImportes(id){
  // obtener la lista de estudios previos de la persona
  $.get("<?php echo url_for('atenciones/obtenertratamiento'); ?>",
      { idtratamiento: id },
    function(data){
      var fields = data.split('|');

      var importe = fields[0];
      var coseguro = fields[1];
      $('#atenciones_importe').val(importe);
      $('#atenciones_coseguro').val(coseguro);
    }
  );
}

</script>

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<a title="Volver a la ficha del Paciente" href="<?php echo url_for('atenciones/editar?id='.$idpaciente) ?>"><?php echo 'Volver a la ficha del Paciente' ?></a>

<form action="" id="formGuardarAtencion" method="post">
<input type="hidden" name="idpaciente" id="idpaciente" value="<?php echo $idpaciente ?>">
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div align="left">
  <table style="width:500px" cellpadding="0" cellspacing="0"  class="" >
    <tfoot>
      <tr align="center">
        <td colspan="6">
          &nbsp;
          <?php echo $form->renderHiddenFields(false) ?>
          <input type="submit" value="Guardar" id="botonGuardarAtencion"/>
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
          <td colspan="4">
            <b><font color="red"><div align="center" id="mensajeError"></div></font></b>
          </td>
      </tr>
       <tr>
          <td colspan="4">
            <b><font color="green"><div align="center" id="mensajeSuccess"></div></font></b>
          </td>
      </tr>
      <tr>
          <td colspan="2"><?php echo ''.'</b>' ?></td>
          <td colspan="2"><?php echo '<b>'.'Paciente : '.$paciente->getApellido().', '.$paciente->getNombre().'</b>' ?></td>
      </tr>
      <?php if ($sf_user->getGuardUser()->getIsSuperAdmin()) { ?>
      <tr>
        <td colspan="1"><?php echo "<b>".$form['matricula']->renderLabel()."</b>" ?></td>
        <td colspan="3"><?php echo $form['matricula'] ?></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="1"><?php echo "<b>".$form['idtratamiento']->renderLabel()."</b>" ?></td>
        <td colspan="3"><?php echo $form['idtratamiento'] ?></td>
      </tr>
       <tr>
        <td align="left"><?php echo "<b>".$form['caras']->renderLabel()."</b>" ?></td>
        <td  colspan="3" align="left"><?php echo $form['caras'] ?></td>
      </tr>
      <tr>
       <td align="left"><?php echo "<b>".$form['pieza']->renderLabel()."</b>" ?></td>
       <td  colspan="3" align="left"><?php echo $form['pieza'] ?></td>
     </tr>
     <tr>
      <td colspan="1"><?php echo "<b>".$form['importe']->renderLabel()."</b>" ?></td>
      <td colspan="3"><?php echo $form['importe'] ?></td>
    </tr>
    <tr>
     <td colspan="1"><?php echo "<b>".$form['coseguro']->renderLabel()."</b>" ?></td>
     <td colspan="3"><?php echo $form['coseguro'] ?></td>
   </tr>
   <tr>
    <td colspan="1"><?php echo "<b>".$form['fecha']->renderLabel()."</b>" ?></td>
    <td colspan="3"><?php echo $form['fecha'] ?></td>
  </tr>
  <tr>
   <td colspan="1"><?php echo "<b>".$form['idautorizacion']->renderLabel()."</b>" ?></td>
   <td colspan="3"><?php echo $form['idautorizacion'] ?></td>
 </tr>
 <tr>
  <td colspan="1"><?php echo "<b>".$form['autorizada']->renderLabel()."</b>" ?></td>
  <td colspan="3"><?php echo $form['autorizada'] ?></td>
</tr>
<tr>
 <td colspan="1"><?php echo "<b>".$form['anotacion']->renderLabel()."</b>" ?></td>
 <td colspan="3"><?php echo $form['anotacion'] ?></td>
</tr>

    </tbody>
  </table>
  </div>
</form>
