 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <br>
<h1 align="center" style="color:black;">Listado de Noticias</h1>
<?php if($sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
         <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
         <a href="<?php echo url_for('noticia/new') ?>">Nueva Noticia</a>
  <?php } ?>

 <br>
<table cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="40%" align="center" class="hed">Título</td>
        <td width="30%" align="center" class="hed">Copete</td>
        <td width="15%" align="center" class="hed">Tipo Noticia</td>
        <td width="5%" align="center" class="hed">Visible</td>
        <td width="5%" align="center" class="hed">Orden</td>
        <td colspan=2 width="5%" align="center" class="hed">Acciones</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($noticias as $noticia){ ?>
      <tr class="fila_<?php echo $i%2 ; ?>">
        <td width="40%" align="center"><?php echo $noticia->getTitulo() ?></td>
        <td width="30%"><?php echo $noticia->getCopete() ?></td>
        <td width="15%"><?php echo $noticia->getIdtiponoticia() =='1' ? 'General' : 'Profesionales' ?></td>
        <td width="15%"><?php echo $noticia->getVisible() ? 'Visible' : 'No Visible' ?></td>
        <td width="15%"><?php echo $noticia->getIdorden() ?></td>
        <td width="15%"><a href="<?php echo url_for('noticia/edit?id='.$noticia->getId()) ?>"><?php echo 'Editar' ?></a></td>
        <td align="center"><?php echo link_to('Eliminar', 'noticia/delete?id='.$noticia->getId(), array('method' => 'delete', 'confirm' => 'Estas seguro de borrar la noticia?')) ?>
      </tr>
      <?php $i++; ?>
      <?php } ?>

      <br>
  
    </tbody>
  </table>