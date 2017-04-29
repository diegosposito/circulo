<style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
</style>
  <br>
<h1 align="center" style="color:black;">Listado de Atenciones</h1>
<?php if($sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
         <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
         <a href="<?php echo url_for('atenciones/new') ?>">Registrar Nueva Atención</a>
  <?php } ?>
  <br>
<div align="left">
<?php if($sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
         <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
         <a href="<?php echo url_for('actualizacionestrat/masivas') ?>">Actualizaciones Masivas de Atenciones</a>
  <?php } ?>
  </div>

 <br>
 <table cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="15%" align="center" class="hed">IdPrestacion</td>
        <td width="50%" align="center" class="hed">Mes-Año</td>
        <td width="5%" align="center" class="hed">DNI</td>
        <td width="10%" align="center" class="hed">Matricula</td>
        <td width="10%" align="center" class="hed">Fecha</td>
        <td width="10%" align="center" class="hed">Edicion</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($atencioness as $atenciones){ ?>
      <tr class="fila_<?php echo $i%2 ; ?>">
        <td width="15%" align="center"><?php echo $atenciones['osabreviada'] ?></td>
        <td width="50%" align="center"><?php echo $atenciones['tratamiento'] ?></td>
        <td width="5%" align="center">
        <?php if ($atenciones['activo']){ ?>
             <img width="17px" height="17px" src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/accept_ico.png' align='center' size='20' />
        <?php } else { ?>
             <img width="14px" height="14px"  src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/wrong_ico.png' align='center' size='20' />
        <?php }  ?>
        </td>
        <td width="10%" align="center"><?php echo $atenciones['garantia'] ?></td>
        <td width="10%" align="center"><?php echo $atenciones['odontologia'] ?></td>
       <td align="center"><?php echo link_to("Editar", 'tratamientos/edit?id='.$atenciones['id'] ,'class="mhead"'); ?></td>
      </tr>
      <?php $i++; ?>
      <?php } ?>

      <br>
  
    </tbody>
  </table>

