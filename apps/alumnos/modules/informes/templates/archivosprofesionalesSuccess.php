 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <br>
<h1 align="center" style="color:black;">Documentación para Profesionales</h1>
<table width="550px" cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="80%" align="center" class="hed">Archivo</td>
        <td width="20%" align="center" class="hed">Ver</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($ficheros as $fichero){ ?>
                <tr class="fila_<?php echo $i%2 ; ?>">
                  <td width="60%" align="left"><?php echo $fichero[0] ?></td>
                  <td width="20%" align="center"> <a target="_blank" href="<?php echo $sf_request->getRelativeUrlRoot();?>/archivosprofesionales/<?php echo $fichero[1] ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/<?php echo $fichero[2] ?>' align='center' size='24' height='24' width="24" /></a></td>
                 </tr>
                 <?php $i++; ?>
       <?php  } ?>           
     
      <br>
  
    </tbody>
  </table>