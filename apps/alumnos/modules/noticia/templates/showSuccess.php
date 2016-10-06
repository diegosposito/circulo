<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $noticia->getId() ?></td>
    </tr>
    <tr>
      <th>Titulo:</th>
      <td><?php echo $noticia->getTitulo() ?></td>
    </tr>
    <tr>
      <th>Descripción:</th>
      <td><?php echo $noticia->getDescripcion() ?></td>
    </tr>
    <tr>
      <th>Idtiponoticia:</th>
      <td><?php echo $noticia->getIdtiponoticia()=='1' ? 'General' : 'Profesional' ?></td>
    </tr>
    <tr>
      <th>Visible:</th>
      <td><?php echo $noticia->getVisible() ? 'Visible' : 'No Visible' ?></td>
    </tr>
    <tr>
      <th>Idorden:</th>
      <td><?php echo $noticia->getIdorden() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('noticia/edit?id='.$noticia->getId()) ?>">Editar</a>
&nbsp;
<a href="<?php echo url_for('noticia/index') ?>">Volver al listado</a>
