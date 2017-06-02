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
<br>
<h1 align="center" style="color:black;">Cerrar Período</h1>
<br>
<div align="center">
<!-- <form action="<?php echo url_for('atenciones/cerrar') ?>" method="post">
<table cellspacing="0" class="stats" width="80%">
<tr>
<td><b>Año:</b></td>
<td align="left">
  <SELECT name="idAnio" id="idAnio">
  <?php
    //el bucle para cargar las opciones
    foreach ($aAnios as $k => $v){
      if($k==$idAnio){
          echo "<option value=".$k ." selected='selected'>".$v."</option>";
      } else {
          echo "<option value=".$k .">".$v."</option>";
      }
    }
  ?>
  </SELECT>
</td>
</tr>
<tr>
<td><b>Mes:</b></td>
<td align="left">
  <SELECT name="idMes" id="idMes">
  <?php
    //el bucle para cargar las opciones
    foreach ($aMeses as $k => $v){
      if($k==$idMes){
          echo "<option value=".$k ." selected='selected'>".$v."</option>";
      } else {
          echo "<option value=".$k .">".$v."</option>";
      }
    }
  ?>
  </SELECT>
</td>
</tr>

<tr>
<td colspan="2" align="center"><input type="submit" value="Buscar" /></td>
</tr>
</table>
</form> -->

<form action="<?php echo url_for('atenciones/cerrarperiodo') ?>" method="post">
<input type="hidden" id="periodo" name="periodo" value="<?php echo $periodo; ?>">
<table cellspacing="0" class="stats" width="80%">
<?php if ($mostrar_boton_cerrar){ ?>
<tr>
<td colspan="2" align="center"><input type="submit" value="<?php echo "Cerrar Período ".$periodo; ?>" /></td>
</tr>
<?php }  else { ?>
<tr>
<td colspan="2" align="center"><b><?php echo "El Período actual no se encuentra habilitado aún para Cerrar"; ?></b></td>
</tr>
<?php }  ?>

</table>



<?php if (count($atencioness) > 0){ ?>
<table cellspacing="0" class="stats">
    <tr>
      <td colspan="6" width="100%">Por defecto todas las atenciones se cierran. <b>Marque las que no desee cerrar</b>.<br> Se han encontrado <?php echo count($atencioness); ?> coincidencias de la búsqueda.</td>
    </tr>
    <tr>
      <td width="2%" align="center" class="hed"></td>
      <td width="14%" align="center" class="hed">Obra Social</td>
      <td width="24%" align="center" class="hed">Paciente</td>
      <td width="10%" align="center" class="hed">Fecha</td>
      <td width="15%" align="center" class="hed">Tratamiento</td>
      <td width="10%" align="center" class="hed">Importe</td>
      <td width="10%" align="center" class="hed">Coseguro</td>
      <td width="15%" align="center" class="hed">Estado</td>
    </tr>
  </thead>
  <tbody>
          <?php $i=0; ?>
    <?php foreach($atencioness as $item){
      $fecha_formateada = date("d/m/Y", strtotime($item['fecha'])); ?>
    <tr class="fila_<?php echo $i%2 ; ?>">
      <td align="center"><input type="checkbox" id="idcase" class="idcase" name="idcase[]" value="<?php echo $item['id'] ?>" /></td>
      <td width="14%" align="center"><?php echo $item['obrasocial'] ?></td>
      <td width="24%" align="center"><?php echo $item['apellido'].', '.$item['nombre'] ?></td>
      <td width="10%" align="center"><?php echo $fecha_formateada ?></td>
      <td width="15%" align="center"><?php echo $item['tratamiento'] ?></td>
      <td width="10%" align="center"><?php echo $item['importe'] ?></td>
      <td width="10%" align="center"><?php echo $item['coseguro'] ?></td>
      <td width="15%" align="center"><?php echo $item['estadoatencion'] ?></td>
    </tr>
          <?php $i++; ?>
    <?php } ?>

   <br>
  </tbody>
</table>
</form>  
<br>
<?php } ?>
</div>
