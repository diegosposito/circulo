 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
    a.tooltip {outline:none; }

    a.tooltip strong {line-height:30px;}
    a.tooltip:hover {text-decoration:none;} 
    a.tooltip span {
        z-index:10;display:none; padding:14px 20px;
        margin-top:-30px; margin-left:28px;
        width:300px; line-height:16px;
    }
    a.tooltip:hover span{
        display:inline; position:absolute; color:#111;
        border:1px solid #DCA; background:#fffAF0;}
    .callout {z-index:20;position:absolute;top:30px;border:0;left:-12px;}
        
    /*CSS3 extras*/
    a.tooltip span
    {
        border-radius:4px;
        box-shadow: 5px 5px 8px #CCC;
    }
  </style>
  <br>
<h1 align="center" style="color:#7dbf0d;font-size:24px;">Profesionales Asociados</h1>

 <a target="_blank" href="<?php echo url_for('informes/profesionalespdf') ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/printer.png' align='center' size='20' /></a>
<table cellspacing="0" class="stats">
    <tbody>
      <?php $i=0; $ciudad='NULL';?>
      <?php foreach ($profesionaless as $profesionales){ ?>
        
        <?php if (trim($ciudad) <> trim($profesionales->getCiudad())) { ?>
                 <tr bgcolor="#7DBF0D"><td colspan=6><p style="text-align:left;color: #FFFFFF;font-weight:bold;font-size:12px"><?php echo $profesionales->getCiudad() ?></p></td></tr>
                 <tr>
                  <td width="5%" align="center" class="hed">Matrícula</td>
                  <td width="30%" align="center" class="hed">Nombre</td>
                  <td width="20%" align="center" class="hed">Dirección</td>
                  <td width="10%" align="center" class="hed">Teléfono</td>
                  <td width="10%" align="center" class="hed">Móvil</td>
                  <td width="25%" align="center" class="hed">Email</td>
                </tr>
                <?php $ciudad = $profesionales->getCiudad();
              } 
        ?>

      <tr class="fila_<?php echo $i%2 ; ?>">
        <td width="5%" align="left"><?php echo $profesionales->getNrolector() ?></td>
        
        <?php if (trim($profesionales->getImagefile())<>''){ ?>
                 
                   <td width="30%" align="left"><a href="#" class="tooltip"><div style="align: left;"><?php echo $profesionales->getApellido().', '.$profesionales->getNombre() ?><span><img style="align:center; width: 110px; height: 110px;" src='<?php echo $sf_request->getRelativeUrlRoot();?>/files/profesionales/<?php echo $profesionales->getIdpersona();?>/<?php echo $profesionales->getImagefile();?>' /><br><strong><?php echo $profesionales->getApellido().', '.$profesionales->getNombre() ?></strong><br><strong><?php echo "Horarios" ?></strong><br>
                   <?php echo htmlspecialchars_decode($profesionales->getHorarios()) ?></span></div"></a></td>

        <?php } else { ?>
                   <td width="30%" align="left"><a href="#" class="tooltip"><div style="align: left;"><?php echo $profesionales->getApellido().', '.$profesionales->getNombre() ?><span><br><strong><?php echo $profesionales->getApellido().', '.$profesionales->getNombre() ?></strong><br><strong><?php echo "Horarios" ?></strong><br><?php echo htmlspecialchars_decode($profesionales->getHorarios()) ?></span></div></a></td>
        <?php } ?>
        
        <td width="20%" align="left"><?php echo $profesionales->getDireccion()  ?></td>
        <td width="10%" align="left"><?php echo $profesionales->getTelefono()  ?></td>
        <td width="10%" align="left"><?php echo $profesionales->getMostrarinfocelular() ? $profesionales->getCelular() : ' - '  ?></td>
         <td width="25%" align="left"><?php echo $profesionales->getMostrarinfoemail() ? $profesionales->getEmail() : ' - ' ?></td>
      </tr>
      <?php $i++; ?>
      <?php } ?>

      <br>
  
    </tbody>
  </table>
   <br> <br> <br> <br>