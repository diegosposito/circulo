<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('pacientes/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div align="center">
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          &nbsp;<a href="<?php echo url_for('pacientes/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'pacientes/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
           <?php echo $form->renderHiddenFields(false) ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
            <?php echo $form->renderGlobalErrors() ?>
       <tr>
        <th align="left"><?php echo $form['nombre']->renderLabel() ?></th>
        <td>
          <?php echo $form['nombre']->renderError() ?>
          <?php echo $form['nombre'] ?>
        </td>
      </tr> 
      <tr>
        <th align="left"><?php echo $form['apellido']->renderLabel() ?></th>
        <td>
          <?php echo $form['apellido']->renderError() ?>
          <?php echo $form['apellido'] ?>
        </td>
      </tr>
      <tr>
        <th align="left"><?php echo $form['nroafiliado']->renderLabel() ?></th>
        <td>
          <?php echo $form['nroafiliado']->renderError() ?>
          <?php echo $form['nroafiliado'] ?>
        </td>
      </tr> 
      <tr>
        <th align="left"><?php echo $form['nrodoc']->renderLabel() ?></th>
        <td>
          <?php echo $form['nrodoc']->renderError() ?>
          <?php echo $form['nrodoc'] ?>
        </td>
      </tr> 
      <tr>
        <th align="left"><?php echo $form['idsexo']->renderLabel() ?></th>
        <td>
          <?php echo $form['idsexo']->renderError() ?>
          <?php echo $form['idsexo'] ?>
        </td>
      </tr>
      <tr>
        <th align="left"><?php echo $form['estadocivil']->renderLabel() ?></th>
        <td>
          <?php echo $form['estadocivil']->renderError() ?>
          <?php echo $form['estadocivil'] ?>
        </td>
      </tr> 
      <tr>
        <th align="left"><?php echo $form['fechanac']->renderLabel() ?></th>
        <td>
          <?php echo $form['fechanac']->renderError() ?>
          <?php echo $form['fechanac'] ?>
        </td>
      </tr> 
      <tr>
        <th align="left"><?php echo $form['fechaingreso']->renderLabel() ?></th>
        <td>
          <?php echo $form['fechaingreso']->renderError() ?>
          <?php echo $form['fechaingreso'] ?>
        </td>
      </tr> 

      <tr>
        <th align="center" colspan=2><?php echo '<br>'.'D O M I C I L I O ' ?></th>
      </tr>
      <tr>
        <th align="left"><?php echo $form['direccion']->renderLabel() ?></th>
        <td>
          <?php echo $form['direccion']->renderError() ?>
          <?php echo $form['direccion'] ?>
        </td>
      </tr> 
      <tr>
        <th align="left"><?php echo $form['idciudadnac']->renderLabel() ?></th>
        <td>
          <?php echo $form['idciudadnac']->renderError() ?>
          <?php echo $form['idciudadnac'] ?>
        </td>
      </tr>   
        <tr>
        <th align="center" colspan=2><?php echo '<br>'.'D A T O S   C O N T A C T O ' ?></th>
      </tr> 
       <tr>
        <th align="left"><?php echo $form['email']->renderLabel() ?></th>
        <td>
          <?php echo $form['email']->renderError() ?>
          <?php echo $form['email'] ?>
        </td>
      </tr> 
       <tr>
        <th align="left"><?php echo $form['celular']->renderLabel() ?></th>
        <td>
          <?php echo $form['celular']->renderError() ?>
          <?php echo $form['celular'] ?>
        </td>
      </tr> 
       <tr>
        <th align="left"><?php echo $form['telefono']->renderLabel() ?></th>
        <td>
          <?php echo $form['telefono']->renderError() ?>
          <?php echo $form['telefono'] ?>
        </td>
      </tr> 
        <tr>
        <th align="center" colspan=2><?php echo '<br>'.'O T R A    I N F O R M A C I O N ' ?></th>
      </tr> 
       <tr>
        <th align="left"><?php echo $form['titular']->renderLabel() ?></th>
        <td>
          <?php echo $form['titular']->renderError() ?>
          <?php echo $form['titular'] ?>
        </td>
      </tr> 
       <tr>
        <th align="left"><?php echo $form['parentesco']->renderLabel() ?></th>
        <td>
          <?php echo $form['parentesco']->renderError() ?>
          <?php echo $form['parentesco'] ?>
        </td>
      </tr> 
       <tr>
        <th align="left"><?php echo $form['ocupacion']->renderLabel() ?></th>
        <td>
          <?php echo $form['ocupacion']->renderError() ?>
          <?php echo $form['ocupacion'] ?>
        </td>
      </tr> 
      <tr>
        <th align="left"><?php echo $form['siglas']->renderLabel() ?></th>
        <td>
          <?php echo $form['siglas']->renderError() ?>
          <?php echo $form['siglas'] ?>
        </td>
      </tr> 
      <tr>
        <th align="left"><?php echo $form['plan']->renderLabel() ?></th>
        <td>
          <?php echo $form['plan']->renderError() ?>
          <?php echo $form['plan'] ?>
        </td>
      </tr>
      <tr>
        <th align="left"><?php echo $form['trabajo']->renderLabel() ?></th>
        <td>
          <?php echo $form['trabajo']->renderError() ?>
          <?php echo $form['trabajo'] ?>
        </td>
      </tr>
      <tr>
        <th align="left"><?php echo $form['jerarquia']->renderLabel() ?></th>
        <td>
          <?php echo $form['jerarquia']->renderError() ?>
          <?php echo $form['jerarquia'] ?>
        </td>
      </tr>   
      <tr>
        <th align="left"><?php echo $form['credencial']->renderLabel() ?></th>
        <td>
          <?php echo $form['credencial']->renderError() ?>
          <?php echo $form['credencial'] ?>
        </td>
      </tr> 
      <tr>
        <th align="left"><?php echo $form['anotaciones']->renderLabel() ?></th>
        <td>
          <?php echo $form['anotaciones']->renderError() ?>
          <?php echo $form['anotaciones'] ?>
        </td>
      </tr> 
      <tr>
        <th align="left"><?php echo $form['activo']->renderLabel() ?></th>
        <td>
          <?php echo $form['activo']->renderError() ?>
          <?php echo $form['activo'] ?>
        </td>
      </tr> 
      
      <tr>
        <th align="left"><?php echo $form['historial']->renderLabel() ?></th>
        <td>
          <?php echo $form['historial']->renderError() ?>
          <?php echo $form['historial'] ?>
        </td>
      </tr> 
      <tr>
        <th align="left"><?php echo $form['imagefile']->renderLabel() ?></th>
        <td>
          <?php echo $form['imagefile']->renderError() ?>
          <?php echo $form['imagefile'] ?>
        </td>
      </tr>            
    </tbody>
  </table>
  </div>
</form>
