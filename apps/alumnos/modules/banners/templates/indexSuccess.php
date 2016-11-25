 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <br>
<h1 align="center" style="color:black;">Listado de Banners</h1>
<script>

  function deleteFile(parametro){
     $.post("<?php echo url_for('banners/deletefile'); ?>",
          {id: parametro},
        function(data){
        $('#mensajeInfo').html("<p style='color:green;font-weight: bold;' align='center' >Banner eliminado correctamente. Actualice página para ver estado actual</p><br>");
        }
      );
      return false;
  } 
         
</script>
<br>
<?php if($sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
         <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
         <a href="<?php echo url_for('banners/new') ?>">Nuevo Banner</a>
  <?php } ?>

<br>
<div align="center">
 <a href="<?php echo url_for('banners/index') ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/refresh.png' align='center' size='20' height='28' width="28" /></a>  
</div>
<table width="550px" cellspacing="0" class="stats">
    <thead>
      <tr>
        <td width="60%" align="center" class="hed">Archivo</td>
        <td width="10%" align="center" class="hed">Ver</td>
        <td width="10%" align="center" class="hed">Visible</td>
        <?php if ($sf_user->getGuardUser()->getIsSuperAdmin()) { ?>
            <td width="20%" align="center" class="hed">Editar</td>
        <?php } ?>
        <?php if ($sf_user->getGuardUser()->getIsSuperAdmin()) { ?>
            <td width="20%" align="center" class="hed">Eliminar</td>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; ?>
      <?php foreach ($ficheros as $fichero){ ?>
                <tr class="fila_<?php echo $i%2 ; ?>">
                  <td width="60%" align="left"><?php echo $fichero[0] ?></td>
                  <td width="10%" align="center"> <a target="_blank" href="<?php echo $sf_request->getRelativeUrlRoot();?>/archivosprofesionales/<?php echo $fichero[1] ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/<?php echo $fichero[2] ?>' align='center' size='24' height='20' width="20" /></a></td>
                  <td width="20%" align="center">
                  
                  <?php if($fichero[4]){ ?>
                        <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/accept_ico.png' align='center' size='20'  height='20' width="20"  />
                  </td>
                  <?php } else { ?>
                        <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/wrong_ico.png' align='center' size='20'  height='20' width="20"  />
                  <?php } ?>
                  
                  <?php if ($sf_user->getGuardUser()->getIsSuperAdmin()) { ?>
                      <td width="20%" align="center"> <a href="<?php echo url_for('banners/edit?id='.$fichero[3]) ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/edit.png' align='center' size='20'  height='20' width="20"  /></a></td>
                  <?php } ?> 
                  <?php if ($sf_user->getGuardUser()->getIsSuperAdmin()) { ?>
                      <td width="20%" align="center"> <a onclick='deleteFile("<?php echo $fichero[3];?>")'><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/delete.png' align='center' size='24' height='20' width="20" /></a></td>
                  <?php } ?>                
                 </tr>
                 <?php $i++; ?>
       <?php  } ?>           
     
      <br>
  
    </tbody>
  </table>