 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <br>
  <h1 style="align:center;color:#7dbf0d;font-size:24px">Institucionales -> Saludent </h1>
  
<div align="center"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/saludent.jpg' width='200px' height='150px' />
</div>

<p style="margin-left: 3em;">Es el nombre del Sistema de prestaciones de Salud odontológico solidario, creado por el <strong>Círculo Odontológico de Concepción del Uruguay.</strong>
<br>Tiene como característica fundamental poner a disposición del afiliado la libre elección del profesional odontólogo en el ámbito del Departamento Uruguay.</p>
<?php foreach ($contenidoss as $contenido){ ?>
<p style="margin-left: 3em;"><?php echo html_entity_decode($contenido->getDescripcion()); ?></p>
<?php } ?>
<br>
<div align="center">
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

              <table style="align:center;padding-left:10px;" width="550px" cellspacing="0" class="stats">
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
</div>   
<br>
 <p style="margin-left: 3em;">Urgencias Odontológicas: 15 629 345 </p>
 <br>
 <p style="margin-left: 3em;"><strong>Promoción: Pago de cuotas, Tratamientos de Prótesis, Implantes, Ortodoncia, Ortopedia
 con Tarjeta de Crédito hasta 12 cuotas </strong></p>