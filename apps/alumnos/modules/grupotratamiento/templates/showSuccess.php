<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $grupo_tratamiento->getId() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $grupo_tratamiento->getNombre() ?></td>
    </tr>
    <tr>
      <th>Abreviacion:</th>
      <td><?php echo $grupo_tratamiento->getAbreviacion() ?></td>
    </tr>
    <tr>
      <th>Activo:</th>
      <td><?php echo $grupo_tratamiento->getActivo() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $grupo_tratamiento->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $grupo_tratamiento->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Created by:</th>
      <td><?php echo $grupo_tratamiento->getCreatedBy() ?></td>
    </tr>
    <tr>
      <th>Updated by:</th>
      <td><?php echo $grupo_tratamiento->getUpdatedBy() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('grupotratamiento/edit?id='.$grupo_tratamiento->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('grupotratamiento/index') ?>">List</a>
