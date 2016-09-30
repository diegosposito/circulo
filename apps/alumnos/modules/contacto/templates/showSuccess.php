<table>
  <tbody>
    <tr>
      <th>Idcontacto:</th>
      <td><?php echo $contacto->getIdcontacto() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $contacto->getNombre() ?></td>
    </tr>
    <tr>
      <th>Apellido:</th>
      <td><?php echo $contacto->getApellido() ?></td>
    </tr>
    <tr>
      <th>Empresa:</th>
      <td><?php echo $contacto->getEmpresa() ?></td>
    </tr>
    <tr>
      <th>Telefono:</th>
      <td><?php echo $contacto->getTelefono() ?></td>
    </tr>
    <tr>
      <th>Direccion:</th>
      <td><?php echo $contacto->getDireccion() ?></td>
    </tr>
    <tr>
      <th>Localidad:</th>
      <td><?php echo $contacto->getLocalidad() ?></td>
    </tr>
    <tr>
      <th>Pais:</th>
      <td><?php echo $contacto->getPais() ?></td>
    </tr>
    <tr>
      <th>Email:</th>
      <td><?php echo $contacto->getEmail() ?></td>
    </tr>
    <tr>
      <th>Comentario:</th>
      <td><?php echo $contacto->getComentario() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $contacto->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $contacto->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Created by:</th>
      <td><?php echo $contacto->getCreatedBy() ?></td>
    </tr>
    <tr>
      <th>Updated by:</th>
      <td><?php echo $contacto->getUpdatedBy() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('contacto/edit?idcontacto='.$contacto->getIdcontacto()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('contacto/index') ?>">List</a>
