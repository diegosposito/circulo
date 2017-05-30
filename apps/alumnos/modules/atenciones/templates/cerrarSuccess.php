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
<h1 align="center" style="color:black;">Atenciones Por Período / Cerrar Período</h1>
<br>
<div align="center">
<form action="<?php echo url_for('atenciones/cerrar') ?>" method="post">
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
</form>

<form action="<?php echo url_for('atenciones/cerrarperiodo') ?>" method="post">
<input type="hidden" id="idAnion" name="idAnion" value="<?php echo $idAnio; ?>">
<input type="hidden" id="idMesn" name="idMesn" value="<?php echo $idMes; ?>">
<table cellspacing="0" class="stats" width="80%">
<tr>
<td colspan="2" align="center"><input type="submit" value="Cerrar Período Seleccionado" /></td>
</tr>
</table>
</form>


<?php if (count($atencioness) > 0){ ?>
<table cellspacing="0" class="stats">
    <tr>
      <td colspan="6" width="100%">Se han encontrado <?php echo count($pacientess); ?> coincidencias de la búsqueda.</td>
    </tr>
    <tr>
      <td width="5%" align="center" class="hed">Período</td>
      <td width="35%" align="center" class="hed">Paciente</td>
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
      <td width="5%" align="center"><?php echo $item['mes'].'-'.$item['anio'] ?></td>
      <td width="35%" align="center"><?php echo $item['apellido'].', '.$item['nombre'].'('.$item['obrasocial'].')' ?></td>
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
<br>
<?php } ?>
</div>
