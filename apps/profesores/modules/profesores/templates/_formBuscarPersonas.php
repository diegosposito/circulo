<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div align="center">
<form action="<?php echo url_for('profesores/inscribir') ?>" method="post">
  <table cellspacing="0" class="stats" width="60%">
    <tfoot>
      <tr>
        <td colspan="2" align="center">
          <?php echo $form->renderHiddenFields(false) ?>
          <input type="submit" value="Aceptar" />
        </td>
      </tr>
    </tfoot>
    <tbody>
    <?php if ($mensaje) {?>
      <tr>
        <td colspan="2" align="center">
          <b><font color="red"><div id="mensaje"><?php echo $mensaje; ?></div></font></b>
        </td>
      </tr>    
     <?php } ?>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <td><b><?php echo $form['facultad']->renderLabel() ?></b></td>
        <td>
          <?php echo $form['facultad']->renderError() ?>
          <?php echo $form['facultad'] ?>
        </td>
      </tr>      
      <tr>
        <td><b><?php echo $form['idtipodocumento']->renderLabel() ?></b></td>
        <td>
          <?php echo $form['idtipodocumento']->renderError() ?>
          <?php echo $form['idtipodocumento'] ?>
        </td>
      </tr>
      <tr>
        <td><b><?php echo $form['nrodocumento']->renderLabel() ?></b></td>
        <td>
          <?php echo $form['nrodocumento']->renderError() ?>
          <?php echo $form['nrodocumento'] ?>
        </td>
      </tr>  
    </tbody>
  </table>
</form>
</div>
<br>