<script>
$(document).ready(function(){
	$('.mesa').datepicker({
		showOn: "button",
		buttonImage: "<?php echo $sf_request->getRelativeUrlRoot();?>/images/calendar.gif",
		buttonImageOnly: true,
		dateFormat: 'dd-mm-yy',
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
		dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		nextText: 'Siguiente',
		prevText: 'Anterior'
	});

	$(".botonCerrarCompleta").click(function(){   
		var elemento = $(this);
		var Id = elemento.attr("id");	
		var Hora = $('#hora'+Id).val()+":"+$('#minuto'+Id).val();
    	// Controla y cierra la mesa de examen
    	$.post("<?php echo url_for('mesasexamenes/cerrarmesa'); ?>",
    			{ idmesaexamen: Id, mesa: $('#mesa'+Id).val(), tipo: 1, hora: Hora, libro: $('#libro'+Id).val(), folio: $('#folio'+Id).val() },
    	    	function(data){
        	    	$('#formBuscar').submit(); 
        	    	alert(data);
        	    }
		);		
		return false;
	});   
	
	$(".botonCerrarVacia").click(function(){   
		var elemento = $(this);
		var Id = elemento.attr("id");			
    	// Controla y cierra la mesa de examen
    	$.post("<?php echo url_for('mesasexamenes/cerrarmesa'); ?>",
    			{ idmesaexamen: Id, tipo: 2 },
    	    	function(data){
        	    	$('#formBuscar').submit(); 
        	    	alert(data);
        	    }
		);		
		return false;
	}); 
	  
	$(".botonEliminarVacia").click(function(){   
		var elemento = $(this);
		var Id = elemento.attr("id");			
    	// Controla y cierra la mesa de examen
    	$.post("<?php echo url_for('mesasexamenes/eliminarmesa'); ?>",
    			{ idmesaexamen: Id },
    	    	function(data){
        	    	//$('#formBuscar').submit(); 
        	    	alert(data);
					// obtener la lista de estudios previos de la persona
					cargarMesasExamenes(<?php echo $idplanestudio; ?>);	        	    	
        	    }
		);		
		return false;
	}); 	 	 	
});

