<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $actualizacionestrat->getId() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $actualizacionestrat->getNombre() ?></td>
    </tr>
    <tr>
      <th>Idorden:</th>
      <td><?php echo $actualizacionestrat->getIdorden() ?></td>
    </tr>
    <tr>
      <th>Imagefile:</th>
      <td><?php echo $actualizacionestrat->getImagefile() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $actualizacionestrat->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $actualizacionestrat->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Created by:</th>
      <td><?php echo $actualizacionestrat->getCreatedBy() ?></td>
    </tr>
    <tr>
      <th>Updated by:</th>
      <td><?php echo $actualizacionestrat->getUpdatedBy() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('actualizacionestrat/edit?id='.$actualizacionestrat->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('actualizacionestrat/index') ?>">List</a>
