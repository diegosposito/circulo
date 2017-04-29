<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $atenciones->getId() ?></td>
    </tr>
    <tr>
      <th>Nrodoc:</th>
      <td><?php echo $atenciones->getNrodoc() ?></td>
    </tr>
    <tr>
      <th>Mes:</th>
      <td><?php echo $atenciones->getMes() ?></td>
    </tr>
    <tr>
      <th>Anio:</th>
      <td><?php echo $atenciones->getAnio() ?></td>
    </tr>
    <tr>
      <th>Idobrasocial:</th>
      <td><?php echo $atenciones->getIdobrasocial() ?></td>
    </tr>
    <tr>
      <th>Idtratamiento:</th>
      <td><?php echo $atenciones->getIdtratamiento() ?></td>
    </tr>
    <tr>
      <th>Matricula:</th>
      <td><?php echo $atenciones->getMatricula() ?></td>
    </tr>
    <tr>
      <th>Fecha:</th>
      <td><?php echo $atenciones->getFecha() ?></td>
    </tr>
    <tr>
      <th>Pieza:</th>
      <td><?php echo $atenciones->getPieza() ?></td>
    </tr>
    <tr>
      <th>Caras:</th>
      <td><?php echo $atenciones->getCaras() ?></td>
    </tr>
    <tr>
      <th>Tratamiento:</th>
      <td><?php echo $atenciones->getTratamiento() ?></td>
    </tr>
    <tr>
      <th>Importe:</th>
      <td><?php echo $atenciones->getImporte() ?></td>
    </tr>
    <tr>
      <th>Coseguro:</th>
      <td><?php echo $atenciones->getCoseguro() ?></td>
    </tr>
    <tr>
      <th>Bono:</th>
      <td><?php echo $atenciones->getBono() ?></td>
    </tr>
    <tr>
      <th>Importeos:</th>
      <td><?php echo $atenciones->getImporteos() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $atenciones->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $atenciones->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Created by:</th>
      <td><?php echo $atenciones->getCreatedBy() ?></td>
    </tr>
    <tr>
      <th>Updated by:</th>
      <td><?php echo $atenciones->getUpdatedBy() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('atenciones/edit?id='.$atenciones->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('atenciones/index') ?>">List</a>
