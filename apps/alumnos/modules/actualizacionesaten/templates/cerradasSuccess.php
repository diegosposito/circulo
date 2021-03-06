 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <div id="mensajeInfo"></div>
<h1 align="center" style="color:black;">Archivos con Atenciones</h1>
<script>

  function deleteFile(parametro){
     $.post("<?php echo url_for('actualizacionesaten/deletefileperiodo'); ?>",
          {id: parametro},
        function(data){
        $('#mensajeInfo').html("<p style='color:green;font-weight: bold;' align='center' >Archivo eliminado correctamente. Actualice página para ver estado actual</p><br>");
        }
      );
      return false;
  }

  function procesarFile(parametro){
     $.post("<?php echo url_for('actualizacionesaten/procesarfileperiodo'); ?>",
          {id: parametro},
        function(data){
        $('#mensajeInfo').html("<p style='color:green;font-weight: bold;' align='center' >Archivo procesado correctamente. Actualice página para ver estado actual</p><br>");
        }
      );
      return false;
  }



    function ejecutarFile(parametro){
     $.post("<?php echo url_for('actualizacionesaten/ejecutarfileperiodo'); ?>",
          {id: parametro},
        function(data){
        $('#mensajeInfo').html("<p style='color:green;font-weight: bold;' align='center' >Archivo actualizado correctamente. Actualice página para ver estado actual</p><br>");
        }
      );
      return false;
  }

</script>
<br>
  <a href="<?php echo url_for('atenciones/revisarperiodos') ?>">Volver al Resumen de Períodos</a>
<br>
<br>
<?php if($sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
         <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
         <a href="<?php echo url_for('actualizacionesaten/newcerrada') ?>">Subir archivo con periodo a actualizar</a>
  <?php } ?>


<div align="center">
 <a href="<?php echo url_for('actualizacionesaten/cerradas') ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/refresh.png' align='center' size='20' height='28' width="28" /></a>
</div>
<table width="550px" cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="60%" align="center" class="hed">Archivo</td>
        <?php if ($sf_user->getGuardUser()->getIsSuperAdmin()) { ?>
            <td width="10%" align="center" class="hed">Procesar</td>
        <?php } ?>
         <?php if ($sf_user->getGuardUser()->getIsSuperAdmin()) { ?>
            <td width="10%" align="center" class="hed">Ejecutar</td>
        <?php } ?>
        <?php if ($sf_user->getGuardUser()->getIsSuperAdmin()) { ?>
            <td width="10%" align="center" class="hed">Eliminar</td>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($ficheros as $fichero){ ?>
                <tr class="fila_<?php echo $i%2 ; ?>">
                  <td width="60%" align="left"><?php echo $fichero[0] ?></td>
                  <?php if ($sf_user->getGuardUser()->getIsSuperAdmin()) { ?>
                      <td width="20%" align="center"> <a onclick='procesarFile("<?php echo $fichero[0];?>")'><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/procesar.png' align='center' size='24' height='20' width="20" /></a></td>
                  <?php } ?>
                   <?php if ($sf_user->getGuardUser()->getIsSuperAdmin()) { ?>
                      <td width="20%" align="center"> <a onclick='ejecutarFile("<?php echo $fichero[0];?>")'><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/play.png' align='center' size='24' height='20' width="20" /></a></td>
                  <?php } ?>
                   <?php if ($sf_user->getGuardUser()->getIsSuperAdmin()) { ?>
                      <td width="20%" align="center"> <a onclick='deleteFile("<?php echo $fichero[0];?>")'><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/delete.png' align='center' size='24' height='20' width="20" /></a></td>
                  <?php } ?>
                 </tr>
                 <?php $i++; ?>
       <?php  } ?>

      <br>

    </tbody>
  </table>
