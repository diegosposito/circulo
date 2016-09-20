 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <br>
<h1 align="center" style="color:black;">Profesionales Asociados</h1>

 <a href="<?php echo url_for('informes/profesionalespdf') ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/printer.png' align='center' size='20' /></a>
<table cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="5%" align="center" class="hed">Matrícula</td>
        <td width="30%" align="center" class="hed">Nombre</td>
        <td width="20%" align="center" class="hed">Dirección</td>
        <td width="10%" align="center" class="hed">Teléfono</td>
        <td width="35%" align="center" class="hed">Ciudad</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($profesionaless as $profesionales){ ?>
      <tr class="fila_<?php echo $i%2 ; ?>">
        <td width="5%" align="left"><?php echo $profesionales->getNrolector() ?></td>
        <td width="30%" align="left"><a href="#" title="<?php echo $profesionales->getHorarios() ?>"> <?php echo $profesionales->getApellido().', '.$profesionales->getNombre() ?> </a></td>
        <td width="20%" align="left"><?php echo $profesionales->getDireccion()  ?></td>
        <td width="10%" align="left"><?php echo $profesionales->getMostrarinfocelular() ? $profesionales->getCelular() : ' - '  ?></td>
        <td width="35%" align="left"><?php echo $profesionales->getCiudad() ?></td>
      </tr>
      <?php $i++; ?>
      <?php } ?>

      <br>
  
    </tbody>
  </table>