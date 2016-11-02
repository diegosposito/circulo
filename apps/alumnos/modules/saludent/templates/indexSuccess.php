<h1>Saludent contenidos List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Descripcion</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Created by</th>
      <th>Updated by</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($saludent_contenidos as $saludent_contenido): ?>
    <tr>
      <td><a href="<?php echo url_for('saludent/show?id='.$saludent_contenido->getId()) ?>"><?php echo $saludent_contenido->getId() ?></a></td>
      <td><?php echo $saludent_contenido->getDescripcion() ?></td>
      <td><?php echo $saludent_contenido->getCreatedAt() ?></td>
      <td><?php echo $saludent_contenido->getUpdatedAt() ?></td>
      <td><?php echo $saludent_contenido->getCreatedBy() ?></td>
      <td><?php echo $saludent_contenido->getUpdatedBy() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('saludent/new') ?>">New</a>
