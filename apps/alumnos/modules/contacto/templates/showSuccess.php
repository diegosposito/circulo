<br>
<table>
  <tbody>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $contacto->getNombre() ?></td>
    </tr>
    <tr>
      <th>Apellido:</th>
      <td><?php echo $contacto->getApellido() ?></td>
    </tr>
    <tr>
      <th>Empresa o Profesional:</th>
      <td><?php echo $contacto->getEmpresa() ?></td>
    </tr>
    <tr>
      <th>Teléfono:</th>
      <td><?php echo $contacto->getTelefono() ?></td>
    </tr>
    <tr>
      <th>Dirección:</th>
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
  </tbody>
</table>