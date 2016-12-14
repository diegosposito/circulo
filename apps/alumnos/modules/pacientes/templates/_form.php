<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('pacientes/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div align="left">
  <table style="width:400px" cellpadding="0" cellspacing="0"  class="stats" >
    <tfoot>
      <tr align="left">
        <td colspan="6">
          &nbsp;<a href="<?php echo url_for('pacientes/index') ?>">Volver al listado</a>
          <?php echo $form->renderHiddenFields(false) ?>
          <input type="submit" value="Guardar" />
        </td>
      </tr>
    </tfoot>
    <tbody>
          <?php echo $form->renderGlobalErrors() ?>
        <tr>
          <td width="11%">
            <?php echo $form['nroafiliado']->renderLabel() ?>
          </td>
          <td>
            <?php echo $form['nroafiliado']->render() ?>
          </td>
          <td width="10%">
            <?php echo $form['apellido']->renderLabel() ?>
          </td>
          <td>
            <?php echo $form['apellido']->render() ?>
          </td>

        </tr>  

      <tr>
        <td colspan="4"><br></td>
      </tr>        
      <tr>
        <td colspan="2">
          <?php echo $form['nombre']->renderError() ?>
        </td>
        <td colspan="2">
          <?php echo $form['apellido']->renderError() ?>
        </td>
      </tr>
      <tr>
        <td><?php echo "<b>".$form['nombre']->renderLabel()."</b>" ?></td>
        <td><?php echo $form['nombre'] ?></td>
        <td align="left"><?php echo "<b>".$form['apellido']->renderLabel()."</b>" ?></td>
        <td align="left"><?php echo $form['apellido'] ?></td>
      </tr>  
      <tr>
        <td colspan="4"><?php echo $form['nrodoc']->renderError() ?></td>
      </tr> 
      <tr>
        <td align="left"><?php echo "<b>".$form['nrodoc']->renderLabel()."</b>" ?></td>
        <td align="left"><?php echo $form['nrodoc'] ?></td>
        <td colspan=2> </td>
      </tr> 
      <tr>
        <td colspan="2">
          <?php echo $form['idsexo']->renderError() ?>
        </td>
        <td colspan="2">
          <?php echo $form['estadocivil']->renderError() ?>
        </td>
      </tr>
      <tr>
        <td><?php echo "<b>".$form['idsexo']->renderLabel()."</b>" ?></td>
        <td><?php echo $form['idsexo'] ?></td>
        <td align="left"><?php echo "<b>".$form['estadocivil']->renderLabel()."</b>" ?></td>
        <td align="left"><?php echo $form['estadocivil'] ?></td>
      </tr>  
       <tr>
        <td colspan="2">
          <?php echo $form['fechanac']->renderError() ?>
        </td>
        <td colspan="2">
          <?php echo $form['fechaingreso']->renderError() ?>
        </td>
      </tr>
      <tr>
        <td><?php echo "<b>".$form['fechanac']->renderLabel()."</b>" ?></td>
        <td><?php echo $form['fechanac'] ?></td>
        <td align="left"><?php echo "<b>".$form['fechaingreso']->renderLabel()."</b>" ?></td>
        <td align="left"><?php echo $form['fechaingreso'] ?></td>
      </tr>  
      <tr>
        <th align="center" colspan=3><?php echo '<br>'.'D O M I C I L I O ' ?></th>
      </tr>
      <tr>
        <td colspan="4">
          <?php echo $form['direccion']->renderError() ?>
        </td>
      </tr>
       <tr>
        <td colspan="1"><?php echo "<b>".$form['direccion']->renderLabel()."</b>" ?></td>
        <td colspan="3"><?php echo $form['direccion'] ?></td>
      </tr>  
      <tr>
        <td colspan="2">
          <?php echo $form['idciudadnac']->renderError() ?>
        </td>
      </tr>
       <tr>
        <td colspan="1"><?php echo "<b>".$form['idciudadnac']->renderLabel()."</b>" ?></td>
        <td colspan="3"><?php echo $form['idciudadnac'] ?></td>
      </tr> 
       <tr>
        <td colspan="2">
          <?php echo $form['idciudadnac']->renderError() ?>
        </td>
      </tr>
       <tr>
        <td colspan="1"><?php echo "<b>".$form['idciudadnac']->renderLabel()."</b>" ?></td>
        <td colspan="3"><?php echo $form['idciudadnac'] ?></td>
      </tr>  
      <tr>
        <th align="center" colspan=4><?php echo '<br>'.'D A T O S   C O N T A C T O ' ?></th>
      </tr>
       <tr>
        <td colspan="2">
          <?php echo $form['email']->renderError() ?>
        </td>
        <td colspan="2">
          <?php echo $form['celular']->renderError() ?>
        </td>
      </tr>
       <tr>
        <td><?php echo "<b>".$form['email']->renderLabel()."</b>" ?></td>
        <td><?php echo $form['email'] ?></td>
        <td align="left"><?php echo "<b>".$form['celular']->renderLabel()."</b>" ?></td>
        <td align="left"><?php echo $form['celular'] ?></td>
      </tr> 
       <tr>
        <td colspan="4">
          <?php echo $form['telefono']->renderError() ?>
        </td>
      </tr>
       <tr>
        <td><?php echo "<b>".$form['telefono']->renderLabel()."</b>" ?></td>
        <td><?php echo $form['telefono'] ?></td>
        <td align="left"><?php echo '' ?></td>
        <td align="left"><?php echo '' ?></td>
      </tr> 
      <tr>
        <th align="center" colspan=4><?php echo '<br>'.'O T R A    I N F O R M A C I O N ' ?></th>
      </tr>
       <tr>
        <td colspan="2">
          <?php echo $form['titular']->renderError() ?>
        </td>
        <td colspan="2">
          <?php echo $form['parentesco']->renderError() ?>
        </td>
      </tr>
       <tr>
        <td><?php echo "<b>".$form['titular']->renderLabel()."</b>" ?></td>
        <td><?php echo $form['titular'] ?></td>
        <td align="left"><?php echo "<b>".$form['parentesco']->renderLabel()."</b>" ?></td>
        <td align="left"><?php echo $form['parentesco'] ?></td>
      </tr> 
       <tr>
        <td colspan="2">
          <?php echo $form['ocupacion']->renderError() ?>
        </td>
        <td colspan="2">
          <?php echo $form['siglas']->renderError() ?>
        </td>
      </tr>
       <tr>
        <td><?php echo "<b>".$form['ocupacion']->renderLabel()."</b>" ?></td>
        <td><?php echo $form['ocupacion'] ?></td>
        <td align="left"><?php echo "<b>".$form['siglas']->renderLabel()."</b>" ?></td>
        <td align="left"><?php echo $form['siglas'] ?></td>
      </tr> 
       <tr>
        <td colspan="2">
          <?php echo $form['plan']->renderError() ?>
        </td>
        <td colspan="2">
          <?php echo $form['trabajo']->renderError() ?>
        </td>
      </tr>
       <tr>
        <td><?php echo "<b>".$form['plan']->renderLabel()."</b>" ?></td>
        <td><?php echo $form['plan'] ?></td>
        <td align="left"><?php echo "<b>".$form['trabajo']->renderLabel()."</b>" ?></td>
        <td align="left"><?php echo $form['trabajo'] ?></td>
      </tr> 
       <tr>
        <td colspan="2">
          <?php echo $form['jerarquia']->renderError() ?>
        </td>
        <td colspan="2">
          <?php echo $form['credencial']->renderError() ?>
        </td>
      </tr>
       <tr>
        <td><?php echo "<b>".$form['jerarquia']->renderLabel()."</b>" ?></td>
        <td><?php echo $form['jerarquia'] ?></td>
        <td align="left"><?php echo "<b>".$form['credencial']->renderLabel()."</b>" ?></td>
        <td align="left"><?php echo $form['credencial'] ?></td>
      </tr> 
       <tr>
        <td colspan="2">
          <?php echo $form['anotaciones']->renderError() ?>
        </td>
        <td colspan="2">
          <?php echo $form['activo']->renderError() ?>
        </td>
      </tr>
       <tr>
        <td><?php echo "<b>".$form['anotaciones']->renderLabel()."</b>" ?></td>
        <td><?php echo $form['anotaciones'] ?></td>
        <td align="left"><?php echo "<b>".$form['activo']->renderLabel()."</b>" ?></td>
        <td align="left"><?php echo $form['activo'] ?></td>
      </tr>
      <tr>
        <td colspan="2">
          <?php echo $form['historial']->renderError() ?>
        </td>
      </tr>
       <tr>
        <td colspan="1"><?php echo "<b>".$form['historial']->renderLabel()."</b>" ?></td>
        <td colspan="3"><?php echo $form['historial'] ?></td>
      </tr>  
       <tr>
        <td colspan="2">
          <?php echo $form['imagefile']->renderError() ?>
        </td>
      </tr>
       <tr>
        <td align="left"><?php echo "<b>".$form['imagefile']->renderLabel()."</b>" ?></td>
        <td  colspan="3" align="left"><?php echo $form['imagefile'] ?></td>
      </tr>  
     
      
      
                
    </tbody>
  </table>
  </div>
</form>
