<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>


<form action="<?php echo url_for('atenciones/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
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
          <input type="submit" value="Guardar" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
          <td colspan="4"><?php echo '<b>'.'Paciente : '.$paciente->getApellido().', '.$paciente->getNombre().'</b>' ?></td>
      </tr>
      <tr>
          <td colspan="4"><?php echo '<b>'.'Tratamiento : '.$atenciones->getTratamiento().'</b>' ?></td>
      </tr>
      <tr>
        <td colspan="1"><?php echo "<b>".$form['mes']->renderLabel()."</b>" ?></td>
        <td colspan="3"><?php echo $form['mes'] ?></td>
      </tr>
      <tr>
        <td colspan="1"><?php echo "<b>".$form['anio']->renderLabel()."</b>" ?></td>
        <td colspan="3"><?php echo $form['anio'] ?></td>
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

    </tbody>
  </table>
  </div>
</form>
