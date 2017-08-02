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
<h1 align="center" style="color:black;">Resume de Período de Atenciones</h1>
<br>
<div align="center">


<form action="<?php echo url_for('atenciones/revisarperiodos') ?>" method="post">
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
<?php if($sf_user->getGuardUser()->getIsSuperAdmin()){ ?>
</tr>
<td><b>Mes:</b></td>
<td align="left">
<select name="idmes" id="idmes">
    <?php if (count($aMeses) > 0){
      //echo "<option value='0' selected='selected' >----SELECCIONAR----</option>";
      foreach ($aMeses as $k => $v){
        if($k==$idmes){
            echo "<option value=".$k." selected='selected'>".$v."</option>";
        } else {
            echo "<option value=".$k.">".$v."</option>";
        }
      }
    } ?>
</select>
  </td>
</tr>
<?php } ?>
<tr>
<td colspan="2" align="center"><input type="submit" value="Buscar" /></td>
</tr>
</table>

<div align="left">
<a title="Ver Detalle" href="<?php echo url_for('atenciones/detalleabiertas?idmatricula='.$idmatricula) ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/edit.png' align='center' size='20'  height='20' width="20"  /><b>Atenciones Abiertas</b></a>
</div>

<?php
  if (count($atencioness) > 0){ ?>
  <table cellspacing="0" class="stats">
      <tr>
        <td colspan="6" width="100%">Detalle de atenciones del período seleccionado. Puede <b>Generar Archivo</b> para acceder a la información detallada.<br> Se han encontrado <?php echo count($atencioness); ?> coincidencias de la búsqueda.</td>
      </tr>
      <tr>
        <td width="25%" align="center" class="hed">Obra Social</td>
        <td width="25%" align="center" class="hed">Paciente</td>
        <td width="25%" align="center" class="hed">Profesional</td>
        <td width="5%" align="center" class="hed">Fecha Atención</td>
        <td width="10%" align="center" class="hed">Importe</td>
        <td width="10%" align="center" class="hed">Coseguro</td>
      </tr>
    </thead>
    <tbody>
            <?php $i=0; ?>
      <?php foreach($atencioness as $item){ 
          $fecha_formateada = date("d/m/Y", strtotime($item['fecha'])); ?>
      <tr class="fila_<?php echo $i%2 ; ?>">
        <td width="25%" align="center"><?php echo $item['obrasocial'] ?></td>
        <td width="25%" align="center"><?php echo $item['paciente'] ?></td>
        <td width="25%" align="center"><?php echo $item['profesional'] ?></td>
        <td width="5%" align="center"><?php echo $fecha_formateada; ?></td>
        <td width="10%" align="center"><?php echo $item['importe'] ?></td>
        <td width="10%" align="center"><?php echo $item['coseguro'] ?></td>
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
