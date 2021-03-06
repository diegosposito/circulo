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
<h1 align="center" style="color:black;">Ver Historial de Facturación de : <?php echo $persona ?></h1>
<a href="<?php echo url_for('atenciones/index') ?>"><?php echo "<< Volver" ?></a>
<div align="center">
<form action="<?php echo url_for('atenciones/verhistorialfacturacion') ?>" method="post">
  <input type="hidden" name="selectedtab" id="selectedtab" value="<?php echo $selectedtab ?>">
<table cellspacing="0" class="stats" width="30%">
<tr>
<td align="center">
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
<td colspan="2" align="center"><input type="submit" value="Actualizar" /></td>
</tr>
</table>

<?php if (count($facturacionss) > 0){ ?>
<table cellspacing="0" class="stats">
   
    <tr>
      <td width="25%" align="center" class="hed">Nro Factura</td>
      <td width="25%" align="center" class="hed">Fecha</td>
      <td width="25%" align="center" class="hed">Importe</td>
      <td width="15%" align="center" class="hed">Ver Detalle</td>
      <td width="10%" align="center" class="hed">Imprimir</td>
    </tr>
  </thead>
  <tbody>
          <?php $i=0; $total=0;?>
    <?php foreach($facturacionss as $item){ 
      $fecha_formateada = date("d/m/Y", strtotime($item['fecha'])); ?>
    <tr class="fila_<?php echo $i%2 ; ?>">
      <td width="25%" align="center"><?php echo $item['id'] ?></td>
      <td width="25%" align="center"><?php echo $fecha_formateada ?></td>
      <td width="25%" align="center"><?php echo $item['importe'] ?></td>
      <?php
        $method = "aes-256-cbc";
        $password = '1,3,5,7,9,abc';
        $id_encriptado = openssl_encrypt($item['id'], $method, $password);
      ?>
    <td align="center"><?php echo link_to("Ver Detalle", 'atenciones/verdetallefacturacion?id='.$id_encriptado ,'class="mhead"'); ?></td>
    
    <td width="20%" align="center"> <a target=_blank href="<?php echo url_for('atenciones/imprimirfact?id='.$item['id']) ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/print.png' align='center' size='20'  height='20' width="20"  /></a></td>

      <?php $total += $item['importe']; ?>
      
    </tr>
          <?php $i++; ?>
    <?php } ?>

   <tr>
      <td colspan=3 />Total : </td>
      <td width="15%" align="center" class="hed"><?php echo "$ ".$total; ?></td>
    </tr>

   <br>
  </tbody>
</table>

<br>
<?php } ?>
</div>
