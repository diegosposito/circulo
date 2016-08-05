<?php

/**
 * Comisiones
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    sig
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Comisiones extends BaseComisiones
{
    public function __toString() {
        return $this->getNombre();
    }	 

	public function obtenerFechas() {
	  	$asignaciones_clases = Doctrine_Core::getTable('AsignacionesClases')->findByIdcomision($this->getIdcomision());
  
		foreach($asignaciones_clases as $asignacion) {
			switch ($asignacion->getPeriodicidad()) {
				case 'S':
			    	$periodicidad = new DateInterval("P1W");
			        break;
			    case 'Q':
			        $periodicidad = new DateInterval("P2W");
			        break;
			    case 'M':
			        $periodicidad = new DateInterval("P1M");
			        break;
			}
			      
			switch ($asignacion->getDia()) {
				case 'L':
			    	$dia = ' next Monday';
			        break;
			    case 'M':
			        $dia = ' next Tuesday';
			        break;
			    case 'I':
			        $dia = ' next Wednesday';
			        break;
			    case 'J':
			        $dia = ' next Thursday';
			        break;
			    case 'V':
			        $dia = ' next Friday';
			        break;
			    case 'S':
			        $dia = ' next Saturday';
			        break;
			    case 'D':
			        $dia = ' next Sunday';
			        break;
			}
					
			$inicio = date('Y-m-d', strtotime($asignacion->getInicio(). $dia));
			$fechaInicio = new DateTime($inicio);
			
			$fechaFin = new DateTime($asignacion->getFin());		
			$fechas = new DatePeriod($fechaInicio, $periodicidad, $fechaFin);
			foreach($fechas as $fecha){
	  			$anioActual = date("Y");
	  			if($fecha->format("Y") == $anioActual) {
	  				$arregloFechas[] = $fecha->format("Y-m-d");
	  			}
			}	
		}		
		rsort($arregloFechas);
		return $arregloFechas;
	}   
	
	// Controlar la superposicion horaria
	public function controlarHorarios($idcomision) {
		// Buscar si hay cupo en la comision
		$resultado = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc("
			SELECT
				a1.idasignacion AS idinscripto, a2.idasignacion AS idnoinscripto
			FROM asignaciones_clases a1
			INNER JOIN (
    			SELECT *
    			FROM asignaciones_clases a
    			WHERE a.idcomision=".$this->getIdcomision()."
			) AS a2 ON a1.dia=a2.dia
			WHERE a1.idcomision=".$idcomision." 
			and !((TIME_TO_SEC(a1.horafin)<=TIME_TO_SEC(a2.horainicio)) or (TIME_TO_SEC(a2.horafin)<=TIME_TO_SEC(a1.horainicio)))
			and !((DATE(a1.fin)<=DATE(a2.inicio)) or (DATE(a2.fin)<=DATE(a1.inicio))) 	
			and a1.idcomision!=a2.idcomision
		");
	
		return $resultado;
	}
	
	// obtener la cantidad de alumnos inscriptos en una comision en el presente año
	public function obtenerCantidadInscriptos() {
		// Buscar si hay cupo en la comision
		$resultado = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc("
			SELECT * 
				FROM alu_mat AM 
				WHERE
					AM.idestadomateria=1 
					AND AM.idcomision = ".$this->getIdcomision()."
					AND AM.fecha > concat(year(now()), '-1-1')
		");
		
		return count($resultado);
    }	
}
