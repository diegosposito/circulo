<h1>Modificar de Datos Personales de Alumnos</h1>

<script>

  function deleteFile(parametro){
     $.post("<?php echo url_for('obrassociales/deletefile'); ?>",
          {nombrearchivo: parametro},
        function(data){
        $('#mensajeInfo').html("<p style='color:green;font-weight: bold;' align='center' >Archivo eliminado correctamente. Actualice página para ver estado actual</p><br>");
        }
      );
      return false;
  }

</script>

<div id="mensajeInfo"></div>

<form action="<?php echo url_for('obrassociales/mostrar') ?>"  enctype="multipart/form-data" method="post" ?>
<?php if ($sf_user->getGuardUser()->getIsSuperAdmin()) { ?>
  <div>
        <label for='upload'><b>Agregar archivos:</b></label>
        <input id='upload' name="upload[]" type="file" multiple="multiple" />
  </div>
  <?php } ?>
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

<?php if ($sf_user->getGuardUser()->getIsSuperAdmin()) { ?>
<input type="submit" value="Actualizar archivos" id="botonGenerar"/>
<?php } ?>

</form>

<table width="550px" cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="60%" align="center" class="hed">Archivo</td>
        <td width="20%" align="center" class="hed">Ver</td>
        <?php if ($sf_user->getGuardUser()->getIsSuperAdmin()) { ?>
            <td width="20%" align="center" class="hed">Eliminar</td>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($ficheros as $fichero){  ?>
                <tr class="fila_<?php echo $i%2 ; ?>">
                  <td width="60%" align="center"><?php echo $fichero[0] ?></td>
                  <td width="20%" align="center"> <a target="_blank" href="<?php echo $sf_request->getRelativeUrlRoot();?>/files/<?php echo $fichero[1] ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/<?php echo $fichero[2] ?>' align='center' size='24' height='24' width="24" /></a></td>
                  <?php if ($sf_user->getGuardUser()->getIsSuperAdmin()) { ?>
                      <td width="20%" align="center"> <a onclick='deleteFile("<?php echo $fichero[1];?>")'><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/delete.png' align='center' size='24' height='24' width="24" /></a></td>
                  <?php } ?>
                 </tr>
      <?php } ?>

      <br>

    </tbody>
  </table>
