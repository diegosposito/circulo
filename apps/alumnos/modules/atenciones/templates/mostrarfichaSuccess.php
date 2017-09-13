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
<script>
$(document).ready(function(){
    // add multiple select / deselect functionality
    $("#selectall").click(function () {
          $('.case').attr('checked', this.checked);
    });
 
    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".case").click(function(){
        if($(".case").length == $(".case:checked").length) {
            $("#selectall").attr("checked", "checked");
        } else {
            $("#selectall").removeAttr("checked");
        }
    });   
    
});

</script>
<style type="text/css">
  p { margin-left:5em; /* Or another measurement unit, like px */ }
</style>
<br>
<div align="center">
<form action="<?php echo url_for('atenciones/facturar') ?>" method="post">
  <input type="hidden" name="selectedtab" id="selectedtab" value="<?php echo $selectedtab ?>">
  <input type="hidden" name="idpaciente" id="idpaciente" value="<?php echo $idpaciente ?>">
<table cellspacing="0" class="stats" width="80%">
<?php if(!$superadmin) { ?>
<tr>
<td colspan="2" align="center"><input type="submit" value="Generar Ficha con Atenciones Seleccionadas" /></td>
</tr>
<?php } ?>
</table>


<?php if (count($atencioness) > 0){ ?>
<table cellspacing="0" class="stats">
    <tr>
      <td align="center" class="hed"><input type="checkbox" id="selectall" checked /></td>
      <td width="50%" align="center" class="hed">Paciente</td>
      <td width="10%" align="center" class="hed">Fecha</td>
      <td width="15%" align="center" class="hed">Tratamiento</td>
      <td width="15%" align="center" class="hed">Importe</td>
    </tr>
  </thead>
  <tbody>
          <?php $i=0; $total=0;?>
    <?php foreach($atencioness as $item){ 
      $fecha_formateada = date("d/m/Y", strtotime($item['fecha'])); ?>
    <tr class="fila_<?php echo $i%2 ; ?>">
      <td align="center"><input type="checkbox" class="case" name="case[]" value="<?php echo $item['id'] ?>" <?php echo ($item['id'])?"checked":""; ?> /></td>
      <td width="50%" align="center"><?php echo $item['paciente'] ?></td>
      <td width="20%" align="center"><?php echo $fecha_formateada ?></td>
      <td width="25%" align="center"><?php echo $item['tratamiento'] ?></td>
      <td width="15%" align="center"><?php echo $item['importe'] ?></td>
      <?php $total += $item['importe']; ?>
      
    </tr>
          <?php $i++; ?>
    <?php } ?>

   <tr>
      <td colspan=4 />Total : </td>
      <td width="15%" align="center" class="hed"><?php echo "$ ".$total; ?></td>
    </tr>

   <br>
  </tbody>
</table>
</form>  
<br>
<?php } ?>
</div>
