 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <br>
<h1 align="center" style="color:black;">Listado de Obras Sociales</h1>

 <a target="_blank" href="<?php echo url_for('informes/obrassocialespdf') ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/printer.png' align='center' size='20' /></a>
<table cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="32%" align="center" class="hed">Obra Social</td>
        <td width="4%" align="center" class="hed">Abrev.</td>
        <td width="13%" align="center" class="hed">General</td>
        <td width="13%" align="center" class="hed">Prótesis</td>
        <td width="14%" align="center" class="hed">Ortodoncia</td>
        <td width="13%" align="center" class="hed">Implantes</td>
        <td width="11%" align="center" class="hed">Archivos</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($obras_socialess as $obras_sociales){ ?>
      <tr class="fila_<?php echo $i%2 ; ?>">
        <td width="32%" align="center"><?php echo $obras_sociales->getDenominacion() ?></td>
        <td width="4%"><?php echo $obras_sociales->getAbreviada() ?></td>
        <td width="13%"><?php echo $obras_sociales->getGeneral() ? 'Habilitada' : 'No Habilitada'; ?></td>
        <td width="13%"><?php echo $obras_sociales->getProtesis() ? 'Habilitada' : 'No Habilitada'; ?></td>
        <td width="14%"><?php echo $obras_sociales->getOrtodoncia() ? 'Habilitada' : 'No Habilitada'; ?></td>
         <td width="13%"><?php echo $obras_sociales->getImplantes() ? 'Habilitada' : 'No Habilitada'; ?></td>
        <td align="center"><?php echo link_to("Visualizar", 'informes/mostrararchivos?idobrasocial='.$obras_sociales->getIdobrasocial() ,'class="mhead"'); ?></td>
      </tr>
      <?php $i++; ?>
      <?php } ?>

      <br>
  
    </tbody>
  </table>