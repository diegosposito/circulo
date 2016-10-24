<h1>Practicass List</h1>

<table>
  <thead>
    <tr>
      <th>Idpractica</th>
      <th>Nombre</th>
      <th>Importe</th>
      <th>Idtipopractica</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Created by</th>
      <th>Updated by</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($practicass as $practicas): ?>
    <tr>
      <td><a href="<?php echo url_for('practicas/show?idpractica='.$practicas->getIdpractica()) ?>"><?php echo $practicas->getIdpractica() ?></a></td>
      <td><?php echo $practicas->getNombre() ?></td>
      <td><?php echo $practicas->getImporte() ?></td>
      <td><?php echo $practicas->getIdtipopractica() ?></td>
      <td><?php echo $practicas->getCreatedAt() ?></td>
      <td><?php echo $practicas->getUpdatedAt() ?></td>
      <td><?php echo $practicas->getCreatedBy() ?></td>
      <td><?php echo $practicas->getUpdatedBy() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('practicas/new') ?>">New</a>


   <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <br>
<h1 align="center" style="color:black;">Listado de Prácticas Saludent</h1>
<?php if($sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
         <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
         <a href="<?php echo url_for('practicas/new') ?>">Nueva Práctica Saludent</a>
  <?php } ?>

 <br>
<table cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="40%" align="center" class="hed">Práctica</td>
        <td width="10%" align="center" class="hed">Fecha de Creación</td>
        <td width="10%" align="center" class="hed">Edicion</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($practicass as $practicas){ ?>
      <tr class="fila_<?php echo $i%2 ; ?>">
        <td width="40%" align="center"><?php echo $cargo_autoridades->getNombre() ?></td>
        <td width="10%"><?php echo date("d/m/Y", strtotime($cargo_autoridades->getCreatedAt())) ?></td>
        <td align="center"><?php echo link_to("Editar", 'cargoautoridades/edit?idcargoautoridad='.$cargo_autoridades->getIdcargoautoridad() ,'class="mhead"'); ?></td>
      </tr>
      <?php $i++; ?>
      <?php } ?>

      <br>
  
    </tbody>
  </table>