//Cargar estudios previos
function cargarMesasExamenes(id){
	// obtener la lista de estudios previos de la persona
	$.get("<?php echo url_for('mesasexamenes/obtenermesaspendientes'); ?>",
	    { idplanestudio: id },
		function(data){
			$('#mesasexamenes').html(data);
		}
	);   	
} 
</script>
<h1>Cerrar Mesas de Examenes</h1>
<br>
<div align="center">
<table cellspacing="0" class="stats" width="1000">
	<tr>
		<td colspan="2" class="hed">Mesas de examen completas:</td>
	</tr>
	<tr>
		<td colspan="2">
			<table cellspacing="0" class="stats" width="100%">
				<thead>
					<tr>
						<td class="hed" align="center" width="5%">Id</td>
						<td class="hed" align="center">Materia</td>
						<td class="hed" align="center" width="15%">Fecha</td>
						<td class="hed" align="center" width="15%">Hora</td>	      
						<td class="hed" align="center" width="17%">Libro</td>
						<td class="hed" align="center" width="5%">Folio</td>	      	      
						<td class="hed" align="center">Total</td>
						<td class="hed" align="center">Condición</td>
						<td class="hed" align="center">Acciones</td>
					</tr>
				</thead>
				<tbody>
				<?php if (count($mesasexamenes)>0) {?>		  
					<?php foreach ($mesasexamenes as $mesa): ?>	
						<tr>    	
							<td align="center" width="5%"><?php echo $mesa->idmesaexamen ?></td>
							<td><?php echo $mesa->getCatedras()->getMateriasPlanes() ?></td>
							<td width="15%">
								<?php 
								$arr = explode('-', $mesa->fecha);
								$fecha = $arr[2]."-".$arr[1]."-".$arr[0]; 
								?>								
								<input size="9" type="text" class="mesa" id="mesa<?php echo $mesa->idmesaexamen; ?>" value="<?php echo $fecha; ?>" />
							</td>
							<td width="15%" align="center">
								<?php $horamesaexamen = explode(":",$mesa->hora); ?>
								<select id="hora<?php echo $mesa->idmesaexamen; ?>">
								<?php foreach ($horas as $hora) { ?>
									<?php if (strlen($hora)==1) { $hora = "0".$hora; } ?>
									<option value="<?php echo $hora; ?>" <?php if ($horamesaexamen[0]==$hora) echo "SELECTED"; ?>><?php echo $hora; ?></option>
								<?php } ?>
								</select>:
								<select id="minuto<?php echo $mesa->idmesaexamen; ?>">
								<?php foreach ($minutos as $minuto){ ?>
									<?php if (strlen($minuto)==1) { $minuto = "0".$minuto; } ?>  				
									<option value="<?php echo $minuto; ?>" <?php if ($horamesaexamen[1]==$minuto) echo "SELECTED"; ?>><?php echo $minuto; ?></option>
								<?php } ?>
								</select>			 
							</td>
							<td width="10%" align="center">
								<select id="libro<?php echo $mesa->idmesaexamen; ?>">
								<?php foreach ($libros as $libro){ ?>
									<option value="<?php echo $libro->getIdlibroacta(); ?>" <?php if ($mesa->libro==$libro->getIdlibroacta()){ echo "SELECTED";} ?>><?php echo $libro->getDescripcion(); ?></option>
								<?php } ?>
								</select>
							</td>
							<td width="5%" align="center"><input type="text" id="folio<?php echo $mesa->idmesaexamen; ?>" maxlength="2" size="2" value="<?php echo $mesa->folio; ?>" /></td>
							<td align="center"><?php echo $mesa->cantidad; ?></td>
							<td align="center"><?php echo $mesa->getCondicionesMesas(); ?></td>
							<td align="center">
								<form id="formCerrarCompleta">		      
									<input class="botonCerrarCompleta" id="<?php echo $mesa->idmesaexamen; ?>" type="submit" value="Cerrar">
								</form> 		      		
							</td>
						</tr>
					<?php endforeach; ?>
				<?php } else { ?>
					<tr>
						<td colspan="9" align="center">No existen mesas de examenes.</td>
					</tr>		    
				<?php } ?>		    
				</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="hed">Mesas de examen vacias:</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<table cellspacing="0" class="stats" width="100%">
				<thead>
					<tr>
						<td class="hed" align="center" width="5%">Id</td>
						<td class="hed" align="center">Materia</td>
						<td class="hed" align="center" width="17%">Fecha</td>
						<td class="hed" align="center" width="5%">Condición</td>
						<td class="hed" align="center" width="5%">Acciones</td>
					</tr>
				</thead>
				<tbody>
				<?php if (count($mesasexamenesvacias)>0) { ?>
					<?php foreach ($mesasexamenesvacias as $mesa): ?>
						<tr>
							<td align="center" width="5%"><?php echo $mesa->idmesaexamen; ?></td>
							<td><?php echo $mesa->getCatedras()->getMateriasPlanes(); ?></td>
							<td align="center" width="10%">
							<?php 
								$arr = explode('-', $mesa->fecha);
								$fecha = $arr[2]."-".$arr[1]."-".$arr[0]; 
							?>	
							<?php echo $fecha." - ".$mesa->hora; ?>
							</td>
							<td align="center" width="5%"><?php echo $mesa->getCondicionesMesas(); ?></td>
							<td align="center">
								<form action="" id="formCerrarVacia" >
									<input class="botonCerrarVacia" id="<?php echo $mesa->idmesaexamen; ?>" type="submit" value="Cerrar">
									<input class="botonEliminarVacia" id="<?php echo $mesa->idmesaexamen; ?>" type="submit" value="Eliminar">
								</form>	
							</td>
						</tr>    
					<?php endforeach; ?>
				<?php } else { ?>
					<tr>
						<td colspan="5" align="center">No existen mesas de examenes vacias.</td>
					</tr>		    
				<?php } ?>		    
				</tbody>
			</table>
		</td>
	</tr>  
</table>
</div>	
	<p align="center"><input type="button" value="Volver" onclick="location.href='<?php echo url_for('mesasexamenes/cerrar') ?>'"></p>
<br>