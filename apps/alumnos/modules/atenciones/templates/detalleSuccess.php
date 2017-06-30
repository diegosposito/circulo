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
<h1 align="center" style="color:black;">Detalle Atenciones Cerradas</h1>
<br>
<h3 align="center" style="color:black;"><?php echo $profesional[0]['apellido'].', '.$profesional[0]['nombre'] ?></h3>

<div align="center">


<form action="<?php echo url_for('atenciones/consultar') ?>" method="post">
<table cellspacing="0" class="stats" width="80%">
<tr>
<td colspan="2" align="center"><input type="submit" value="Volver" /></td>
</tr>
</table>

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
      <td width="15%" align="center" class="hed">Coseguro</td>
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
      <td width="15%" align="center"><?php echo $item['coseguro'] ?></td>
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