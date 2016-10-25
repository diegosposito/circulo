 <style type="text/css">
    p { margin-left:5em; /* Or another measurement unit, like px */ }
  </style>
  <br>
  <h1 style="color:#7dbf0d;font-size:24px">Institucionales </h1>
  <h2 style="color:#7dbf0d;font-size:20px">Saludent </h2>

<h3 style="font-size:16px">Nómina de las autoridades electas Asamblea General Ordinaria</h3>

<img src='<?php echo $sf_request->getRelativeUrlRoot();?>/images/printer.png' align='center' size='20' />

<p>Es el nombre del Sistema de prestaciones de Salud odontológico solidario, creado por el Círculo Odontológico de Concepción del Uruguay. Tiene como característica fundamental poner a disposición del afiliado la libre elección del profesional odontólogo en el ámbito del Departamento Uruguay.
Podrán ser beneficiarios del sistema en carácter de asociados aquellos que opten voluntariamente ingresar completando la solicitud de admisión correspondiente.
</p> 
<p>Cuota Mensual por Persona $ 150,00 – 3 meses de carencia – 2 prácticas por mes – No se paga Plus
Libre Elección del Profesional – Más de 80 Odontólogos </p>


<p>NOMENCLADOR Y COSEGUROS</p>

 <br>
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
               <td colspan="2" width="100%" align="left" class="hed"><?php echo $practicas->getTipoPracticas()->getNombre(); ?></td>
               </tr>
              </thead>
              <tbody>
  <?php } //endif ?>       
             
             <tr class="fila_<?php echo $i%2 ; ?>">
             <td width="20%" align="center">&nbsp;</td>
             <td width="80%" align="left"><?php echo $practicas->getNombre() ?></td>
            </tr>
            <?php $i++; ?>

<?php } //endforeach ?>

       
  </tbody>
  </table>  