<h1>Gestión de Archivos de la Obra Social</h1>

<div id="mensajeInfo"></div>

<form action="<?php echo url_for('informes/mostrararchivos') ?>"  enctype="multipart/form-data" method="post" ?>
 <input type="hidden" name="idobrasocial" value="<?php echo $obras_sociales->getIdObrasocial(); ?>">   
<table>
  <tbody>
    <tr>
      <th>Denominacion:</th>
      <td><?php echo $obras_sociales->getDenominacion() ?></td>
    </tr>
    <tr>
      <th>Abreviada:</th>
      <td><?php echo $obras_sociales->getAbreviada() ?></td>
    </tr>
    <tr>
      <th>Estado:</th>
      <td><?php echo ($obras_sociales->getEstado()==1) ? 'Habilitada' : 'No Habilitada'; ?></td>
    </tr>
    <tr>
      <th>Fecha Arancel:</th>
      <td><?php echo date("d/m/Y", strtotime($obras_sociales->getFechaarancel())) ?></td>
    </tr>
    <tr>
      <th>Fecha Ultimo Periodo:</th>
      <td><?php echo date("d/m/Y", strtotime($obras_sociales->getFechaultimoperiodo())) ?></td>
    </tr>
    <tr>
      <th>Fecha Alta:</th>
      <td><?php echo date("d/m/Y", strtotime($obras_sociales->getCreatedAt())) ?></td>
    </tr>
    <tr>
      <th>Fecha Ultima Modificación:</th>
      <td><?php echo date("d/m/Y", strtotime($obras_sociales->getUpdatedAt())) ?></td>
    </tr>
   </tbody>
</table>

<br>
<hr />
<br>

</form>

<table width="550px" cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="60%" align="center" class="hed">Archivo</td>
        <td width="20%" align="center" class="hed">Ver</td>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($ficheros as $fichero){ 
              if ($i>1){ ?>
                <tr class="fila_<?php echo $i%2 ; ?>">
                  <td width="60%" align="center"><?php echo $fichero[0] ?></td>
                  <td width="20%" align="center"> <a target="_blank" href="<?php echo $sf_request->getRelativeUrlRoot();?>/files/<?php echo $fichero[1] ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/<?php echo $fichero[2] ?>' align='center' size='24' height='24' width="24" /></a></td>
                 </tr>
       <?php  } ?>           
      <?php $i++; ?>
      <?php } ?>

      <br>
  
    </tbody>
  </table>
