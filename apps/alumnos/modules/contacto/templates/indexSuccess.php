<h1>Contactos List</h1>

<table>
  <thead>
    <tr>
      <th>Idcontacto</th>
      <th>Nombre</th>
      <th>Apellido</th>
      <th>Empresa</th>
      <th>Telefono</th>
      <th>Direccion</th>
      <th>Localidad</th>
      <th>Pais</th>
      <th>Email</th>
      <th>Comentario</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Created by</th>
      <th>Updated by</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($contactos as $contacto): ?>
    <tr>
      <td><a href="<?php echo url_for('contacto/show?idcontacto='.$contacto->getIdcontacto()) ?>"><?php echo $contacto->getIdcontacto() ?></a></td>
      <td><?php echo $contacto->getNombre() ?></td>
      <td><?php echo $contacto->getApellido() ?></td>
      <td><?php echo $contacto->getEmpresa() ?></td>
      <td><?php echo $contacto->getTelefono() ?></td>
      <td><?php echo $contacto->getDireccion() ?></td>
      <td><?php echo $contacto->getLocalidad() ?></td>
      <td><?php echo $contacto->getPais() ?></td>
      <td><?php echo $contacto->getEmail() ?></td>
      <td><?php echo $contacto->getComentario() ?></td>
      <td><?php echo $contacto->getCreatedAt() ?></td>
      <td><?php echo $contacto->getUpdatedAt() ?></td>
      <td><?php echo $contacto->getCreatedBy() ?></td>
      <td><?php echo $contacto->getUpdatedBy() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('contacto/new') ?>">New</a>
