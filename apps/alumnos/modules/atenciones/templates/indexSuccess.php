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
<h1 align="center" style="color:black;">Consulta Pacientes</h1>
<br>
<table cellspacing="0" width="80%">

<?php if ( $sf_user->getGuardUser()->getIsSuperAdmin()) { ?>
<tr>
<td colspan="2" align="left">
       <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
       <a href="<?php echo url_for('actualizacionesaten/masivas') ?>"><b>Gestión Masiva de Atenciones</b></a>
</td>
</tr>

<tr>
<td colspan="2" align="left">
       <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
       <a href="<?php echo url_for('atenciones/revisarperiodos') ?>"><b>Revisar Períodos Cerrados</b></a>
</td>
</tr>
<?php } ?>

<tr>
<td colspan="2" align="left">
       <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
       <a href="<?php echo url_for('atenciones/consultar') ?>"><b>Consulta Atenciones x Período</b></a>
</td>
</tr>
<tr>
<td colspan="2" align="left">
       <img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/new.png' align='center' size='20' />
       <a href="<?php echo url_for('atenciones/cerrar') ?>"><b>Cierre de Períodos</b></a>
</td>
</tr>
</table>
<div align="center">
<form action="<?php echo url_for('atenciones/index') ?>" method="post">
<table cellspacing="0" class="stats" width="80%">
<tr>
<td><b>Apellido/DNI:</b></td>
<td align="left"><INPUT type="text" id="idbuscarname" name="idbuscarname" size="30" value="<?php echo  $criterio  ?>"></td>
</tr>
<tr>
<?php $tipobusqueda = array(1 => 'Apellido', 2 => 'D.N.I.'); ?>
<td><b>Tipo búsqueda:</b></td>
<td align="left">
  <SELECT name="idtipobusqueda" id="idtipobusqueda">
  <?php if (count($tipobusqueda) > 0) {
    //el bucle para cargar las opciones
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
<br>
</table>
<br>

</form>

<?php if (count($pacientess) > 0){ ?>
<table cellspacing="0" class="stats">
    <tr>
      <td colspan="6" width="100%">Se han encontrado <?php echo count($pacientess); ?> coincidencias de la búsqueda.</td>
    </tr>
    <tr>
      <td width="35%" align="center" class="hed">Paciente</td>
      <td width="25%" align="center" class="hed">Obra Social</td>
      <td width="15%" align="center" class="hed">Nro Afiliado</td>
      <td width="15%" align="center" class="hed">Documento</td>
      <td width="10%" align="center" class="hed">Edicion</td>
    </tr>
  </thead>
  <tbody>
          <?php $i=0; ?>
    <?php foreach($pacientess as $item){ ?>
    <tr class="fila_<?php echo $i%2 ; ?>">
    <td width="40%" align="left"><a href="#" class="tooltip"><div style="align: left;"><?php echo $item['apellido'].', '.$item['nombre'] ?><span><img style="align:center; width: 110px; height: 110px;" src='<?php echo $sf_request->getRelativeUrlRoot();?>/files/pacientes/<?php echo $item['id'];?>/<?php echo $item['imagefile'];?>' /><br>
      <strong><?php echo $item['apellido'].', '.$item['nombre'] ?></strong><br>
      <strong><?php echo 'Email: ' ?></strong><?php echo $item['email'] ?><br>
      <strong><?php echo "Historial" ?></strong><br>
      <?php echo htmlspecialchars_decode($item['historial']) ?></span></div"></a>
    </td>
      <td width="25%" align="center"><?php echo $item['abreviada'] ?></td>
      <td width="15%" align="center"><?php echo $item['nroafiliado'] ?></td>
      <td width="15%" align="center"><?php echo $item['nrodoc'] ?></td>
      <td align="center"><?php echo link_to("Atenciones", 'atenciones/editar?id='.$item['id'] ,'class="mhead"'); ?></td>
    </tr>
          <?php $i++; ?>
    <?php } ?>

   <br>
  </tbody>
</table>
<br>
<?php } ?>
</div>
