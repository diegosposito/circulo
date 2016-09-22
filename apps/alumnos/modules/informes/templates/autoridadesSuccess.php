 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <br>
  <h1 style="color:#7dbf0d;font-size:24px">Institucionales </h1>
  <h2 style="color:#7dbf0d;font-size:20px">Autoridades del Círculo Odontológico de C. del Uruguay </h2>

<h3 style="font-size:16px">NÓMINA DE LAS AUTORIDADES ELECTAS ASAMBLEA GENERAL ORDINARIA</h3>
 <a target="_blank" href="<?php echo url_for('informes/autoridadespdf') ?>"><img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/printer.png' align='center' size='20' /></a>
 <br>
 <?php $idcargoautoridad = 0; ?>

<?php foreach ($autoridadess as $autoridades){ 
         if($idcargoautoridad<>0 && $autoridades->getIdcargoautoridad()<>$idcargoautoridad){ ?>
               </tbody>
               </table>
               <br>
          <?php } 

        if ($autoridades->getIdcargoautoridad()<>$idcargoautoridad){ 
            $idcargoautoridad = $autoridades->getIdcargoautoridad();
            $i=0; ?>

              <table align="center" width="550px" cellspacing="0" class="stats">
              <thead>
               <tr>
               <td colspan="2" width="100%" align="left" class="hed"><?php echo $autoridades->getCargoAutoridades()->getNombre(); ?></td>
               </tr>
              </thead>
              <tbody>
  <?php } //endif ?>       
             
             <tr class="fila_<?php echo $i%2 ; ?>">
             <td width="20%" align="center">&nbsp;</td>
             <td width="80%" align="left"><?php echo $autoridades->getNombre() ?></td>
            </tr>
            <?php $i++; ?>

<?php } //endforeach ?>

       
  </tbody>
  </table>  