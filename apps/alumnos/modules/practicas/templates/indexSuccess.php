  <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
<h1 align="center" style="color:black;">Contenido Saludent</h1>
<table width="95%" cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="70%" align="center" class="hed">Contenido</td>
        <td width="30%" align="center" class="hed">Edicion</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($contenidoss as $contenido){ ?>
      <tr class="fila_<?php echo $i%2 ; ?>">
        <td width="70%" align="center"><?php echo html_entity_decode($contenido->getDescripcion()) ?></td>
        <td align="center"><?php echo link_to("Editar", 'saludent/edit?id='.$contenido->getId() ,'class="mhead"'); ?></td>
      </tr>
      <?php $i++; ?>
      <?php } ?>

      <br>
  
    </tbody>
  </table>
  <br>  
<h1 align="center" style="color:black;">Listado de Tipo de Prácticas Saludent</h1>
<?php if($sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
         <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
         <a href="<?php echo url_for('tipopracticas/new') ?>">Nueva Tipo de Práctica Saludent</a>
  <?php } ?>

 <br>
<table width="95%" cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="70%" align="center" class="hed">Tipo</td>
        <td width="10%" align="center" class="hed">Orden</td>
        <td width="10%" align="center" class="hed">Edicion</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($tipo_practicass as $tipo_practicas){ ?>
      <tr class="fila_<?php echo $i%2 ; ?>">
        <td width="70%" align="center"><?php echo $tipo_practicas->getNombre() ?></td>
        <td width="10%" align="center"><?php echo $tipo_practicas->getOrden() ?></td>
        <td align="center"><?php echo link_to("Editar", 'tipopracticas/edit?idtipopractica='.$tipo_practicas->getIdtipopractica() ,'class="mhead"'); ?></td>
      </tr>
      <?php $i++; ?>
      <?php } ?>

      <br>
  
    </tbody>
  </table>
  <br>
<h1 align="center" style="color:black;">Listado de Prácticas Saludent</h1>
<?php if($sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
         <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
         <a href="<?php echo url_for('practicas/new') ?>">Nueva Práctica Saludent</a>
  <?php } ?>

 <br>
<table width="95%" cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="10%" align="center" class="hed">Código</td>
        <td width="70%" align="center" class="hed">Práctica</td>
        <td width="10%" align="center" class="hed">Importe</td>
        <td width="10%" align="center" class="hed">Edicion</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($practicass as $practicas){ ?>
      <tr class="fila_<?php echo $i%2 ; ?>">
        <td width="10%" align="center"><?php echo $practicas->getCodigo() ?></td>
        <td width="70%" align="left"><?php echo $practicas->getNombre().' ('.$practicas->getTipoPracticas()->getNombre().') '.'' ?></td>
        <td width="10%" align="center"><?php echo $practicas->getImporte() ?></td>
        <td align="center"><?php echo link_to("Editar", 'practicas/edit?idpractica='.$practicas->getIdpractica() ,'class="mhead"'); ?></td>
      </tr>
      <?php $i++; ?>
      <?php } ?>

      <br>
  
    </tbody>
  </table>
