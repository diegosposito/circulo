<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $tratamientos->getId() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $tratamientos->getNombre() ?></td>
    </tr>
    <tr>
      <th>Abreviacion:</th>
      <td><?php echo $tratamientos->getAbreviacion() ?></td>
    </tr>
    <tr>
      <th>Idgrupotratamiento:</th>
      <td><?php echo $tratamientos->getIdgrupotratamiento() ?></td>
    </tr>
    <tr>
      <th>Idobrasocial:</th>
      <td><?php echo $tratamientos->getIdobrasocial() ?></td>
    </tr>
    <tr>
      <th>Idontologia:</th>
      <td><?php echo $tratamientos->getIdontologia() ?></td>
    </tr>
    <tr>
      <th>Garantia:</th>
      <td><?php echo $tratamientos->getGarantia() ?></td>
    </tr>
    <tr>
      <th>Importe:</th>
      <td><?php echo $tratamientos->getImporte() ?></td>
    </tr>
    <tr>
      <th>Coseguro:</th>
      <td><?php echo $tratamientos->getCoseguro() ?></td>
    </tr>
    <tr>
      <th>Bono:</th>
      <td><?php echo $tratamientos->getBono() ?></td>
    </tr>
    <tr>
      <th>Importeos:</th>
      <td><?php echo $tratamientos->getImporteos() ?></td>
    </tr>
    <tr>
      <th>Idautorizacion:</th>
      <td><?php echo $tratamientos->getIdautorizacion() ?></td>
    </tr>
    <tr>
      <th>Visible:</th>
      <td><?php echo $tratamientos->getVisible() ?></td>
    </tr>
    <tr>
      <th>Descripcion:</th>
      <td><?php echo $tratamientos->getDescripcion() ?></td>
    </tr>
    <tr>
      <th>Normas:</th>
      <td><?php echo $tratamientos->getNormas() ?></td>
    </tr>
    <tr>
      <th>Activo:</th>
      <td><?php echo $tratamientos->getActivo() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $tratamientos->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $tratamientos->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Created by:</th>
      <td><?php echo $tratamientos->getCreatedBy() ?></td>
    </tr>
    <tr>
      <th>Updated by:</th>
      <td><?php echo $tratamientos->getUpdatedBy() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('tratamientos/edit?id='.$tratamientos->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('tratamientos/index') ?>">List</a>
