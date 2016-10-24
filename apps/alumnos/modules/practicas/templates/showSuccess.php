<table>
  <tbody>
    <tr>
      <th>Idpractica:</th>
      <td><?php echo $practicas->getIdpractica() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $practicas->getNombre() ?></td>
    </tr>
    <tr>
      <th>Importe:</th>
      <td><?php echo $practicas->getImporte() ?></td>
    </tr>
    <tr>
      <th>Idtipopractica:</th>
      <td><?php echo $practicas->getIdtipopractica() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $practicas->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $practicas->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Created by:</th>
      <td><?php echo $practicas->getCreatedBy() ?></td>
    </tr>
    <tr>
      <th>Updated by:</th>
      <td><?php echo $practicas->getUpdatedBy() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('practicas/edit?idpractica='.$practicas->getIdpractica()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('practicas/index') ?>">List</a>
