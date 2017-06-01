 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <br>
<h1 align="center" style="color:black;">Listado de Planes de Obras Sociales</h1>
<br>
<?php if($sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
         <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
         <a href="<?php echo url_for('planesobras/new') ?>">Nuevo Plan de Obra Social</a>
  <?php } ?>

<table cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="5%" align="center" class="hed">idOSocial</td>
        <td width="60%" align="center" class="hed">Obra Social</td>
        <td width="5%" align="center" class="hed">idPlan</td>
        <td width="25%" align="center" class="hed">Plan</td>
        <td width="5%" align="center" class="hed">Activo</td>
        <td width="10%" align="center" class="hed">Edicion</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($planes_obrass as $planes_obras){ ?>
      <tr class="fila_<?php echo $i%2 ; ?>">
        <td width="5%"><?php echo  $planes_obras->getObrasSociales()->getIdObrasocial() ?></td>
        <td width="70%"><?php echo  $planes_obras->getObrasSociales()->getAbreviada() ?></td>
        <td width="5%"><?php echo  $planes_obras->getId() ?></td>
        <td width="25%" align="center"><?php echo $planes_obras->getNombre() ?></td>
        <td align='center' width="5%">
        <?php 
          if ($planes_obras->getActivo()){ ?>
            <img width="17px" height="17px" src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/accept_ico.png' align='center' size='20' />
          <?php } else { ?>
             <img width="14px" height="14px"  src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/wrong_ico.png' align='center' size='20' />
          <?php } ?> 
        </td>
        <td align="center"><?php echo link_to("Editar", 'planesobras/edit?id='.$planes_obras->getId() ,'class="mhead"'); ?></td>
      </tr>
      <?php $i++; ?>
      <?php } ?>

      <br>

    </tbody>
  </table>
