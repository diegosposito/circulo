<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $pacientes->getId() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $pacientes->getNombre() ?></td>
    </tr>
    <tr>
      <th>Apellido:</th>
      <td><?php echo $pacientes->getApellido() ?></td>
    </tr>
    <tr>
      <th>Idsexo:</th>
      <td><?php echo $pacientes->getIdsexo() ?></td>
    </tr>
    <tr>
      <th>Nrodoc:</th>
      <td><?php echo $pacientes->getNrodoc() ?></td>
    </tr>
    <tr>
      <th>Fechanac:</th>
      <td><?php echo $pacientes->getFechanac() ?></td>
    </tr>
    <tr>
      <th>Fechaingreso:</th>
      <td><?php echo $pacientes->getFechaingreso() ?></td>
    </tr>
    <tr>
      <th>Idciudadnac:</th>
      <td><?php echo $pacientes->getIdciudadnac() ?></td>
    </tr>
    <tr>
      <th>Estadocivil:</th>
      <td><?php echo $pacientes->getEstadocivil() ?></td>
    </tr>
    <tr>
      <th>Email:</th>
      <td><?php echo $pacientes->getEmail() ?></td>
    </tr>
    <tr>
      <th>Celular:</th>
      <td><?php echo $pacientes->getCelular() ?></td>
    </tr>
    <tr>
      <th>Telefono:</th>
      <td><?php echo $pacientes->getTelefono() ?></td>
    </tr>
    <tr>
      <th>Direccion:</th>
      <td><?php echo $pacientes->getDireccion() ?></td>
    </tr>
    <tr>
      <th>Titular:</th>
      <td><?php echo $pacientes->getTitular() ?></td>
    </tr>
    <tr>
      <th>Parentesco:</th>
      <td><?php echo $pacientes->getParentesco() ?></td>
    </tr>
    <tr>
      <th>Ocupacion:</th>
      <td><?php echo $pacientes->getOcupacion() ?></td>
    </tr>
    <tr>
      <th>Siglas:</th>
      <td><?php echo $pacientes->getSiglas() ?></td>
    </tr>
    <tr>
      <th>Plan:</th>
      <td><?php echo $pacientes->getPlan() ?></td>
    </tr>
    <tr>
      <th>Trabajo:</th>
      <td><?php echo $pacientes->getTrabajo() ?></td>
    </tr>
    <tr>
      <th>Jerarquia:</th>
      <td><?php echo $pacientes->getJerarquia() ?></td>
    </tr>
    <tr>
      <th>Credencial:</th>
      <td><?php echo $pacientes->getCredencial() ?></td>
    </tr>
    <tr>
      <th>Anotaciones:</th>
      <td><?php echo $pacientes->getAnotaciones() ?></td>
    </tr>
    <tr>
      <th>Activo:</th>
      <td><?php echo $pacientes->getActivo() ?></td>
    </tr>
    <tr>
      <th>Nroafiliado:</th>
      <td><?php echo $pacientes->getNroafiliado() ?></td>
    </tr>
    <tr>
      <th>Historial:</th>
      <td><?php echo $pacientes->getHistorial() ?></td>
    </tr>
    <tr>
      <th>Imagefile:</th>
      <td><?php echo $pacientes->getImagefile() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $pacientes->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $pacientes->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Created by:</th>
      <td><?php echo $pacientes->getCreatedBy() ?></td>
    </tr>
    <tr>
      <th>Updated by:</th>
      <td><?php echo $pacientes->getUpdatedBy() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('pacientes/edit?id='.$pacientes->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('pacientes/index') ?>">List</a>
