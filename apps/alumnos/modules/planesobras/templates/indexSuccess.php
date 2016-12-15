<h1>Planes obrass List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Nombre</th>
      <th>Codigo</th>
      <th>Importe</th>
      <th>Idobrasocial</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Created by</th>
      <th>Updated by</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($planes_obrass as $planes_obras): ?>
    <tr>
      <td><a href="<?php echo url_for('planesobras/show?id='.$planes_obras->getId()) ?>"><?php echo $planes_obras->getId() ?></a></td>
      <td><?php echo $planes_obras->getNombre() ?></td>
      <td><?php echo $planes_obras->getCodigo() ?></td>
      <td><?php echo $planes_obras->getImporte() ?></td>
      <td><?php echo $planes_obras->getIdobrasocial() ?></td>
      <td><?php echo $planes_obras->getCreatedAt() ?></td>
      <td><?php echo $planes_obras->getUpdatedAt() ?></td>
      <td><?php echo $planes_obras->getCreatedBy() ?></td>
      <td><?php echo $planes_obras->getUpdatedBy() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('planesobras/new') ?>">New</a>
