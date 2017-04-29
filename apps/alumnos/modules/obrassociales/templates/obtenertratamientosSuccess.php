<?php
if (count($tratamientos) > 0){
	//el bucle para cargar las opciones
	foreach ($tratamientos as $tratamiento){
		echo "<option value=".$tratamiento['id'].">".$tratamiento['tratamiento']."</option>";
	}
}
?>