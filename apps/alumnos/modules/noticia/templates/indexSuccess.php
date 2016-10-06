<h1>Noticias List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Titulo</th>
      <th>Copete</th>
      <th>Idtiponoticia</th>
      <th>Visible</th>
      <th>Idorden</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($noticias as $noticia): ?>
    <tr>
      <td><a href="<?php echo url_for('noticia/show?id='.$noticia->getId()) ?>"><?php echo $noticia->getId() ?></a></td>
      <td><?php echo $noticia->getTitulo() ?></td>
      <td><?php echo $noticia->getCopete() ?></td>
      <td><?php echo $noticia->getIdtiponoticia() =='1' ? 'General' : 'De Profesionales' ?></td>
      <td><?php echo $noticia->getVisible() ? 'Visible' : 'No Visible' ?></td>
      <td><?php echo $noticia->getIdorden() ?></td>
      <td><a href="<?php echo url_for('noticia/edit?id='.$noticia->getId()) ?>"><?php echo 'Editar' ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('noticia/new') ?>">Nueva noticia</a>
