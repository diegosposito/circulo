<h1>Actualizacionestrats List</h1>

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
    <?php foreach ($actualizacionestrats as $actualizacionestrat): ?>
    <tr>
      <td><a href="<?php echo url_for('actualizacionestrat/show?id='.$actualizacionestrat->getId()) ?>"><?php echo $actualizacionestrat->getId() ?></a></td>
      <td><?php echo $actualizacionestrat->getNombre() ?></td>
      <td><?php echo $actualizacionestrat->getIdorden() ?></td>
      <td><?php echo $actualizacionestrat->getImagefile() ?></td>
      <td><?php echo $actualizacionestrat->getCreatedAt() ?></td>
      <td><?php echo $actualizacionestrat->getUpdatedAt() ?></td>
      <td><?php echo $actualizacionestrat->getCreatedBy() ?></td>
      <td><?php echo $actualizacionestrat->getUpdatedBy() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('actualizacionestrat/new') ?>">New</a>
