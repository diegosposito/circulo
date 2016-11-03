 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <br>
<h1 align="center" style="color:#7dbf0d;font-size:24px;">Listado de Obras Sociales</h1>

 <a target="_blank" href="<?php echo url_for('informes/obrassocialespdf') ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/printer.png' align='center' size='20' /></a>
<table cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="70%" align="center" class="hed">Obra Social</td>
        <td width="5%" align="center" class="hed">Abrev.</td>
        <td width="5%" align="center" class="hed">General</td>
        <td width="5%" align="center" class="hed">Prótesis</td>
        <td width="5%" align="center" class="hed">Ortodoncia</td>
        <td width="5%" align="center" class="hed">Implantes</td>
        <td width="5%" align="center" class="hed">Archivos</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($obras_socialess as $obras_sociales){ ?>
      <tr class="fila_<?php echo $i%2 ; ?>">
        <td width="70%" align="center"><?php echo $obras_sociales->getDenominacion() ?></td>
        <td width="5%"><?php echo $obras_sociales->getAbreviada() ?></td>
        <td align='center' width="5%">
        <?php 
          if ($obras_sociales->getGeneral()){ ?>
            <img width="17px" height="17px" src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/accept_ico.png' align='center' size='20' />
          <?php } else { ?>
             <img width="14px" height="14px"  src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/wrong_ico.png' align='center' size='20' />
          <?php } ?> 
        </td>
        <td align='center' width="5%">
        <?php 
          if ($obras_sociales->getProtesis()){ ?>
            <img width="17px" height="17px" src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/accept_ico.png' align='center' size='20' />
          <?php } else { ?>
             <img width="14px" height="14px"  src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/wrong_ico.png' align='center' size='20' />
          <?php } ?> 
        </td>
        <td align='center' width="5%">
        <?php 
          if ($obras_sociales->getOrtodoncia()){ ?>
            <img width="17px" height="17px" src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/accept_ico.png' align='center' size='20' />
          <?php } else { ?>
             <img width="14px" height="14px"  src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/wrong_ico.png' align='center' size='20' />
          <?php } ?> 
        </td>
        <td align='center' width="5%">
        <?php 
          if ($obras_sociales->getImplantes()){ ?>
            <img width="17px" height="17px" src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/accept_ico.png' align='center' size='20' />
          <?php } else { ?>
             <img width="14px" height="14px"  src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/wrong_ico.png' align='center' size='20' />
          <?php } ?> 
        </td>
        <td align="center"><?php echo link_to("Visualizar", 'informes/mostrararchivos?idobrasocial='.$obras_sociales->getIdobrasocial() ,'class="mhead"'); ?></td>
      </tr>
      <?php $i++; ?>
      <?php } ?>

      <br>
  
    </tbody>
  </table>