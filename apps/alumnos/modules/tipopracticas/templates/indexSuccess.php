<style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <br>
<h1 align="center" style="color:black;">Listado de Tipo de Prácticas Saludent</h1>
<?php if($sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
         <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
         <a href="<?php echo url_for('tipopracticas/new') ?>">Nueva Tipo de Práctica Saludent</a>
  <?php } ?>

 <br>
<table cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="40%" align="center" class="hed">Tipo</td>
        <td width="10%" align="center" class="hed">Fecha</td>
        <td width="10%" align="center" class="hed">Edicion</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($tipo_practicass as $tipo_practicas){ ?>
      <tr class="fila_<?php echo $i%2 ; ?>">
        <td width="40%" align="center"><?php echo $tipo_practicas->getNombre() ?></td>
        <td width="10%"><?php echo date("d/m/Y", strtotime($tipo_practicas->getCreatedAt())) ?></td>
        <td align="center"><?php echo link_to("Editar", 'tipopracticas/edit?idtipopractica='.$tipo_practicas->getIdtipopractica() ,'class="mhead"'); ?></td>
      </tr>
      <?php $i++; ?>
      <?php } ?>

      <br>
  
    </tbody>
  </table>

