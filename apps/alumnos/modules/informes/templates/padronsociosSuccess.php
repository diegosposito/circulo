
<br>
 <table  style="border:1px solid #666666; border-radius: 15px; "  cellpadding="0" width="100%" cellspacing="0">
	        	<tr>
	        		<td align="center" ><h1>Imprimir Padron de Socios</h1>
</td>
			</tr>
</table>


<br>
<div align="center">
<form action="<?php echo url_for('informes/padronsociospdf') ?>" method="post">
  <table cellspacing="0" class="stats" width="70%">
    <tfoot>
      <tr>
        <td colspan="2" align="center">
          <input type="submit" value="Aceptar" />
        </td>
      </tr>
    </tfoot>
    <tbody>
    <?php if ($mensaje) {?>
      <tr>
        <td colspan="2">
          <b><font color="red"><div id="mensaje"><?php echo $mensaje; ?></div></font></b>
        </td>
      </tr>    
     <?php } ?>
     <?php echo $form ?>
    </tbody>
  </table>
</form>
</div>
