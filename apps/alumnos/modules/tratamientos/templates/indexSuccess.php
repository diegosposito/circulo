  <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <br>
<h1 align="center" style="color:black;">Listado de Tratamientos</h1>
<?php if($sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
         <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
         <a href="<?php echo url_for('tratamientos/new') ?>">Nuevo Tratamiento</a>
  <?php } ?>
  <br>
  <?php if($sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
         <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
         <a href="<?php echo url_for('grupotratamiento/new') ?>">Nuevo Grupo de Tratamiento</a>
  <?php } ?>
<div align="left">
<?php if($sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
         <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
         <a href="<?php echo url_for('actualizacionestrat/masivas') ?>">Actualizaciones Masivas de Tratamientos</a>
  <?php } ?>
  </div>

 <br>
 <table cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="35%" align="center" class="hed">Obra Social</td>
        <td width="30%" align="center" class="hed">Tratamiento</td>
        <td width="5%" align="center" class="hed">Activo</td>
        <td width="10%" align="center" class="hed">Garantía</td>
        <td width="10%" align="center" class="hed">Odontología</td>
        <td width="10%" align="center" class="hed">Edicion</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($tratamientoss as $tratamientos){ ?>
      <tr class="fila_<?php echo $i%2 ; ?>">
        <td width="35%" align="center"><?php echo $tratamientos['obraplan'] ?></td>
        <td width="30%" align="center"><?php echo $tratamientos['tratamiento'] ?></td>
        <td width="5%" align="center">
        <?php if ($tratamientos['activo']){ ?>
             <img width="17px" height="17px" src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/accept_ico.png' align='center' size='20' />
        <?php } else { ?>
             <img width="14px" height="14px"  src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/wrong_ico.png' align='center' size='20' />
        <?php }  ?>
        </td>
        <td width="10%" align="center"><?php echo $tratamientos['garantia'] ?></td>
        <td width="10%" align="center"><?php echo $tratamientos['odontologia'] ?></td>
       <td align="center"><?php echo link_to("Editar", 'tratamientos/edit?id='.$tratamientos['id'] ,'class="mhead"'); ?></td>
      </tr>
      <?php $i++; ?>
      <?php } ?>

      <br>

    </tbody>
  </table>
