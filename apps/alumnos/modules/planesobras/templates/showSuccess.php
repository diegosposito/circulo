<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $planes_obras->getId() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $planes_obras->getNombre() ?></td>
    </tr>
    <tr>
      <th>Codigo:</th>
      <td><?php echo $planes_obras->getCodigo() ?></td>
    </tr>
    <tr>
      <th>Importe:</th>
      <td><?php echo $planes_obras->getImporte() ?></td>
    </tr>
    <tr>
      <th>Idobrasocial:</th>
      <td><?php echo $planes_obras->getIdobrasocial() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $planes_obras->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $planes_obras->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Created by:</th>
      <td><?php echo $planes_obras->getCreatedBy() ?></td>
    </tr>
    <tr>
      <th>Updated by:</th>
      <td><?php echo $planes_obras->getUpdatedBy() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('planesobras/edit?id='.$planes_obras->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('planesobras/index') ?>">List</a>
