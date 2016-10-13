 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <br>
<h1 align="center" style="color:black;">Eventos de Contacto</h1>
<table width=100% cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="35%" align="center" class="hed">Persona</td>
        <td width="30%" align="center" class="hed">Empresa</td>
        <td width="10%" align="center" class="hed">Telefono</td>
        <td width="20%" align="center" class="hed">Email</td>
        <td width="5%" align="center" class="hed">Ver</td>
        <td width="5%" align="center" class="hed">Eliminar</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($contactos as $contacto){ ?>
      <tr class="fila_<?php echo $i%2 ; ?>">
        <td width="35%" align="left"><a href="#" title="<?php echo $contacto->getComentario() ?>"> <?php echo $contacto->getApellido().", ".$contacto->getNombre() ?> </a></td>
        <td width="30%"><?php echo $contacto->getEmpresa() ?></td>
        <td width="10%"><?php echo $contacto->getTelefono() ?></td>
        <td width="20%"><?php echo $contacto->getEmail() ?></td>
        <td align="center"><?php echo link_to("Ver", 'contacto/show?idcontacto='.$contacto->getIdcontacto() ,'class="mhead"'); ?></td>
        <td align="center"><?php echo link_to('Eliminar', 'contacto/delete?idcontacto='.$contacto->getIdcontacto(), array('method' => 'delete', 'confirm' => 'Estas seguro de eliminar el comentario?')) ?></td>
      </tr>
      <?php $i++; ?>
      <?php } ?>

      <br>
  
    </tbody>
  </table>

  