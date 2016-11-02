 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <br>
  <h1 style="color:#7dbf0d;font-size:24px">Institucionales </h1>
  <h2 style="color:#7dbf0d;font-size:20px">Saludent </h2>

<div align="center"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/saludent.jpg' width='200px' height='150px' />
</div>
<p>Es el nombre del Sistema de prestaciones de Salud odontológico solidario, creado por el <strong>Círculo Odontológico de Concepción del Uruguay.</strong>
<br>Tiene como característica fundamental poner a disposición del afiliado la libre elección del profesional odontólogo en el ámbito del Departamento Uruguay.
<br>
<?php foreach ($contenidoss as $contenido){ 
echo html_entity_decode($contenido->getDescripcion()); 
}
?>
<br>
<p><strong>NOMENCLADOR Y COSEGUROS</strong></p>

 <?php $idtipopractica = 0; ?>

<?php foreach ($practicass as $practicas){ 
         if($idtipopractica<>0 && $practicas->getIdtipopractica()<>$idtipopractica){ ?>
               </tbody>
               </table>
               <br>
          <?php } 

        if ($practicas->getIdtipopractica()<>$idtipopractica){ 
            $idtipopractica = $practicas->getIdtipopractica();
            $i=0; ?>

              <table align="center" width="550px" cellspacing="0" class="stats">
              <thead>
               <tr>
               <td colspan="3" width="100%" align="left" class="hed"><?php echo $practicas->getTipoPracticas()->getNombre(); ?></td>
               </tr>
              </thead>
              <tbody>
  <?php } //endif ?>       
             
             <tr class="fila_<?php echo $i%2 ; ?>">
             <td width="10%" align="center"><?php echo $practicas->getCodigo() ?></td>
             <td width="80%" align="left"><?php echo $practicas->getNombre() ?></td>
             <td width="10%" align="center"><?php echo $practicas->getImporte() ?></td>
            </tr>
            <?php $i++; ?>

<?php } //endforeach ?>

       
  </tbody>
  </table>  
<br>
 <p>Urgencias Odontológicas: 15 629 345 </p>
 <br>
 <p><strong>Promoción: Pago de cuotas, Tratamientos de Prótesis, Implantes, Ortodoncia, Ortopedia
 con Tarjeta de Crédito hasta 12 cuotas </strong></p>