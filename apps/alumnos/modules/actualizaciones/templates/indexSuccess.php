<h1>Actualizacioness List</h1>

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
    <?php foreach ($actualizacioness as $actualizaciones): ?>
    <tr>
      <td><a href="<?php echo url_for('actualizaciones/show?id='.$actualizaciones->getId()) ?>"><?php echo $actualizaciones->getId() ?></a></td>
      <td><?php echo $actualizaciones->getNombre() ?></td>
      <td><?php echo $actualizaciones->getIdorden() ?></td>
      <td><?php echo $actualizaciones->getImagefile() ?></td>
      <td><?php echo $actualizaciones->getCreatedAt() ?></td>
      <td><?php echo $actualizaciones->getUpdatedAt() ?></td>
      <td><?php echo $actualizaciones->getCreatedBy() ?></td>
      <td><?php echo $actualizaciones->getUpdatedBy() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('actualizaciones/new') ?>">New</a>
