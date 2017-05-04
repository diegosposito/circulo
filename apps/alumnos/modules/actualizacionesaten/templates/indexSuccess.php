<h1>Actualizacionesatens List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Nombre</th>
      <th>Idorden</th>
      <th>Imagefile</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Created by</th>
      <th>Updated by</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($actualizacionesatens as $actualizacionesaten): ?>
    <tr>
      <td><a href="<?php echo url_for('actualizacionesaten/show?id='.$actualizacionesaten->getId()) ?>"><?php echo $actualizacionesaten->getId() ?></a></td>
      <td><?php echo $actualizacionesaten->getNombre() ?></td>
      <td><?php echo $actualizacionesaten->getIdorden() ?></td>
      <td><?php echo $actualizacionesaten->getImagefile() ?></td>
      <td><?php echo $actualizacionesaten->getCreatedAt() ?></td>
      <td><?php echo $actualizacionesaten->getUpdatedAt() ?></td>
      <td><?php echo $actualizacionesaten->getCreatedBy() ?></td>
      <td><?php echo $actualizacionesaten->getUpdatedBy() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('actualizacionesaten/new') ?>">New</a>
