<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $saludent_contenido->getId() ?></td>
    </tr>
    <tr>
      <th>Descripcion:</th>
      <td><?php echo $saludent_contenido->getDescripcion() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $saludent_contenido->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $saludent_contenido->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Created by:</th>
      <td><?php echo $saludent_contenido->getCreatedBy() ?></td>
    </tr>
    <tr>
      <th>Updated by:</th>
      <td><?php echo $saludent_contenido->getUpdatedBy() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('saludent/edit?id='.$saludent_contenido->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('saludent/index') ?>">List</a>
