<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $actualizacionesaten->getId() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $actualizacionesaten->getNombre() ?></td>
    </tr>
    <tr>
      <th>Idorden:</th>
      <td><?php echo $actualizacionesaten->getIdorden() ?></td>
    </tr>
    <tr>
      <th>Imagefile:</th>
      <td><?php echo $actualizacionesaten->getImagefile() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $actualizacionesaten->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $actualizacionesaten->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Created by:</th>
      <td><?php echo $actualizacionesaten->getCreatedBy() ?></td>
    </tr>
    <tr>
      <th>Updated by:</th>
      <td><?php echo $actualizacionesaten->getUpdatedBy() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('actualizacionesaten/edit?id='.$actualizacionesaten->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('actualizacionesaten/index') ?>">List</a>
