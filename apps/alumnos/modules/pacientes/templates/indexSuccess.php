<h1>Pacientess List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Nombre</th>
      <th>Apellido</th>
      <th>Idsexo</th>
      <th>Nrodoc</th>
      <th>Fechanac</th>
      <th>Fechaingreso</th>
      <th>Idciudadnac</th>
      <th>Estadocivil</th>
      <th>Email</th>
      <th>Celular</th>
      <th>Telefono</th>
      <th>Direccion</th>
      <th>Titular</th>
      <th>Parentesco</th>
      <th>Ocupacion</th>
      <th>Siglas</th>
      <th>Plan</th>
      <th>Trabajo</th>
      <th>Jerarquia</th>
      <th>Credencial</th>
      <th>Anotaciones</th>
      <th>Activo</th>
      <th>Nroafiliado</th>
      <th>Historial</th>
      <th>Imagefile</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Created by</th>
      <th>Updated by</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pacientess as $pacientes): ?>
    <tr>
      <td><a href="<?php echo url_for('pacientes/show?id='.$pacientes->getId()) ?>"><?php echo $pacientes->getId() ?></a></td>
      <td><?php echo $pacientes->getNombre() ?></td>
      <td><?php echo $pacientes->getApellido() ?></td>
      <td><?php echo $pacientes->getIdsexo() ?></td>
      <td><?php echo $pacientes->getNrodoc() ?></td>
      <td><?php echo $pacientes->getFechanac() ?></td>
      <td><?php echo $pacientes->getFechaingreso() ?></td>
      <td><?php echo $pacientes->getIdciudadnac() ?></td>
      <td><?php echo $pacientes->getEstadocivil() ?></td>
      <td><?php echo $pacientes->getEmail() ?></td>
      <td><?php echo $pacientes->getCelular() ?></td>
      <td><?php echo $pacientes->getTelefono() ?></td>
      <td><?php echo $pacientes->getDireccion() ?></td>
      <td><?php echo $pacientes->getTitular() ?></td>
      <td><?php echo $pacientes->getParentesco() ?></td>
      <td><?php echo $pacientes->getOcupacion() ?></td>
      <td><?php echo $pacientes->getSiglas() ?></td>
      <td><?php echo $pacientes->getPlan() ?></td>
      <td><?php echo $pacientes->getTrabajo() ?></td>
      <td><?php echo $pacientes->getJerarquia() ?></td>
      <td><?php echo $pacientes->getCredencial() ?></td>
      <td><?php echo $pacientes->getAnotaciones() ?></td>
      <td><?php echo $pacientes->getActivo() ?></td>
      <td><?php echo $pacientes->getNroafiliado() ?></td>
      <td><?php echo $pacientes->getHistorial() ?></td>
      <td><?php echo $pacientes->getImagefile() ?></td>
      <td><?php echo $pacientes->getCreatedAt() ?></td>
      <td><?php echo $pacientes->getUpdatedAt() ?></td>
      <td><?php echo $pacientes->getCreatedBy() ?></td>
      <td><?php echo $pacientes->getUpdatedBy() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('pacientes/new') ?>">New</a>
