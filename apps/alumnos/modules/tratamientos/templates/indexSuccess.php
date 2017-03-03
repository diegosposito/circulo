<h1>Tratamientoss List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Nombre</th>
      <th>Abreviacion</th>
      <th>Idgrupotratamiento</th>
      <th>Idobrasocial</th>
      <th>Idontologia</th>
      <th>Garantia</th>
      <th>Importe</th>
      <th>Coseguro</th>
      <th>Bono</th>
      <th>Importeos</th>
      <th>Idautorizacion</th>
      <th>Visible</th>
      <th>Descripcion</th>
      <th>Normas</th>
      <th>Activo</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Created by</th>
      <th>Updated by</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($tratamientoss as $tratamientos): ?>
    <tr>
      <td><a href="<?php echo url_for('tratamientos/show?id='.$tratamientos->getId()) ?>"><?php echo $tratamientos->getId() ?></a></td>
      <td><?php echo $tratamientos->getNombre() ?></td>
      <td><?php echo $tratamientos->getAbreviacion() ?></td>
      <td><?php echo $tratamientos->getIdgrupotratamiento() ?></td>
      <td><?php echo $tratamientos->getIdobrasocial() ?></td>
      <td><?php echo $tratamientos->getIdontologia() ?></td>
      <td><?php echo $tratamientos->getGarantia() ?></td>
      <td><?php echo $tratamientos->getImporte() ?></td>
      <td><?php echo $tratamientos->getCoseguro() ?></td>
      <td><?php echo $tratamientos->getBono() ?></td>
      <td><?php echo $tratamientos->getImporteos() ?></td>
      <td><?php echo $tratamientos->getIdautorizacion() ?></td>
      <td><?php echo $tratamientos->getVisible() ?></td>
      <td><?php echo $tratamientos->getDescripcion() ?></td>
      <td><?php echo $tratamientos->getNormas() ?></td>
      <td><?php echo $tratamientos->getActivo() ?></td>
      <td><?php echo $tratamientos->getCreatedAt() ?></td>
      <td><?php echo $tratamientos->getUpdatedAt() ?></td>
      <td><?php echo $tratamientos->getCreatedBy() ?></td>
      <td><?php echo $tratamientos->getUpdatedBy() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('tratamientos/new') ?>">New</a>

   <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <br>
<h1 align="center" style="color:black;">Listado de Tratamientos</h1>
<?php if($sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
         <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
         <a href="<?php echo url_for('tratamientos/new') ?>">Nuevo tratamiento</a>
  <?php } ?>

 <br>
 <a href="<?php echo url_for('informes/autoridadespdf') ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/printer.png' align='center' size='20' /></a>
<table cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="70%" align="center" class="hed">Autoridad</td>
        <td width="20%" align="center" class="hed">Fecha Creación</td>
        <td width="10%" align="center" class="hed">Edicion</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($autoridadess as $autoridades){ ?>
      <tr class="fila_<?php echo $i%2 ; ?>">
        <td width="70%" align="center"><?php echo $autoridades->getNombre() ?></td>
        <td width="20%"><?php echo date("d/m/Y", strtotime($autoridades->getCreatedAt())) ?></td>
        <td align="center"><?php echo link_to("Editar", 'autoridades/edit?idautoridad='.$autoridades->getIdautoridad() ,'class="mhead"'); ?></td>
      </tr>
      <?php $i++; ?>
      <?php } ?>

      <br>
  
    </tbody>
  </table>
