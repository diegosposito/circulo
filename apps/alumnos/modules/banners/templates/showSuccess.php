<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $banners->getId() ?></td>
    </tr>
    <tr>
      <th>Nombre:</th>
      <td><?php echo $banners->getNombre() ?></td>
    </tr>
    <tr>
      <th>Url:</th>
      <td><?php echo $banners->getUrl() ?></td>
    </tr>
    <tr>
      <th>Visible:</th>
      <td><?php echo $banners->getVisible() ?></td>
    </tr>
    <tr>
      <th>Idorden:</th>
      <td><?php echo $banners->getIdorden() ?></td>
    </tr>
    <tr>
      <th>Imagefile:</th>
      <td><?php echo $banners->getImagefile() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $banners->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $banners->getUpdatedAt() ?></td>
    </tr>
    <tr>
      <th>Created by:</th>
      <td><?php echo $banners->getCreatedBy() ?></td>
    </tr>
    <tr>
      <th>Updated by:</th>
      <td><?php echo $banners->getUpdatedBy() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('banners/edit?id='.$banners->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('banners/index') ?>">List</a>
