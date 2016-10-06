<h1>Noticias List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Titulo</th>
      <th>Descripcion</th>
      <th>Copete</th>
      <th>Idtiponoticia</th>
      <th>Visible</th>
      <th>Idorden</th>
      <th>Imagefile</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Created by</th>
      <th>Updated by</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($noticias as $noticia): ?>
    <tr>
      <td><a href="<?php echo url_for('noticia/show?id='.$noticia->getId()) ?>"><?php echo $noticia->getId() ?></a></td>
      <td><?php echo $noticia->getTitulo() ?></td>
      <td><?php echo $noticia->getDescripcion() ?></td>
      <td><?php echo $noticia->getCopete() ?></td>
      <td><?php echo $noticia->getIdtiponoticia() ?></td>
      <td><?php echo $noticia->getVisible() ?></td>
      <td><?php echo $noticia->getIdorden() ?></td>
      <td><?php echo $noticia->getImagefile() ?></td>
      <td><?php echo $noticia->getCreatedAt() ?></td>
      <td><?php echo $noticia->getUpdatedAt() ?></td>
      <td><?php echo $noticia->getCreatedBy() ?></td>
      <td><?php echo $noticia->getUpdatedBy() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('noticia/new') ?>">New</a>
