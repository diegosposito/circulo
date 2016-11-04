<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $archivos_profesionales->getId() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $archivos_profesionales->getNombre() ?></td>
    </tr>
    <tr>
      <th>Visible:</th>
      <td><?php echo $archivos_profesionales->getVisible() ?></td>
    </tr>
    <tr>
      <th>Idorden:</th>
      <td><?php echo $archivos_profesionales->getIdorden() ?></td>
    </tr>
    <tr>
      <th>Imagefile:</th>
      <td><?php echo $archivos_profesionales->getImagefile() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $archivos_profesionales->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $archivos_profesionales->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Created by:</th>
      <td><?php echo $archivos_profesionales->getCreatedBy() ?></td>
    </tr>
    <tr>
      <th>Updated by:</th>
      <td><?php echo $archivos_profesionales->getUpdatedBy() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('archivosprofesionales/edit?id='.$archivos_profesionales->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('archivosprofesionales/index') ?>">List</a>
