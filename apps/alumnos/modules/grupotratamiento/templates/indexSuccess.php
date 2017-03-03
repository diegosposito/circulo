  <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <br>
<h1 align="center" style="color:black;">Listado de Grupos de Tratamientos</h1>
<?php if($sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
         <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
         <a href="<?php echo url_for('grupotratamiento/new') ?>">Nuevo Grupo de Tratamiento</a>
  <?php } ?>

 <br>
<table cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="60%" align="center" class="hed">Descripción</td>
        <td width="10%" align="center" class="hed">Abreviación</td>
        <td width="10%" align="center" class="hed">Activo</td>
        <td width="10%" align="center" class="hed">Edición</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($grupo_tratamientos as $grupo_tratamiento){ ?>
      <tr class="fila_<?php echo $i%2 ; ?>">
        <td width="60%" align="center"><?php echo $grupo_tratamiento->getNombre() ?></td>
        <td width="10%" align="center"><?php echo $grupo_tratamiento->getAbreviacion() ?></td>
        <td width="10%" align="center">
        <?php if ($grupo_tratamiento->getActivo()){ ?>
             <img width="17px" height="17px" src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/accept_ico.png' align='center' size='20' />
        <?php } else { ?>
             <img width="14px" height="14px"  src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/wrong_ico.png' align='center' size='20' />
        <?php }  ?>
        </td>
        <td align="center"><?php echo link_to("Editar", 'grupotratamiento/edit?id='.$grupo_tratamiento->getId() ,'class="mhead"'); ?></td>
      </tr>
      <?php $i++; ?>
      <?php } ?>

      <br>
  
    </tbody>
  </table>
