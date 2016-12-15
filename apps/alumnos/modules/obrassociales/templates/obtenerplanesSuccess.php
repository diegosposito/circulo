<?php
if (count($planes) > 0){
	//el bucle para cargar las opciones
	foreach ($planes as $plan){
		echo "<option value=".$plan->getId().">".$plan->getNombre()."</option>";
	}
}
?>