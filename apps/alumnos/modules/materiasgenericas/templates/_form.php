<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('materiasgenericas/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('materiasgenericas/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'materiasgenericas/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Esta seguro?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['idmateriaplan']->renderLabel() ?></th>
        <td>
          <?php echo $form['idmateriaplan']->renderError() ?>
          <?php echo $form['idmateriaplan'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['valormateria']->renderLabel() ?></th>
        <td>
          <?php echo $form['valormateria']->renderError() ?>
          <?php echo $form['valormateria'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
