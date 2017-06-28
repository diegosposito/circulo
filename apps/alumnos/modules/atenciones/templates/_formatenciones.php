<style type="text/css">
  p { margin-left:5em; /* Or another measurement unit, like px */ }
  a.tooltip {outline:none; }

  a.tooltip strong {line-height:30px;}
  a.tooltip:hover {text-decoration:none;}
  a.tooltip span {
      z-index:10;display:none; padding:14px 20px;
      margin-top:-30px; margin-left:28px;
      width:315px; line-height:16px;
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
<style type="text/css">
  p { margin-left:5em; /* Or another measurement unit, like px */ }
</style>
<h1 align="center" style="color:black;">Historial de atenciones</h1>
<br>
<?php //if($sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
       <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
       <a href="<?php echo url_for('atenciones/new?idpaciente='.$paciente->getId()) ?>">Registrar Nueva Atención</a>
<?php // } ?>
<div align="center">
<!--<form action="<?php echo url_for('atenciones/editar?id='.$paciente->getId()) ?>" method="post">
  <input type="hidden" name="selectedtab" id="selectedtab" value="<?php echo $selectedtab ?>">
<table cellspacing="0" class="stats" width="80%">
<tr>
<td><b>Apellido:</b></td>
<td align="left"><INPUT type="text" id="idbuscarname" name="idbuscarname" size="30" value="<?php echo  $criterio  ?>"></td>
</tr>
<tr>
<?php $tipobusqueda = array(1 => 'Apellido', 2 => 'D.N.I.'); ?>
<td><b>Tipo búsqueda:</b></td>
<td align="left">
  <SELECT name="idtipobusqueda" id="idtipobusqueda">
  <?php if (count($tipobusqueda) > 0) {
    //el bucle para cargar las opciones
    echo "<option value='0' selected='selected' >----SELECCIONAR----</option>";
    foreach ($tipobusqueda as $k => $v){
      if($k==$idtipobusqueda){
          echo "<option value=".$k ." selected='selected'>".$v."</option>";
      } else {
          echo "<option value=".$k .">".$v."</option>";
      }
    }
  } ?>
  </SELECT>
</td>
</tr>

<tr>
<td colspan="2" align="center"><input type="submit" value="Buscar" /></td>
</tr>
</table>
</form>  -->

<?php if (count($atencioness) > 0){ ?>
<table cellspacing="0" class="stats">
    <tr>
      <td colspan="6" width="100%">Se han encontrado <?php echo count($atencioness); ?> coincidencias de la búsqueda.</td>
    </tr>
    <tr>
      <td width="10%" align="center" class="hed">Matricula</td>
      <td width="10%" align="center" class="hed">Mes</td>
      <td width="10%" align="center" class="hed">Año</td>
      <td width="20%" align="center" class="hed">Fecha</td>
      <td width="25%" align="center" class="hed">Tratamiento</td>
      <td width="15%" align="center" class="hed">Importe</td>
      <td colspan="2" width="20%" align="center" class="hed">Edicion</td>
    </tr>
  </thead>
  <tbody>
          <?php $i=0; ?>
    <?php foreach($atencioness as $item){
      $fecha_formateada = date("d/m/Y", strtotime($item['fecha'])); ?>
    <tr class="fila_<?php echo $i%2 ; ?>">
      <?php if ($item['idprofesional']==$idprofesional || $superadmin) { ?>
        <td width="10%" align="center"><?php echo $item['matricula'] ?></td>
      <?php } else { ?>
        <td width="10%" align="center"><?php echo '-' ?></td>
      <?php  } ?>
      <td width="10%" align="center"><?php echo $item['mesdetalle'] ?></td>
      <td width="10%" align="center"><?php echo $item['anio'] ?></td>
      <td width="20%" align="center"><?php echo $fecha_formateada ?></td>
      <td width="25%" align="center"><?php echo $item['tratamiento'] ?></td>
      <td width="15%" align="center"><?php echo $item['importe'] ?></td>
      <?php if (($item['idprofesional']==$idprofesional || $sf_user->getGuardUser()->getIsSuperAdmin()) && $item['idestadoatencion']==1) { ?>
        <td width="20%" align="center"> <a title="Editar registro" href="<?php echo url_for('atenciones/edit?id='.$item['id'].'&idpaciente='.$paciente->getId()) ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/edit.png' align='center' size='20'  height='20' width="20"  /></a></td>
      <?php } else { ?>
        <td width="20%" align="center"><?php echo '-' ?></td>
      <?php  } ?>
      <?php if (($item['idprofesional']==$idprofesional || $sf_user->getGuardUser()->getIsSuperAdmin()) && $item['idestadoatencion']==1) { ?>
        <td width="20%" align="center"> <a title="Eliminar registro" href="<?php echo url_for('atenciones/delete?id='.$item['id']) ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/delete.png' align='center' size='20'  height='20' width="20"  /></a></td>
      <?php } else { ?>
        <td width="20%" align="center"><?php echo '-' ?></td>
      <?php  } ?>


    </tr>
          <?php $i++; ?>
    <?php } ?>

   <br>
  </tbody>
</table>
<br>
<?php } ?>
</div>
