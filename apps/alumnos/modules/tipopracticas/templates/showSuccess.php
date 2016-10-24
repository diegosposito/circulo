<table>
  <tbody>
    <tr>
      <th>Idtipopractica:</th>
      <td><?php echo $tipo_practicas->getIdtipopractica() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $tipo_practicas->getNombre() ?></td>
    </tr>
    <tr>
      <th>Orden:</th>
      <td><?php echo $tipo_practicas->getOrden() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $tipo_practicas->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $tipo_practicas->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Created by:</th>
      <td><?php echo $tipo_practicas->getCreatedBy() ?></td>
    </tr>
    <tr>
      <th>Updated by:</th>
      <td><?php echo $tipo_practicas->getUpdatedBy() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('tipopracticas/edit?idtipopractica='.$tipo_practicas->getIdtipopractica()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('tipopracticas/index') ?>">List</a>
