<?php
if (count($planes) > 0){
	//el bucle para cargar las opciones
	foreach ($planes as $plan){
		if ($plan->getId()==$idplan){
			 echo "<option value=".$plan->getId().">".$plan->getNombre()."</option>";
		} else {
			 echo "<option value=".$plan->getId()." selected>".$plan->getNombre()."</option>";
		}

	}
}
?>
