<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $actualizaciones->getId() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $actualizaciones->getNombre() ?></td>
    </tr>
    <tr>
      <th>Idorden:</th>
      <td><?php echo $actualizaciones->getIdorden() ?></td>
    </tr>
    <tr>
      <th>Imagefile:</th>
      <td><?php echo $actualizaciones->getImagefile() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $actualizaciones->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $actualizaciones->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Created by:</th>
      <td><?php echo $actualizaciones->getCreatedBy() ?></td>
    </tr>
    <tr>
      <th>Updated by:</th>
      <td><?php echo $actualizaciones->getUpdatedBy() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('actualizaciones/edit?id='.$actualizaciones->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('actualizaciones/index') ?>">List</a>
